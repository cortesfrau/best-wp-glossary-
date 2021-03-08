/**
 * Imports & consts
 */
import { src, dest, watch, series, parallel } from 'gulp';
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import imagemin from 'gulp-imagemin';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import yargs from 'yargs';
import gulpif from 'gulp-if';
import merge from 'merge-stream';
import wpPot from "gulp-wp-pot";
import zip from "gulp-zip";
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import del from 'del';
import info from "./package.json";
const PRODUCTION = yargs.argv.prod;

/**
 * Tasks
 */

// Styles Task
export const styles = () => {
  return src(['src/scss/wpbg-bundle.scss'])
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(dest('dist/css'));
}

// Scripts Task
export const scripts = () => {
  return src(['src/js/wpbg-bundle.js'])
    .pipe(named())
    .pipe(webpack({
      module: {
        rules: [
          {
            test: /\.js$/,
            use: {
              loader: 'babel-loader',
              options: {
                presets: []
              }
            }
          }
        ]
      },
      mode: PRODUCTION ? 'production' : 'development',
      devtool: !PRODUCTION ? 'inline-source-map' : false,
      output: {
        filename: '[name].js'
      },
      externals: {
        jquery: 'jQuery'
      },
    }))
    .pipe(dest('dist/js'));
}

// Images Task
export const img = () => {
  return src('src/images/**/*.{jpg,jpeg,png,svg,gif}')
    .pipe(gulpif(PRODUCTION, imagemin()))
    .pipe(dest('dist/images'));
}

// Copy Assets Tasks
export const copyAssets = () => {
  var bootstrapScss = src('node_modules/bootstrap/scss/**/*.scss')
    .pipe(dest('assets/bootstrap/scss'));
  var bootstrapJs = src('node_modules/bootstrap/dist/js/*.js')
    .pipe(dest('assets/bootstrap/js'));
  var fontawesomeJs = src('node_modules/@fortawesome/fontawesome-free/js/*')
    .pipe(dest('assets/fontawesome/js'))
  return merge(bootstrapScss, bootstrapJs, fontawesomeJs);
}

// Clean Assets Task
export const cleanAssets = () => del(['assets']);

// Copy Task
export const copy = () => {
  return src(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'])
    .pipe(dest('dist'));
}

// Clean Task
export const clean = () => del(['dist']);

// POT Task
export const pot = () => {
  return src("**/*.php")
    .pipe(
      wpPot({
        domain: "wpbg",
        package: info.name
      })
    )
    .pipe(dest(`languages/${info.name}.pot`));
};

// ZIP Compress Task
export const compress = () => {
  return src([
    "**/*",
    "!node_modules{,/**}",
    "!bundled{,/**}",
    "!src{,/**}",
    "!.babelrc",
    "!.gitignore",
    "!gulpfile.babel.js",
    "!package.json",
    "!package-lock.json",
  ])
    .pipe(zip(`${info.name}.zip`))
    .pipe(dest('bundled'));
};

// Watch Task
export const watchForChanges = () => {
  watch('src/scss/**/*.scss', styles);
  watch('src/img/**/*.{jpg,jpeg,png,svg,gif}', img);
  watch(['src/**/*','!src/{img,js,scss}','!src/{img,js,scss}/**/*'], copy);
  watch('src/js/**/*.js', scripts);
}

// Dev & Build Tasks
export const themeSetup = series(cleanAssets, copyAssets);
export const dev = series(clean, parallel(styles, img, copy, scripts), watchForChanges);
export const build = series(clean, parallel(styles, img, copy, scripts), pot, compress);
export default dev;
