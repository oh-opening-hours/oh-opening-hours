const gulp = require("gulp");
const uglify = require("gulp-uglify");
const concat = require("gulp-concat");
const jshint = require("gulp-jshint");
const sass = require("gulp-sass")(require("sass"));
const cleanCSS = require("gulp-clean-css");
const sourcemaps = require("gulp-sourcemaps");
const autoprefixer = require("gulp-autoprefixer");
const gulpZip = require("gulp-zip");
const gulpIf = require("gulp-if");
const del = require("del");

const paths = {
  src: {
    scripts: ["./includes/flatpickr/flatpickr.min.js", "./assets/scripts/**/*.js"],
    styles: ["./assets/styles/main.scss", "./includes/flatpickr/flatpickr.min.css"],
    backendstyles : ["./assets/styles/admin.scss"]
  },
  dest: {
    scripts: "./dist/scripts/",
    styles: "./dist/styles/",
    backendstyles: "./dist/admin/styles/"
  }
};

function scripts() {
  return gulp
    .src(paths.src.scripts)
    .pipe(jshint())
    .pipe(sourcemaps.init())
    .pipe(concat("main.js"))
    .pipe(uglify())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.dest.scripts));
}

function styles() {
  return gulp
    .src(paths.src.styles)
    .pipe(sourcemaps.init())
    .pipe(gulpIf("*.scss", sass()))
    .pipe(concat("main.css"))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.dest.styles));
}

function backendstyles() {
  return gulp
    .src(paths.src.backendstyles)
    .pipe(sourcemaps.init())
    .pipe(gulpIf("*.scss", sass()))
    .pipe(concat("main.css"))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.dest.backendstyles));
}

const build = gulp.parallel(backendstyles, styles, scripts);

const watch = gulp.series(build, function() {
  gulp.watch(paths.src.scripts, scripts);
  gulp.watch(paths.src.styles, styles);
  gulp.watch(paths.src.backendstyles, backendstyles);
});

function clean() {
  return del(["dist"]);
}

const exportTask = gulp.series(clean, build, function() {
  const files = [
    "./**/*",
    "!./node_modules/**/*",
    "!node_modules",
    "!./assets/**/*",
    "!assets",
    "!./vendor/**/*",
    "!vendor",
    "!**/.git/**/*",
    "!.gitignore",
    "!.gitmodules",
    "!gulpfile.js",
    "!package.json",
    "!package-lock.json",
    "!yarn.lock",
    "!composer.lock",
    "!phpunit.xml",
    "!./tests/**/*",
    "!tests",
    "!./doc/**/*",
    "!doc",
    "!.travis.yml",
    "!README.md"
  ];

  return gulp
    .src(files)
    .pipe(gulpZip("oh-opening-hours.zip"))
    .pipe(gulp.dest("."));
});

exports.scripts = scripts;
exports.styles = styles;
exports.backendstyles = backendstyles;
exports.export = exportTask;
exports.clean = clean;
exports.build = build;
exports.watch = watch;
