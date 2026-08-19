const {src, dest, series, watch} = require('gulp');
const scss = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer').default;
const uglify = require('gulp-uglify');
const rename = require("gulp-rename");

function styles() {
  return src('src/scss/**/*.scss')
    .pipe(scss({style: 'compressed'}))
    .pipe(autoprefixer())
    .pipe(dest('public/css'))
}

function scripts() {
  return src('src/js/**/*.js')
    .pipe(uglify())
    .pipe(rename({extname: '.min.js'}))
    .pipe(dest('public/js'))
}

function watcher() {
  watch('src/scss/**/*.scss', styles);
  watch('src/js/**/*.js', scripts);
}

exports.default = series(styles, scripts);
exports.styles = styles;
exports.scripts = scripts;
exports.watch = watcher;