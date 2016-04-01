var gulp = require('gulp');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var concat = require('gulp-concat');
var less = require('gulp-less');
var sourcemaps = require('gulp-sourcemaps');
var order = require('gulp-order');
var merge = require('merge-stream');
var livereload = require('gulp-livereload');

var paths = {
    theme: {
        js:   [
            'assets/js/jquery-2.1.1.min.js',
            'assets/js/bootstrap.js',
            'assets/js/less.js',
            'assets/js/jquery.typewatch.js',
            'assets/js/jquery.raty.js',
            'assets/js/core.js',
            'assets/js/wellcommerce.js'
        ],
        less: [
            'assets/css/wellcommerce.less',
            'assets/css/responsive.less'
        ],
        css:  [
            'assets/css/bootstrap.css'
        ]
    }
};

gulp.task('theme-js', function () {
    return gulp.src(paths.theme.js)
        .pipe(concat('theme.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('assets/js/'))
        .pipe(livereload());
});

gulp.task('theme-css', function () {
    var cssStream = gulp.src(paths.theme.css).pipe(concat('theme-css-files.css'));
    var lessStream = gulp.src(paths.theme.less).pipe(less()).pipe(concat('theme-less-files.less'));

    return merge(cssStream, lessStream)
        .pipe(order(['theme-css-files.css', 'theme-less-files.less']))
        .pipe(concat('theme.css'))
        .pipe(uglifycss())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('assets/css/'))
        .pipe(livereload())
        ;
});

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch(paths.theme.css, ['theme-css']);
    gulp.watch(paths.theme.less, ['theme-css']);
    gulp.watch(paths.theme.js, ['theme-js']);
});

gulp.task('default', ['theme-js', 'theme-css']);

