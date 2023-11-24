var gulp = require('gulp');
var gp_concat = require('gulp-concat');
var gp_rename = require('gulp-rename');
var gp_uglify = require('gulp-uglify');

gulp.task('minifyJS', function () {
    return gulp.src([
        'dist/api-recaptcha.min.js',
        'vendor/jquery-3.6.1/jquery-3.6.1.js',
        'vendor/bootstrap-5.2.3/dist/js/bootstrap.js',
        'vendor/fontawesome-free-6.2.1-web/js/all.js',
        'dist/jquery.maskedinput.min.js',
        'dist/script.js']).pipe(gp_concat('concat.js'))
            .pipe(gulp.dest('dist'))
            .pipe(gp_rename('custom.js'))
            .pipe(gp_uglify())
            .pipe(gulp.dest('js'));
});

gulp.task('watch', gulp.series( function() {
    gulp.watch(['dist/*.js'], gulp.parallel( ['minifyJS'] ));
}));

gulp.task('default', gulp.series( ['minifyJS', 'watch'] ));
