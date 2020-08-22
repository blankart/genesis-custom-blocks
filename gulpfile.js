var gulp = require( 'gulp' );
var merge = require('merge-stream');
var del = require( 'del' );
var run = require( 'gulp-run' );
var replace = require( 'gulp-string-replace' );

var fs = require( 'fs' );
var config = JSON.parse( fs.readFileSync( './package.json' ) );

gulp.task( 'verify:versions', function () {
	return run( 'php bin/verify-versions.php' ).exec();
} )

gulp.task( 'version', function () {
	var pluginStream = gulp.src( [ 'genesis-custom-blocks.php' ] )
		.pipe( replace( new RegExp( /Version:\s*(.*)/, 'g' ), "Version: " + config.version ) )
		.pipe(gulp.dest('./package/trunk/'))
		.pipe(gulp.dest('./'))

	return pluginStream;
} )

gulp.task( 'install:dependencies', function () {
	return run( 'composer install -o --no-dev && npm install' ).exec();
} )

gulp.task( 'run:build', function () {
	return run( 'npm run build' ).exec();
} )

gulp.task( 'bundle', function () {
	return gulp.src( [
		'**/*',
		'!bin/**/*',
		'!node_modules/**/*',
		'!composer.*',
		'!genesis-custom-blocks.zip',
		'!js/blocks/**/*',
		'!js/src/**/*',
		'!js/tests/**/*',
		'!js/coverage/**/*',
		'!package/**/*',
	] )
	.pipe( gulp.dest( 'package/prepare' ) );
} );

gulp.task( 'remove:bundle', function () {
	return del( [
		'package/trunk',
		'package/assets',
	] );
} );

gulp.task( 'wporg:prepare', function () {
	return run( 'mkdir -p package/assets package/trunk package/trunk/language' ).exec();
} )

gulp.task( 'wporg:assets', function () {
	return run( 'mv package/prepare/assets/wporg/*.* package/assets' ).exec();
} )

gulp.task( 'wporg:readme', function ( cb ) {
	var changelog = fs.readFileSync( './CHANGELOG.md' ).toString();

	var readme = fs.readFileSync( './README.md' )
		.toString()
		.concat( '\n' + changelog )
		.replace( new RegExp( /Stable tag:\s*(.*)/, 'g' ), "Stable tag: " + config.version )
		.replace( new RegExp( '###', 'g'), '=' )
		.replace( new RegExp( '##', 'g'), '==' )
		.replace( new RegExp( '#', 'g'), '===' )
		.replace( new RegExp( '__', 'g'), '*' );

	return fs.writeFile( 'package/trunk/readme.txt', readme, cb );
} )

gulp.task( 'wporg:trunk', function () {
	return run( 'mv package/prepare/* package/trunk' ).exec();
} )

gulp.task( 'clean:bundle', function () {
	return del( [
		'package/trunk/package',
		'package/trunk/assets/wporg',
		'package/trunk/coverage',
		'package/trunk/js/blocks',
		'package/trunk/js/src',
		'package/trunk/js/*.map',
		'package/trunk/css/*.map',
		'package/trunk/css/src',
		'package/trunk/bin',
		'package/trunk/node_modules',
		'package/trunk/tests',
		'package/trunk/trunk',
		'package/trunk/gulpfile.js',
		'package/trunk/Makefile',
		'package/trunk/package*.json',
		'package/trunk/phpunit.xml',
		'package/trunk/phpcs.xml',
		'package/trunk/README.md',
		'package/trunk/CHANGELOG.md',
		'package/trunk/CODE_OF_CONDUCT.md',
		'package/trunk/CONTRIBUTING.md',
		'package/trunk/webpack.config.js',
		'package/trunk/.github',
		'package/prepare',
	] );
} );

gulp.task( 'create:zip', function () {
	return run( 'if [ -e genesis-custom-blocks.zip ]; then rm genesis-custom-blocks.zip; fi; cd package/trunk; pwd; zip -r ../../genesis-custom-blocks.zip .; cd ..; cd ..; echo "ZIP of build: $(pwd)/genesis-custom-blocks.zip"' ).exec();
} )

gulp.task( 'default', gulp.series(
	'verify:versions',
	'remove:bundle',
	'install:dependencies',
	'run:build',
	'bundle',
	'wporg:prepare',
	'wporg:assets',
	'wporg:readme',
	'wporg:trunk',
	'version',
	'clean:bundle',
	'create:zip'
) );
