/**
 * llms.txt generator engine (v3), shared by every industry page under /ai-tools/llms-txt-generator/.
 * Stepped form: 1 Business, then one step per page group from the industry config (window.VVLLMS, loaded
 * from <industry>/config.js). The preview builds as you type. Everything runs in the browser.
 */
( function () {
	'use strict';
	var C = window.VVLLMS;
	var root = document.getElementById( 'vvg-app' );
	if ( ! C || ! root ) { return; }

	var KEY = 'vv-llms-' + C.slug + '-v3';
	var esc = function ( s ) { return String( s == null ? '' : s ).replace( /[&<>"']/g, function ( c ) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ]; } ); };
	var clone = function ( o ) { return JSON.parse( JSON.stringify( o ) ); };
	var H = {
		list: function ( s ) { return String( s || '' ).split( ',' ).map( function ( x ) { return x.trim(); } ).filter( Boolean ); },
		joinAnd: function ( a ) { return a.length < 2 ? ( a[ 0 ] || '' ) : a.slice( 0, -1 ).join( ', ' ) + ' and ' + a[ a.length - 1 ]; },
		a: function ( w ) { return /^(uni|use|usu|eu|one)/i.test( w ) || ! /^[aeiou]/i.test( w ) ? 'a' : 'an'; },
		places: function ( a ) { return a.map( function ( x ) { return /^(uae|uk|us|usa|gcc|united arab emirates|united kingdom|united states|netherlands|philippines|maldives)$/i.test( x ) ? 'the ' + x : x; } ); },
	};
	var groupKeys = C.groups.map( function ( g ) { return g.key; } );
	var pick = function ( v, type ) { return 'string' === typeof v ? v : ( v[ type ] || v._ ); };
	var typeOf = function ( key ) { return C.types.filter( function ( t ) { return t[ 0 ] === key; } )[ 0 ] || C.types[ 0 ]; };

	/* ---------- State ---------- */
	function emptyRows() { var r = {}; groupKeys.forEach( function ( k ) { r[ k ] = [ { t: '', u: '', n: '' } ]; } ); return r; }
	function emptyF( type ) { return { type: type || C.types[ 0 ][ 0 ], name: '', site: '', markets: '', licence: '', summary: '' }; }
	function exampleState() { return { f: clone( C.example.f ), rows: clone( C.example.rows ) }; }
	var st = null;
	try { var saved = JSON.parse( localStorage.getItem( KEY ) ); if ( saved && saved.f && saved.rows ) { st = saved; } } catch ( e ) {}
	if ( ! st ) { st = exampleState(); }
	groupKeys.forEach( function ( k ) { if ( ! Array.isArray( st.rows[ k ] ) || ! st.rows[ k ].length ) { st.rows[ k ] = [ { t: '', u: '', n: '' } ]; } } );
	var step = 0, done = false;
	function save() { try { localStorage.setItem( KEY, JSON.stringify( st ) ); } catch ( e ) {} }

	/* ---------- Checks (hard = left out of the file, soft = shown as "Check") ---------- */
	var UTIL = /\/(login|log-in|signin|sign-in|signup|sign-up|register|account|my-account|cart|basket|checkout|wishlist|compare|thank-you|thanks|404|admin|wp-admin|wp-login\.php|staging)(\/|$|\.)/i;
	var SUPER = /\b(best|leading|no\.?\s?1|number one|world[- ]class|finest|unrivall?ed|ultimate|premier|top[- ]rated|must[- ]have|amazing|incredible|stunning|exceptional|unparalleled|discover|unlock|redefined)\b|#1\b/i;
	function host( u ) { var m = /^https?:\/\/([^/?#]+)/i.exec( u ); return m ? m[ 1 ].toLowerCase().replace( /^www\./, '' ) : ''; }
	function check( r ) {
		var hard = [], soft = [], u = r.u.trim(), t = r.t.trim(), n = r.n.trim();
		if ( ! u && ! t && ! n ) { return { hard: hard, soft: soft, empty: true }; }
		if ( ! t ) { soft.push( 'Add a page title.' ); }
		if ( ! u ) { hard.push( 'Add the page URL.' ); }
		else if ( ! /^https?:\/\/[^\s/]+\.[^\s]+$/i.test( u ) ) { hard.push( 'Use a full URL starting with https://' ); }
		else {
			if ( /\?/.test( u ) ) { hard.push( 'Filtered or query-string URLs are left out. Link the main page instead.' ); }
			if ( /\/page\/\d+\/?$/i.test( u ) ) { hard.push( 'Pagination URLs are left out.' ); }
			if ( UTIL.test( u ) ) { hard.push( 'Login, account, cart and thank-you pages are left out.' ); }
			( C.urlRules || [] ).forEach( function ( x ) { if ( x.re.test( u ) ) { ( x.hard ? hard : soft ).push( x.msg ); } } );
			var site = host( st.f.site.trim() ), h = host( u );
			if ( site && h && h !== site && h.slice( -( site.length + 1 ) ) !== '.' + site ) { soft.push( 'This URL is on a different domain from the website.' ); }
		}
		if ( n ) {
			if ( n.split( /\s+/ ).length > 30 ) { soft.push( 'Keep the description to one short line.' ); }
			if ( SUPER.test( n ) || ( C.superlatives && C.superlatives.test( n ) ) ) { soft.push( 'Skip superlatives and slogans. Keep it factual.' ); }
			( C.descRules || [] ).forEach( function ( x ) { if ( x.re.test( n ) ) { soft.push( x.msg ); } } );
		}
		return { hard: hard, soft: soft };
	}
	var valid = function ( r ) { var c = check( r ); return ! c.empty && ! c.hard.length && r.t.trim(); };

	/* ---------- Build ---------- */
	function summary() {
		var s = st.f.summary.trim().replace( /\s+/g, ' ' );
		if ( s ) { return s; }
		var name = st.f.name.trim() || 'Business name', t = typeOf( st.f.type ), m = H.list( st.f.markets );
		return name + ' is ' + H.a( t[ 2 ] ) + ' ' + t[ 2 ] + ( m.length ? ' ' + ( C.where || 'in' ) + ' ' + H.joinAnd( H.places( m ) ) : '' ) + '.';
	}
	function build() {
		var f = st.f, L = [ '# ' + ( f.name.trim() || 'Business name' ), '', '> ' + summary(), '' ];
		L.push( '- Type: ' + typeOf( f.type )[ 3 ] );
		if ( f.markets.trim() ) { L.push( '- ' + C.fields.markets.fact + ': ' + f.markets.trim() ); }
		if ( f.licence.trim() ) { L.push( '- ' + C.fields.licence.fact + ': ' + f.licence.trim() ); }
		if ( f.site.trim() ) { L.push( '- Website: ' + f.site.trim().replace( /\/+$/, '' ) ); }
		var seen = {}, links = 0, left = 0, counts = {};
		C.groups.forEach( function ( g ) {
			var items = [];
			st.rows[ g.key ].forEach( function ( r ) {
				var c = check( r );
				if ( c.empty ) { return; }
				var u = r.u.trim().replace( /#.*$/, '' ), k = u.replace( /\/$/, '' );
				if ( c.hard.length || ! r.t.trim() || seen[ k ] || links >= 150 ) { left++; return; }
				seen[ k ] = true; links++;
				var n = r.n.trim().replace( /\s+/g, ' ' );
				items.push( '- [' + r.t.trim().replace( /\s+\|\s+[^|]*$/, '' ) + '](' + u + ')' + ( n ? ': ' + n : '' ) );
			} );
			counts[ g.key ] = items.length;
			if ( items.length ) { L.push( '', '## ' + pick( g.heading, f.type ), '' ); items.forEach( function ( x ) { L.push( x ); } ); }
		} );
		var text = L.join( '\n' ) + '\n';
		return { text: text, links: links, left: left, counts: counts };
	}

	/* ---------- Render ---------- */
	var steps = function () { return [ { key: 'business', label: 'Business' } ].concat( C.groups.map( function ( g ) { return { key: g.key, label: pick( g.label, st.f.type ) }; } ) ); };
	function field( k, wide ) {
		var d = C.fields[ k ];
		return '<label class="vvg-field' + ( wide ? ' vvg-wide' : '' ) + '"><span>' + esc( d.label ) + '</span><input type="' + ( 'site' === k ? 'url' : 'text' ) + '" data-f="' + k + '" placeholder="' + esc( d.ph ) + '" value="' + esc( st.f[ k ] ) + '"></label>';
	}
	function rowHtml( g, r, i ) {
		var ph = g.ph;
		return '<div class="vvg-row" data-g="' + g.key + '" data-i="' + i + '">' +
			'<div class="vvg-row-top"><input type="text" data-k="t" aria-label="Page title" placeholder="' + esc( ph[ 0 ] ) + '" value="' + esc( r.t ) + '">' +
			'<input type="url" data-k="u" aria-label="URL" placeholder="' + esc( ph[ 1 ] ) + '" value="' + esc( r.u ) + '">' +
			'<button type="button" class="vvg-x" data-act="remove" aria-label="Remove page">×</button></div>' +
			'<input type="text" data-k="n" aria-label="Short description" placeholder="' + esc( ph[ 2 ] ) + '" value="' + esc( r.n ) + '">' +
			'<p class="vvg-warn" aria-live="polite"></p></div>';
	}
	function panelHtml() {
		var s = steps()[ step ];
		if ( 'business' === s.key ) {
			return '<div class="vvg-panel"><div class="vvg-types"><span class="vvg-label">' + esc( C.typeLabel || 'Business type' ) + '</span><div class="vvg-chips">' +
				C.types.map( function ( t ) { return '<button type="button" class="vvg-chip" data-type="' + t[ 0 ] + '" aria-pressed="' + ( st.f.type === t[ 0 ] ) + '">' + esc( t[ 1 ] ) + '</button>'; } ).join( '' ) + '</div></div>' +
				'<div class="vvg-fields">' + field( 'name' ) + field( 'site' ) + field( 'markets' ) + field( 'licence' ) + '</div>' +
				'<label class="vvg-field vvg-wide"><span>One-line summary</span><textarea rows="3" data-f="summary" placeholder="' + esc( C.fields.summary.ph ) + '">' + esc( st.f.summary ) + '</textarea><small class="vvg-hint" data-hint="summary"></small></label></div>';
		}
		var g = C.groups.filter( function ( x ) { return x.key === s.key; } )[ 0 ];
		return '<div class="vvg-panel"><div class="vvg-group-head"><h3>' + esc( pick( g.heading, st.f.type ) ) + '</h3><p>' + esc( pick( g.hint, st.f.type ) ) + '</p></div>' +
			'<div class="vvg-rows">' + st.rows[ g.key ].map( function ( r, i ) { return rowHtml( g, r, i ); } ).join( '' ) + '</div>' +
			'<button type="button" class="vvg-add" data-act="add">+ Add a page</button></div>';
	}
	function render() {
		var n = steps().length;
		root.innerHTML =
			'<div class="vvg-grid">' +
				'<div class="vvg-form">' +
					'<div class="vvg-progress"><div class="vvg-progress-row"><span class="vvg-progress-label"></span><span>Step ' + ( step + 1 ) + ' of ' + n + '</span></div>' +
					'<div class="vvg-bar"><div class="vvg-bar-fill"></div></div><div class="vvg-tabs" role="tablist"></div></div>' +
					panelHtml() +
					'<div class="vvg-nav"><button type="button" class="vvg-back" data-act="prev"' + ( 0 === step ? ' disabled' : '' ) + '>Back</button>' +
					'<button type="button" class="vvg-next" data-act="next">' + ( step === n - 1 ? 'Download llms.txt' : 'Next' ) + '</button></div>' +
				'</div>' +
				'<div class="vvg-out"><div class="vvg-out-head"><div><span class="vvg-out-title">llms.txt</span><span class="vvg-stats"></span></div>' +
					'<div class="vvg-out-actions"><button type="button" class="vvg-ghost" data-act="copy">Copy</button><button type="button" class="vvg-blue" data-act="download">Download</button></div></div>' +
					'<pre class="vvg-pre" tabindex="0" aria-label="llms.txt preview"></pre>' +
					'<div class="vvg-out-foot">Upload to the site root so it opens at <span class="vvg-file"></span></div></div>' +
			'</div>' +
			'<div class="vvg-done"' + ( done ? '' : ' hidden' ) + '>' + doneHtml() + '</div>';
		root.querySelectorAll( '.vvg-row' ).forEach( paintRow );
		update();
	}
	function doneHtml() {
		var url = esc( location.origin + location.pathname ), enc = encodeURIComponent( location.origin + location.pathname );
		return '<div class="vvg-done-share"><strong>File ready. Three steps left.</strong><span>Then share the tool with ' + esc( C.shareWith ) + '.</span>' +
			'<div class="vvg-done-links"><a href="https://www.linkedin.com/sharing/share-offsite/?url=' + enc + '" target="_blank" rel="noopener">LinkedIn ↗</a>' +
			'<a href="https://wa.me/?text=' + encodeURIComponent( 'A free llms.txt generator for ' + C.label + ' websites: ' ) + enc + '" target="_blank" rel="noopener">WhatsApp ↗</a>' +
			'<a href="mailto:?subject=' + encodeURIComponent( 'A free llms.txt generator for ' + C.label ) + '&amp;body=' + encodeURIComponent( 'Thought this might help: ' ) + enc + '">Email ↗</a></div></div>' +
			'<ol class="vvg-done-steps"><li><strong>Upload</strong> to the root folder. WordPress: via the host’s file manager or an SEO plugin that supports llms.txt.</li>' +
			'<li><strong>Open</strong> <span class="vvg-file"></span> and confirm it loads as plain text.</li>' +
			'<li><strong>Review quarterly</strong>, ' + esc( C.reviewWhen ) + '.</li></ol>' + ( url ? '' : '' );
	}
	function paintRow( el ) {
		var r = st.rows[ el.getAttribute( 'data-g' ) ][ +el.getAttribute( 'data-i' ) ];
		var c = check( r ), msgs = c.empty ? [] : c.hard.concat( c.soft );
		var w = el.querySelector( '.vvg-warn' );
		w.innerHTML = msgs.length ? '<span class="vvg-check">' + ( c.hard.length ? 'Left out' : 'Check' ) + '</span>' + esc( msgs.join( ' ' ) ) : '';
		w.hidden = ! msgs.length;
		el.classList.toggle( 'vvg-row-out', ! c.empty && c.hard.length > 0 );
	}
	function update() {
		var b = build(), list = steps(), n = list.length;
		var bizDone = st.f.name.trim() && st.f.site.trim();
		var doneCount = ( bizDone ? 1 : 0 ) + C.groups.filter( function ( g ) { return b.counts[ g.key ] > 0; } ).length;
		root.querySelector( '.vvg-pre' ).textContent = b.text;
		root.querySelector( '.vvg-stats' ).textContent = b.links + ( 1 === b.links ? ' link' : ' links' ) + ' · ' + b.text.split( '\n' ).length + ' lines' + ( b.left ? ' · ' + b.left + ' left out' : '' );
		root.querySelectorAll( '.vvg-file' ).forEach( function ( x ) { x.textContent = ( st.f.site.trim().replace( /\/+$/, '' ) || 'https://yoursite.com' ) + '/llms.txt'; } );
		root.querySelector( '.vvg-progress-label' ).textContent = doneCount + ' of ' + n + ' sections complete';
		root.querySelector( '.vvg-bar-fill' ).style.width = ( doneCount / n * 100 ) + '%';
		root.querySelector( '.vvg-tabs' ).innerHTML = list.map( function ( s, i ) {
			var c = 'business' === s.key ? '' : ( b.counts[ s.key ] ? ' · ' + b.counts[ s.key ] : '' );
			return '<button type="button" role="tab" class="vvg-tab" data-step="' + i + '" aria-selected="' + ( i === step ) + '">' + ( i + 1 ) + ' ' + esc( s.label ) + c + '</button>';
		} ).join( '' );
		var hint = root.querySelector( '[data-hint="summary"]' );
		if ( hint ) { var len = st.f.summary.trim().length; hint.textContent = len ? len + ' characters · aim for 120–200' : 'Aim for one sentence, 120–200 characters. Leave blank to write it from the fields above.'; }
		return b;
	}
	function go( i ) {
		step = Math.max( 0, Math.min( steps().length - 1, i ) ); render();
		var g = document.getElementById( 'generator' );
		if ( g && g.getBoundingClientRect().top < 0 ) { g.scrollIntoView( { behavior: 'smooth', block: 'start' } ); }
	}
	function download() {
		var a = document.createElement( 'a' );
		a.href = URL.createObjectURL( new Blob( [ build().text ], { type: 'text/plain;charset=utf-8' } ) );
		a.download = 'llms.txt'; document.body.appendChild( a ); a.click(); a.remove();
		setTimeout( function () { URL.revokeObjectURL( a.href ); }, 1000 );
		finish();
	}
	function finish() { done = true; var d = root.querySelector( '.vvg-done' ); if ( d ) { d.hidden = false; update(); } }

	/* ---------- Events ---------- */
	function onInput( e ) {
		var t = e.target, row = t.closest( '.vvg-row' );
		if ( row && t.hasAttribute( 'data-k' ) ) {
			st.rows[ row.getAttribute( 'data-g' ) ][ +row.getAttribute( 'data-i' ) ][ t.getAttribute( 'data-k' ) ] = t.value;
			paintRow( row );
		} else if ( t.hasAttribute( 'data-f' ) ) {
			st.f[ t.getAttribute( 'data-f' ) ] = t.value;
		} else { return; }
		save(); update();
	}
	root.addEventListener( 'input', onInput );
	root.addEventListener( 'click', function ( e ) {
		var tab = e.target.closest( '[data-step]' );
		if ( tab ) { go( +tab.getAttribute( 'data-step' ) ); return; }
		var ty = e.target.closest( '[data-type]' );
		if ( ty ) { st.f.type = ty.getAttribute( 'data-type' ); save(); render(); return; }
		var b = e.target.closest( '[data-act]' );
		if ( ! b ) { return; }
		var act = b.getAttribute( 'data-act' ), key = steps()[ step ].key;
		if ( 'prev' === act ) { go( step - 1 ); }
		else if ( 'next' === act ) { if ( step === steps().length - 1 ) { download(); } else { go( step + 1 ); } }
		else if ( 'add' === act ) {
			st.rows[ key ].push( { t: '', u: '', n: '' } ); save(); render();
			var rows = root.querySelectorAll( '.vvg-row [data-k="t"]' ); rows[ rows.length - 1 ].focus();
		} else if ( 'remove' === act ) {
			var el = b.closest( '.vvg-row' );
			st.rows[ key ].splice( +el.getAttribute( 'data-i' ), 1 );
			if ( ! st.rows[ key ].length ) { st.rows[ key ].push( { t: '', u: '', n: '' } ); }
			save(); render();
		} else if ( 'copy' === act ) {
			var text = build().text, ok = function () { b.textContent = 'Copied'; setTimeout( function () { b.textContent = 'Copy'; }, 1600 ); finish(); };
			if ( navigator.clipboard && navigator.clipboard.writeText ) { navigator.clipboard.writeText( text ).then( ok, function () {} ); }
			else { var ta = document.createElement( 'textarea' ); ta.value = text; document.body.appendChild( ta ); ta.select(); try { document.execCommand( 'copy' ); ok(); } catch ( x ) {} ta.remove(); }
		} else if ( 'download' === act ) { download(); }
	} );
	/* Buttons outside the app: Load example, Clear form, sub-nav Download. */
	document.querySelectorAll( '[data-vvg]' ).forEach( function ( b ) {
		b.addEventListener( 'click', function ( e ) {
			var a = b.getAttribute( 'data-vvg' );
			if ( 'download' === a ) { e.preventDefault(); download(); return; }
			if ( 'example' === a ) { st = exampleState(); } else { st = { f: emptyF( st.f.type ), rows: emptyRows() }; }
			step = 0; done = false; save(); render();
		} );
	} );
	render();
} )();
