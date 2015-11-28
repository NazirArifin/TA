/* File: gulpfile.js */

var gulp  = require('gulp'),
	gutil = require('gulp-util'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	minify = require('gulp-minify-css'),
	sass = require('gulp-sass'),
	prefixer = require('gulp-autoprefixer'),
	sourcemaps = require('gulp-sourcemaps');
	
var onError = function(err) {
	gutil.log(gutil.colors.red("ERROR", err.plugin), err);
    this.emit("end", new gutil.PluginError(err.plugin, err, { showStack: true }));
};

gulp.task('default', ['watch']);

/** build css materialist */
gulp.task('build-css-materialist-style', function() {
	return gulp.src('src/css/materialist/**/*.css').
		pipe(concat('materialist-style.min.css')).
		pipe(minify()).
		pipe(gulp.dest('css'));
});

/** build helper */
gulp.task('build-js-helper', function() {
	return gulp.src('src/js/helper/**/*.js').
		pipe(concat('helper.min.js')).
		pipe(uglify().on('error', onError)).
		pipe(gulp.dest('js'));
});

/** build tool materialist */
gulp.task('build-js-materialist-tools', function() {
	return gulp.src('src/js/materialist/tools/**/*.js').
		pipe(concat('materialist-tools.min.js')).
		pipe(uglify().on('error', onError)).
		pipe(gulp.dest('js'));
});

gulp.task('watch', function() {
	gulp.watch('src/css/materialist/**/*.css', ['build-css-materialist-style']);
	gulp.watch('src/js/helper/**/*.js', ['build-js-helper']);
	gulp.watch('src/js/materialist/tools/**/*.js', ['build-js-materialist-tools']);
});