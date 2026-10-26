# Running the build scripts on the live site

The scripts in this folder run server-side through the Novamira `execute-php` ability. Since 26 October 2026,
`file_put_contents()`, `file_get_contents()` and `copy()` return null when they are called from code in a file that was `include`d from the execute-php code and whose name does not end in `.php`.
That covers every temp file from `wp_tempnam()` (`.tmp`). The same calls still work in the top-level execute-php
code. WordPress core's own file calls (for example `wp_handle_sideload()`), GD's `imagewebp()`, `ZipArchive` and
`unlink()` still work when an included script calls them. These were checked on the live site on 26 October 2026.

So the scripts do no file I/O of their own:

- **`$vv_files`**: repo-relative path (under `wordpress/`) => local temp file. A script that needs a file, either
  PHP to `include` or an asset to upload, looks for it here. If any are missing, it returns
  `array( 'vv_need' => array( <paths> ) )` before doing anything else.
- **`vv_write`**: a script that produces files returns them as `'vv_write' => array( <absolute path> => <contents> )`.
  It does not write them itself.

The runner below is the top-level execute-php code. It does every fetch-to-disk, write and delete. Set the
commit SHA, the script and that script's own variables, which are listed in its header. Then send the code
as the execute-php `code`:

```php
$vv_base   = 'https://raw.githubusercontent.com/aivineetvijay/vineetonmarketing/<sha>/wordpress/';
$vv_script = 'build/run-blog.php';
/* The script's own variables, e.g. for run-blog.php: */
$vv_essays = array();
$vv_json   = array( 'digital-marketing-for-doctors', 'sameas-schema', 'rank-in-ai-overviews', 'customer-match-ip-timestamp', 'schema-markup-for-real-estate', 'schema-markup-ai-visibility' );

$vv_get = function ( $path ) use ( $vv_base ) {
	$r = wp_remote_get( $vv_base . $path, array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { throw new Exception( 'fetch failed: ' . $path ); }
	return wp_remote_retrieve_body( $r );
};
$vv_files = array(); $vv_need = array( $vv_script ); $vv_res = null;
try {
	for ( $vv_i = 0; $vv_need && $vv_i < 5; $vv_i++ ) {
		foreach ( $vv_need as $vv_p ) {
			$vv_files[ $vv_p ] = wp_tempnam( 'vv' );
			if ( ! file_put_contents( $vv_files[ $vv_p ], $vv_get( $vv_p ) ) ) { throw new Exception( 'temp write failed: ' . $vv_p ); }
		}
		$vv_res  = include $vv_files[ $vv_script ];
		$vv_need = is_array( $vv_res ) ? array_diff( $vv_res['vv_need'] ?? array(), array_keys( $vv_files ) ) : array();
	}
	$vv_written = array();
	foreach ( ( is_array( $vv_res ) ? $vv_res['vv_write'] ?? array() : array() ) as $vv_p => $vv_data ) {
		wp_mkdir_p( dirname( $vv_p ) );
		$vv_written[ $vv_p ] = file_put_contents( $vv_p, $vv_data );
	}
} finally {
	foreach ( $vv_files as $vv_f ) { if ( file_exists( $vv_f ) ) { unlink( $vv_f ); } }
}
if ( is_array( $vv_res ) ) { unset( $vv_res['vv_write'] ); if ( $vv_written ) { $vv_res['written'] = $vv_written; } }
return $vv_res;
```

On the first pass the runner writes and includes only the script. The script replies with what it needs, and
the runner fetches that and includes the script again. A script whose list of needs depends on a file it
gets (such as `tools/install-llms-generators.php`) may take three passes. Check that every `written` value is
a byte count, not `false` or `null`.

Scripts that follow this pattern: `build/run-blog.php`, `seo/llms-txt.php`, `tools/install-llms-generators.php`,
`assets/brand/set-site-icon.php`, `assets/icons/llms/upload-icons.php`, `build/theme/header-footer.php`.
`build/vv-preview.php` is a function library. Its header shows the top-level code that zips its manifest.
