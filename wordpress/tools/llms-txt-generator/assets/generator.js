/**
 * llms.txt generator engine, shared by every industry tool under /ai-tools/llms-txt-generator/.
 * The industry config (sections, rules, summary wording, example) is loaded first as window.VVLLMS
 * from <industry>/config.js. Everything runs in the browser: nothing typed here is sent anywhere.
 */
( function () {
	'use strict';
	var C = window.VVLLMS;
	var root = document.getElementById( 'vvg-app' );
	if ( ! C || ! root ) { return; }

	var KEY = 'vv-llms-' + C.slug + '-v2';
	var esc = function ( s ) { return String( s ).replace( /[&<>"']/g, function ( c ) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ]; } ); };
	var H = {
		list: function ( s ) { return String( s || '' ).split( ',' ).map( function ( x ) { return x.trim(); } ).filter( Boolean ); },
		joinAnd: function ( a ) { return a.length < 2 ? ( a[ 0 ] || '' ) : a.slice( 0, -1 ).join( ', ' ) + ' and ' + a[ a.length - 1 ]; },
		a: function ( w ) { return /^(uni|use|usu|eu|one)/i.test( w ) || ! /^[aeiou]/i.test( w ) ? 'a' : 'an'; },
		/* Country names that take "the" (the UAE, the UK). */
		places: function ( a ) { return a.map( function ( x ) { return /^(uae|uk|us|usa|gcc|united arab emirates|united kingdom|united states|netherlands|philippines|maldives)$/i.test( x ) ? 'the ' + x : x; } ); },
		lcFirst: function ( s ) { return s ? s.charAt( 0 ).toLowerCase() + s.slice( 1 ) : s; },
		type: function ( f ) { var t = C.types.filter( function ( x ) { return x[ 0 ] === f.type; } )[ 0 ] || C.types[ 0 ]; return t[ 2 ]; },
	};

	/* ---------- State ---------- */
	var uid = 1;
	function row( section, title, url, desc ) { return { id: uid++, section: section || C.sections[ 0 ][ 0 ], title: title || '', url: url || '', desc: desc || '' }; }
	function empty() {
		var f = { name: '', url: '', type: C.types[ 0 ][ 0 ], lang: 'English', otherLangs: '', chips: [], desc: '', founded: '', licences: '', facts: '' };
		( C.fields || [] ).forEach( function ( x ) { f[ x.key ] = ''; } );
		f.pages = ( C.startSections || [ C.sections[ 0 ][ 0 ], 'contact' ] ).map( function ( s ) { return row( s ); } );
		return f;
	}
	function example() {
		var f = empty(), e = C.example;
		Object.keys( e ).forEach( function ( k ) { if ( 'pages' !== k ) { f[ k ] = Array.isArray( e[ k ] ) ? e[ k ].slice() : e[ k ]; } } );
		f.pages = e.pages.map( function ( p ) { return row( p[ 0 ], p[ 1 ], p[ 2 ], p[ 3 ] ); } );
		return f;
	}
	var f = null;
	try {
		var saved = JSON.parse( localStorage.getItem( KEY ) );
		if ( saved && Array.isArray( saved.pages ) ) {
			f = Object.assign( empty(), saved );
			f.pages = saved.pages.map( function ( p ) { return row( p.section, p.title, p.url, p.desc ); } );
		}
	} catch ( e ) {}
	if ( ! f ) { f = empty(); }
	function save() { try { localStorage.setItem( KEY, JSON.stringify( f ) ); } catch ( e ) {} }

	/* ---------- Checks ---------- */
	var UTIL = /\/(login|log-in|signin|sign-in|signup|sign-up|register|account|my-account|cart|basket|checkout|wishlist|compare|thank-you|thanks|404|admin|wp-admin|wp-login\.php|staging)(\/|$|\.)/i;
	var SUPER = /\b(best|leading|no\.?\s?1|number one|world[- ]class|finest|unrivall?ed|ultimate|premier|top[- ]rated|must[- ]have|amazing|incredible|stunning|exceptional|unparalleled|discover|unlock)\b|#1\b/i;
	function host( u ) { var m = /^https?:\/\/([^/?#]+)/i.exec( u ); return m ? m[ 1 ].toLowerCase().replace( /^www\./, '' ) : ''; }

	function check( p ) {
		var hard = [], soft = [];
		var u = p.url.trim(), t = p.title.trim(), d = p.desc.trim();
		if ( ! u && ! t ) { return { hard: hard, soft: soft, empty: true }; }
		if ( ! t ) { hard.push( 'Add a page title.' ); }
		if ( ! u ) { hard.push( 'Add a URL.' ); }
		else if ( ! /^https?:\/\/[^\s/]+\.[^\s]+$/i.test( u ) ) { hard.push( 'Excluded: URL must be absolute (https://…).' ); }
		else {
			if ( /\?/.test( u ) ) { hard.push( 'Excluded: URLs with query strings or filters are left out.' ); }
			if ( /\/page\/\d+\/?$/i.test( u ) ) { hard.push( 'Excluded: pagination URL.' ); }
			if ( UTIL.test( u ) ) { hard.push( 'Excluded: utility page (login, account, cart, thank-you…).' ); }
			( C.urlRules || [] ).forEach( function ( r ) { if ( r.re.test( u ) ) { ( r.hard ? hard : soft ).push( r.msg ); } } );
			var site = host( f.url.trim() ), h = host( u );
			if ( site && h && h !== site && h.slice( -( site.length + 1 ) ) !== '.' + site ) { soft.push( 'This URL is on a different domain from the website.' ); }
		}
		if ( ! d ) { soft.push( 'Add a one-line description.' ); }
		else {
			var w = d.split( /\s+/ ).length;
			if ( w < 5 || w > 30 ) { soft.push( 'Aim for roughly 8–25 words.' ); }
			if ( SUPER.test( d ) || ( C.superlatives && C.superlatives.test( d ) ) ) { soft.push( C.superMsg || 'Remove superlatives and marketing language — keep it factual.' ); }
			( C.descRules || [] ).forEach( function ( r ) { if ( r.re.test( d ) ) { soft.push( r.msg ); } } );
		}
		return { hard: hard, soft: soft };
	}
	function cleanTitle( t, brand ) {
		t = t.trim().replace( /\s+\|\s+[^|]*$/, '' );
		if ( brand ) { t = t.replace( new RegExp( '\\s+[-–—]\\s+' + brand.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' ) + '$', 'i' ), '' ); }
		return t.trim();
	}

	/* ---------- Build the file ---------- */
	function sectionLabel( key, label ) { return C.sectionLabel ? C.sectionLabel( key, label, f ) : label; }
	function build() {
		var name = f.name.trim() || C.nameFallback || 'Business name';
		var out = [ '# ' + name, '' ];
		var summary = f.desc.trim().replace( /\s+/g, ' ' ) || C.summary( f, H, name );
		out.push( '> ' + summary, '' );
		var facts = [];
		if ( f.founded.trim() ) { facts.push( 'Founded in ' + f.founded.trim() ); }
		f.licences.split( /\n|;/ ).map( function ( x ) { return x.trim(); } ).filter( Boolean ).forEach( function ( x ) { facts.push( x ); } );
		if ( C.facts ) { C.facts( f, H ).forEach( function ( x ) { facts.push( x ); } ); }
		f.facts.split( '\n' ).map( function ( x ) { return x.trim().replace( /^[-•*]\s*/, '' ); } ).filter( Boolean ).forEach( function ( x ) { facts.push( x ); } );
		var others = H.list( f.otherLangs );
		if ( others.length ) { facts.push( ( C.langFact || 'Website available in ' ) + H.joinAnd( [ f.lang.trim() || 'English' ].concat( others ) ) ); }
		if ( facts.length ) { facts.forEach( function ( x ) { out.push( '- ' + x ); } ); out.push( '' ); }

		var seen = {}, links = 0, skipped = 0, counts = {};
		C.sections.forEach( function ( s ) {
			var items = [];
			f.pages.forEach( function ( p ) {
				if ( p.section !== s[ 0 ] ) { return; }
				var c = check( p );
				if ( c.empty ) { return; }
				var u = p.url.trim().replace( /#.*$/, '' ), k = u.replace( /\/$/, '' );
				if ( c.hard.length || seen[ k ] || links >= 150 ) { skipped++; return; }
				seen[ k ] = true;
				var d = p.desc.trim().replace( /\s+/g, ' ' );
				items.push( '- [' + ( cleanTitle( p.title, name ) || p.title.trim() ) + '](' + u + ')' + ( d ? ': ' + d : '' ) );
				links++;
			} );
			counts[ s[ 0 ] ] = items.length;
			if ( items.length ) { out.push( '## ' + sectionLabel( s[ 0 ], s[ 1 ] ) ); items.forEach( function ( x ) { out.push( x ); } ); out.push( '' ); }
		} );
		var notices = [];
		( C.limits || [] ).forEach( function ( l ) {
			var n = l.keys.reduce( function ( a, k ) { return a + ( counts[ k ] || 0 ); }, 0 );
			if ( n > l.max ) { notices.push( l.msg ); }
		} );
		if ( links >= 150 ) { notices.push( 'The file is capped at 150 links. Keep the most useful hub pages.' ); }
		return { text: out.join( '\n' ).trim() + '\n', links: links, skipped: skipped, notices: notices };
	}

	/* ---------- Render ---------- */
	function field( key, label, ph, type ) {
		return '<label class="vvg-field"><span>' + esc( label ) + '</span><input type="' + ( type || 'text' ) + '" data-f="' + key + '" placeholder="' + esc( ph || '' ) + '" value="' + esc( f[ key ] || '' ) + '"></label>';
	}
	function area( key, label, ph ) {
		return '<label class="vvg-field vvg-wide"><span>' + esc( label ) + '</span><textarea rows="3" data-f="' + key + '" placeholder="' + esc( ph || '' ) + '">' + esc( f[ key ] || '' ) + '</textarea></label>';
	}
	function head( step, title, aside ) {
		return '<div class="vvg-card-head"><div><span class="vvg-step">' + esc( step ) + '</span><h2>' + esc( title ) + '</h2></div>' + ( aside || '' ) + '</div>';
	}
	function sectionOptions( sel ) {
		return C.sections.map( function ( s ) { return '<option value="' + s[ 0 ] + '"' + ( s[ 0 ] === sel ? ' selected' : '' ) + '>' + esc( C.sectionOptionLabel ? C.sectionOptionLabel( s[ 0 ], s[ 1 ] ) : s[ 1 ] ) + '</option>'; } ).join( '' );
	}
	function rowHtml( p ) {
		return '<div class="vvg-row" data-id="' + p.id + '">' +
			'<div class="vvg-row-top"><select data-k="section" aria-label="Section">' + sectionOptions( p.section ) + '</select>' +
			'<button type="button" class="vvg-x" data-act="remove" aria-label="Remove page"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M2 2l8 8M10 2l-8 8"/></svg></button></div>' +
			'<div class="vvg-row-pair"><input type="text" data-k="title" aria-label="Page title" placeholder="Page title" value="' + esc( p.title ) + '">' +
			'<input type="url" data-k="url" aria-label="Page URL" placeholder="' + esc( C.urlPh || 'https://example.com/about/' ) + '" value="' + esc( p.url ) + '"></div>' +
			'<input type="text" data-k="desc" aria-label="Description" placeholder="One factual sentence: what the page contains." value="' + esc( p.desc ) + '">' +
			'<ul class="vvg-issues" aria-live="polite"></ul></div>';
	}

	function render() {
		var main = [ field( 'name', C.nameLabel, C.namePh ), field( 'url', 'Website URL', 'https://example.com', 'url' ),
			'<label class="vvg-field"><span>' + esc( C.typeLabel ) + '</span><select data-f="type">' + C.types.map( function ( t ) { return '<option value="' + t[ 0 ] + '"' + ( t[ 0 ] === f.type ? ' selected' : '' ) + '>' + esc( t[ 1 ] ) + '</option>'; } ).join( '' ) + '</select></label>' ]
			.concat( ( C.fields || [] ).map( function ( x ) { return field( x.key, x.label, x.ph ); } ) )
			.concat( [ field( 'lang', 'Primary language', 'English' ), field( 'otherLangs', 'Other languages', 'Arabic' ) ] );
		var chips = C.chips ? '<div class="vvg-chips-wrap"><span class="vvg-label">' + esc( C.chips.label ) + '</span><div class="vvg-chips">' +
			C.chips.options.map( function ( o ) { return '<button type="button" class="vvg-chip" data-chip="' + esc( o ) + '" aria-pressed="' + ( f.chips.indexOf( o ) > -1 ) + '">' + esc( o ) + '</button>'; } ).join( '' ) + '</div></div>' : '';
		root.innerHTML =
			'<div class="vvg-grid">' +
				'<div class="vvg-col">' +
					'<div class="vvg-card">' + head( 'Step 1', C.step1 || 'Business' ) + '<div class="vvg-fields">' + main.join( '' ) + '</div>' + chips + '</div>' +
					'<div class="vvg-card">' + head( 'Step 2 · Optional', 'Summary and key facts' ) +
						area( 'desc', 'Short description', '1–3 factual sentences. Leave blank to write it from the fields above.' ) +
						'<div class="vvg-fields">' + field( 'founded', 'Founded year', C.foundedPh || '2012' ) + field( 'licences', C.licenceLabel, C.licencePh ) + '</div>' +
						area( 'facts', 'Other facts, one per line', C.factsPh || 'Only verifiable facts.' ) + '</div>' +
					'<div class="vvg-card">' + head( 'Step 3', 'Key pages', '<span class="vvg-count"></span>' ) +
						'<p class="vvg-help">' + esc( C.pagesHelp ) + '</p><div class="vvg-rows">' + f.pages.map( rowHtml ).join( '' ) + '</div>' +
						'<button type="button" class="vvg-add" data-act="add"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M7 1v12M1 7h12"/></svg>Add page</button></div>' +
				'</div>' +
				'<aside class="vvg-side"><div class="vvg-out">' +
					'<div class="vvg-out-head"><div><span class="vvg-out-title">llms.txt</span><span class="vvg-stats"></span></div>' +
					'<div class="vvg-out-actions"><button type="button" class="vvg-btn-ghost" data-act="copy">Copy</button><button type="button" class="vvg-btn-blue" data-act="download">Download</button></div></div>' +
					'<ul class="vvg-notices"></ul><pre class="vvg-pre" tabindex="0" aria-label="Generated llms.txt"></pre></div>' +
					'<p class="vvg-note">Upload the file to your site root so it resolves at <span class="vvg-file"></span>. Everything runs in your browser; nothing you type is sent anywhere.</p>' +
				'</aside>' +
			'</div>';
		root.querySelectorAll( '.vvg-row' ).forEach( paintRow );
		update();
	}
	function paintRow( el ) {
		var p = find( el );
		var c = check( p ), msgs = c.empty ? [] : c.hard.concat( c.soft );
		var ul = el.querySelector( '.vvg-issues' );
		ul.innerHTML = msgs.map( function ( m ) { return '<li' + ( /^Excluded/.test( m ) ? ' class="vvg-ex"' : '' ) + '>' + esc( m ) + '</li>'; } ).join( '' );
		el.classList.toggle( 'vvg-row-excluded', ! c.empty && c.hard.length > 0 );
	}
	function update() {
		var r = build();
		root.querySelector( '.vvg-pre' ).textContent = r.text;
		root.querySelector( '.vvg-stats' ).textContent = r.links + ( 1 === r.links ? ' link' : ' links' ) + ( r.skipped ? ' · ' + r.skipped + ' excluded' : '' ) + ( r.links && r.links < 25 ? ' · 25–80 recommended' : '' );
		root.querySelector( '.vvg-notices' ).innerHTML = r.notices.map( function ( n ) { return '<li>' + esc( n ) + '</li>'; } ).join( '' );
		root.querySelector( '.vvg-count' ).textContent = f.pages.length + ( 1 === f.pages.length ? ' page' : ' pages' );
		root.querySelector( '.vvg-file' ).textContent = ( f.url.trim().replace( /\/+$/, '' ) || 'https://yoursite.com' ) + '/llms.txt';
		return r;
	}
	function find( el ) { var id = +el.getAttribute( 'data-id' ); return f.pages.filter( function ( p ) { return p.id === id; } )[ 0 ]; }

	/* ---------- Events ---------- */
	function onInput( e ) {
		var t = e.target, rowEl = t.closest( '.vvg-row' );
		if ( rowEl && t.hasAttribute( 'data-k' ) ) {
			find( rowEl )[ t.getAttribute( 'data-k' ) ] = t.value;
			paintRow( rowEl );
		} else if ( t.hasAttribute( 'data-f' ) ) {
			f[ t.getAttribute( 'data-f' ) ] = t.value;
			if ( 'url' === t.getAttribute( 'data-f' ) ) { root.querySelectorAll( '.vvg-row' ).forEach( paintRow ); }
		} else { return; }
		save(); update();
	}
	root.addEventListener( 'input', onInput );
	root.addEventListener( 'change', onInput );
	root.addEventListener( 'click', function ( e ) {
		var chip = e.target.closest( '[data-chip]' );
		if ( chip ) {
			var v = chip.getAttribute( 'data-chip' ), i = f.chips.indexOf( v );
			if ( i > -1 ) { f.chips.splice( i, 1 ); } else { f.chips.push( v ); }
			chip.setAttribute( 'aria-pressed', String( i < 0 ) );
			save(); update(); return;
		}
		var b = e.target.closest( '[data-act]' );
		if ( ! b ) { return; }
		var act = b.getAttribute( 'data-act' );
		if ( 'remove' === act ) {
			var el = b.closest( '.vvg-row' ), p = find( el );
			f.pages = f.pages.filter( function ( x ) { return x !== p; } );
			el.remove(); save(); update();
		} else if ( 'add' === act ) {
			var last = f.pages[ f.pages.length - 1 ], n = row( last ? last.section : C.sections[ 0 ][ 0 ] );
			f.pages.push( n );
			root.querySelector( '.vvg-rows' ).insertAdjacentHTML( 'beforeend', rowHtml( n ) );
			root.querySelector( '.vvg-row:last-child [data-k="title"]' ).focus();
			save(); update();
		} else if ( 'copy' === act ) {
			var text = build().text, done = function () { b.textContent = 'Copied'; setTimeout( function () { b.textContent = 'Copy'; }, 1600 ); };
			if ( navigator.clipboard && navigator.clipboard.writeText ) { navigator.clipboard.writeText( text ).then( done, function () {} ); }
			else { var ta = document.createElement( 'textarea' ); ta.value = text; document.body.appendChild( ta ); ta.select(); try { document.execCommand( 'copy' ); done(); } catch ( x ) {} ta.remove(); }
		} else if ( 'download' === act ) {
			var a = document.createElement( 'a' );
			a.href = URL.createObjectURL( new Blob( [ build().text ], { type: 'text/plain;charset=utf-8' } ) );
			a.download = 'llms.txt'; document.body.appendChild( a ); a.click(); a.remove();
			setTimeout( function () { URL.revokeObjectURL( a.href ); }, 1000 );
		}
	} );
	/* Hero buttons live outside the app root. */
	document.querySelectorAll( '[data-vvg]' ).forEach( function ( b ) {
		b.addEventListener( 'click', function () {
			f = 'example' === b.getAttribute( 'data-vvg' ) ? example() : empty();
			save(); render();
			var t = document.getElementById( 'vvg-tool' );
			if ( t ) { t.scrollIntoView( { behavior: 'smooth', block: 'start' } ); }
		} );
	} );
	render();
} )();
