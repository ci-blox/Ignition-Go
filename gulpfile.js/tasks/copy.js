var gulp = require('gulp'),
	config = require('../config').copy;

gulp.task('copy:fonts', function() {
	gulp.src(config.src.fonts)
		.pipe(gulp.dest(config.dest.fonts));
});

gulp.task('copy:scripts', function() {
	gulp.src(config.src.scripts)
		.pipe(gulp.dest(config.dest.scripts));
});

gulp.task('copy:csslib', function() {
	gulp.src(config.src.csslib)
		.pipe(gulp.dest(config.dest.csslib));
});

gulp.task('copy:scssbootstrap', function() {
	gulp.src(config.src.scssbootstrap)
		.pipe(gulp.dest(config.dest.scssbootstrap));
});

gulp.task('copy', ['copy:fonts', 'copy:scripts', 'copy:csslib', 'copy:scssbootstrap']);