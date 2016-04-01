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
    admin: {
        libs: [
            'web/bundles/fosjsrouting/js/router.js',
            'web/bundles/wellcommerceadmin/js/libs/**',
            'web/bundles/bazingajstranslation/js/translator.min.js',
            'js/translations/config.js',
            'web/js/translations/**/*.js',
            'web/bundles/wellcommerceadmin/js/core/core.js',
            'web/bundles/wellcommerceadmin/js/core/plugin/*.js',
            'web/bundles/wellcommerceadmin/js/core/form.js',
            'web/bundles/wellcommerceadmin/js/core/language/*.js'
        ],
        core: [
            'web/bundles/wellcommerceadmin/js/core/gf.js',
            'web/bundles/wellcommerceadmin/js/core/init.js'
        ],
        css:  [
            'web/bundles/wellcommerceadmin/css/**'
        ],
        images: [
            'web/bundles/wellcommerceadmin/images/**'
        ]
    }
};

gulp.task('admin-libs', function () {
    return gulp.src(paths.admin.libs)
        .pipe(concat('libs.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js/admin/'))
        .pipe(livereload());
});

gulp.task('admin-core', function () {
    return gulp.src(paths.admin.core)
        .pipe(concat('core.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js/admin/'))
        .pipe(livereload());
});

gulp.task('admin-css', function () {
    return gulp.src(paths.admin.css)
        .pipe(concat('admin.css'))
        .pipe(uglifycss())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/css/'))
        .pipe(livereload());
});

gulp.task('admin-images', function() {
    return gulp.src(paths.admin.images)
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/images/'));
});

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch(paths.admin.libs, ['admin-libs']);
    gulp.watch(paths.admin.css, ['admin-css']);
    gulp.watch(paths.admin.js, ['admin-js']);
});

gulp.task('default', ['admin-libs', 'admin-core', 'admin-css', 'admin-images']);

