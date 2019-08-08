var 
	gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	concat = require('gulp-concat'),
	plumber = require('gulp-plumber'),
	minify = require('gulp-minify'),
	browserSync = require('browser-sync');

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
		.pipe(browserSync.reload({stream:true}))
);

gulp.task('browser-sync', function() {
    var files = [
      '*.html',
      'public/js/**/*.js'
   ];

   browserSync.init(files, {
      server: {
         baseDir: './'
      }
   });
});

gulp.task('watch',['browser-sync'],function(){
	
	gulp.watch('public/scss/**/*.scss',['sass']);
	gulp.watch('public/js/**/*.js',['minify']);
});

gulp.task('minify',function(){
	return gulp.src('public/js/app.js')
	.pipe(plumber())
	.pipe(minify())
	.pipe(gulp.dest('public/js/'))
	.pipe(browserSync.reload({stream:true}))
})