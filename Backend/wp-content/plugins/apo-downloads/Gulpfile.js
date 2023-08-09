const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano')
const autoprefixer = require('autoprefixer');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const concat = require('gulp-concat-util');
const runSequence = require('run-sequence');
const config = require('./config/config');
const plugins = [
    autoprefixer({ browsers: ['> 1%', 'last 3 versions', 'iOS >= 8'] }),
    cssnano({ zindex: false })
];


gulp.task('browser-sync', function () {
    browserSync.init({
        proxy: config.default.devUrl
    });
});

gulp.task('clean-dist', () => {
    return gulp.src('./dist/*')
        .pipe(clean());
});

gulp.task('sass', () => {
    return gulp.src(config.directories.sass + 'style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss(plugins))
        .pipe(rename({prefix: config.default.prefix}))
        .pipe(gulp.dest(config.directories.css))
});

gulp.task('build-public-script', () => {
    return gulp.src([
        config.directories.jsPublicSrc + '_variables.js',
        config.directories.jsPublicSrc + '_scripts.js',
        config.directories.jsPublicSrc + '_functions.js',
        config.directories.jsSharedSrc + '_shared_functions.js'
    ])
        .pipe(concat('public-build.js'))
        .pipe(concat.header(config.settings.jsHeader))
        .pipe(concat.footer(config.settings.jsFooter))
        .pipe(gulp.dest(config.directories.jsSrc))
});

gulp.task('build-backend-script', () => {
    return gulp.src([
        config.directories.jsBackendSrc + '_variables.js',
        config.directories.jsBackendSrc + '_script.js',
        config.directories.jsBackendSrc + '_functions.js'
    ])
        .pipe(concat('backend-build.js'))
        .pipe(concat.header(config.settings.jsHeader))
        .pipe(concat.footer(config.settings.jsFooter))
        .pipe(gulp.dest(config.directories.jsSrc))
});

gulp.task('uglify-public-script', () => {
    return gulp.src(config.directories.jsSrc + 'public-build.js')
        .pipe(uglify())
        .pipe(rename({ basename: config.default.prefix + 'script', suffix: '.min' }))
        .pipe(gulp.dest(config.directories.js))
});

gulp.task('uglify-backend-script', () => {
    return gulp.src(config.directories.jsSrc + 'backend-build.js')
        .pipe(uglify())
        .pipe(rename({ basename: config.default.prefix + 'backend', suffix: '.min' }))
        .pipe(gulp.dest(config.directories.js))
});

gulp.task('watch', () => {
    gulp.watch([
        config.directories.jsSrc + '*/**', 
        config.directories.sass + '**'
    ], ['default']).on('change', browserSync.reload)
});

gulp.task('serve', ['browser-sync', 'watch']);


gulp.task('default', () => {
    runSequence(
        'sass',
        'build-public-script',
        'build-backend-script',
        'uglify-public-script',
        'uglify-backend-script',
    );
});
