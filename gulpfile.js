const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

// ------- ROOT WATCHER [START] -------------------
function root_styles() {
  return gulp.src('./root/development/scss/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./root/staging/assets/css/'));
}

function root_js() {
  return gulp.src('./root/development/js/**/*.js')
    .pipe(gulp.dest('./root/staging/assets/js/'));
}

function root_core() {
  return gulp.src([
    './root/development/core/**/*.php',
    '!./root/development/core/vars.php',
    '!./root/development/core/connection.php',
  ])
    .pipe(gulp.dest('./root/staging/'));
}

function root_assets() {
  return gulp.src('./root/development/assets/**/*.php')
    .pipe(gulp.dest('./root/staging/assets/php'));
}

exports.root_assets = root_assets;
exports.styles = root_styles;
exports.js = root_js;
exports.core = root_core;

exports.root_production = gulp.series(root_core, root_styles, root_js, root_assets);
// ------- ROOT WATCHER [END] -------------------

// --------- PRINT [START] ----------- 
// --------- PRINT [END] ----------- 

function watcher() {
  gulp.watch(
    [
      './root/development/',
      './api/devlopment',
      './print/devlopment'
    ],
    gulp.series(
      root_styles, root_js, root_core, root_assets
    ));
}

exports.watcher = watcher;

exports.default = gulp.series(
  root_core, root_styles, root_js, root_assets,
  watcher
);
