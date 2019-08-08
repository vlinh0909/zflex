var 
	gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	concat = require('gulp-concat'),
	plumber = require('gulp-plumber')
	minify = require('gulp-minify');

// gulp.task('sass',function(){
// 	return gulp.src('public/scss/**/*.scss')
// 	.pipe(sass())
// 	.pipe(gulp.dest('public/css'));
// });

gulp.task('sass', () =>
	sass('public/scss/**/*.scss')
		.pipe(plumber())
		.on('error', sass.logError)
		.pipe(gulp.dest('public/css'))
);

gulp.task('watch',function(){
	gulp.watch('public/scss/**/*.scss',['sass']);
	gulp.watch('public/js/**/*.js',['minify']);
});

gulp.task('scripts',function(){
	return gulp.src(['public/js/config.js','public/js/functions.js','public/js/custom.js','public/js/gallery.js','public/js/window.js','public/js/ajax.js','public/js/action.js','public/js/app.js'])
	.pipe(plumber())
	.pipe(concat('script.js'))
	.pipe(gulp.dest('public/js/'));
});

gulp.task('minify',['scripts'],function(){
	return gulp.src('public/js/script.js')
	.pipe(plumber())
	.pipe(minify())
	.pipe(gulp.dest('public/js/'));
})