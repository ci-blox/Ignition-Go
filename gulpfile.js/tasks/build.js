var gulp = require('gulp'),
	gulpSequence = require('gulp-sequence');

gulp.task('build', function(cb) {
	gulpSequence('clean', ['copy', 'cssmin', 'uglify'], cb);
});