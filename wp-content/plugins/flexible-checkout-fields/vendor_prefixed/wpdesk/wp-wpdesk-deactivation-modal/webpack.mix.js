/**
 * @see https://github.com/gbiorczyk/mati-mix/
 */
const mix           = require( 'mati-mix' );
const composer      = require( './composer.json' );
const ReplacePlugin = require( 'replace-in-file-webpack-plugin' );

mix.mix.setPublicPath( 'assets/build' );
mix.version();

mix.js(
	[
		'assets-src/js/Core.js',
	],
	'assets/build/js/scripts.js'
);

mix.sass(
	'assets-src/scss/Core.scss',
	'assets/build/css/styles.css'
);

mix.webpackConfig( {
	plugins: [
		new ReplacePlugin( [
			{
				dir: 'assets/build/js',
				files: [ 'scripts.js' ],
				rules: [
					{
						search: new RegExp( `(${ composer.extra[ 'assets-values' ][ 'plugin-slug' ][ 'search' ] })`, 'g' ),
						replace: composer.extra[ 'assets-values' ][ 'plugin-slug' ][ 'replace' ],
					},
				],
			},
			{
				dir: 'assets/build/css',
				files: [ 'styles.css' ],
				rules: [
					{
						search: new RegExp( `(${ composer.extra[ 'assets-values' ][ 'plugin-slug' ][ 'search' ] })`, 'g' ),
						replace: composer.extra[ 'assets-values' ][ 'plugin-slug' ][ 'replace' ],
					},
				],
			},
		] ),
	],
} );
