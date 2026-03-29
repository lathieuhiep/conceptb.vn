'use strict';

const {src, dest, watch, series} = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const sourcemaps = require('gulp-sourcemaps')
const browserSync = require('browser-sync').create()
const concat = require('gulp-concat')
const uglify = require('gulp-uglify')
const minifyCss = require('gulp-clean-css')
const rename = require("gulp-rename")
const imagemin = require('gulp-imagemin')

const pathSrc = './src'
const pathTheme = './themes/paint'
const pathAssets = `${pathTheme}/assets`
const pathAssetsCss = `${pathAssets}/css`

require('dotenv').config()

// setting NODE_ENV: development or production
// NODE_ENV="development" trong file .env để chạy ở chế độ phát triển (có sourcemap)
const isDev = (process.env.NODE_ENV === 'development');

// server
// tạo file .env với biến PROXY="localhost/bcolor.vn". Có thể thay đổi giá trị này.
const proxy = process.env.PROXY || 'localhost/bcolor.vn';

function server() {
    browserSync.init({
        proxy: proxy,
        open: false,
        cors: true,
        ghostMode: false,
        notify: false
    })
}

// compiler file scss
function compilerFileScss(fileScss, desc = '') {
    return src(`${pathSrc}/scss/${fileScss}`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename( {suffix: '.min'} ))
        .pipe(sourcemaps.write())
        .pipe(dest(`${pathAssetsCss}/${desc}`))
        .pipe(browserSync.stream({ match: '**/*.css' }));
}

// compiler folder scss
function compilerFolderScss(folder, levelFile = '*.scss') {
    return src(`${pathSrc}/scss/${folder}/${levelFile}`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename( {suffix: '.min'} ))
        .pipe(sourcemaps.write())
        .pipe(dest(`${pathAssetsCss}/${folder}`))
        .pipe(browserSync.stream({ match: '**/*.css' }))
}

// compiler lib scss
function compilerLibCss(folder, folderDesc) {
    return src(`./node_modules/${folder}`)
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathAssets}/${folderDesc}`))
        .pipe(browserSync.stream({ match: '**/*.css' }))
}

// compiler lib js
function compilerLibJs(folder, folderDesc) {
    return src(`./node_modules/${folder}`, {allowEmpty: true})
        .pipe(uglify())
        .pipe(rename( {suffix: '.min'} ))
        .pipe(dest(`${pathAssets}/${folderDesc}`))
        .pipe(browserSync.stream())
}

// Task build Bootstrap
async function buildStylesBootstrap() {
    return src(`${pathSrc}/scss/bootstrap.scss`)
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename( {suffix: '.min'} ))
        .pipe(dest(`${pathAssets}/libs/bootstrap`))
        .pipe(browserSync.stream({ match: '**/*.css' }))
}
async function buildJsBootstrap() {
    compilerLibJs('bootstrap/dist/js/bootstrap.bundle.js', 'libs/bootstrap')
}

/*
Task build owl carousel
* */
async function buildStylesOwlCarousel() {
    compilerLibCss('owl.carousel/dist/assets/owl.carousel.css', 'libs/owl.carousel')
}

async function buildJsOwlCarouse() {
    compilerLibJs('owl.carousel/dist/owl.carousel.js', 'libs/owl.carousel')
}

// Task build slick
async function buildSlickStyle() {
    compilerLibCss('slick-carousel/slick/slick.css', 'libs/slick-carousel')
}
async function buildSlickJs() {
    compilerLibJs('slick-carousel/slick/slick.js', 'libs/slick-carousel')
}

// Task build masonry
async function buildMasonryJs() {
    return src([
        './node_modules/imagesloaded/imagesloaded.pkgd.js',
        './node_modules/masonry-layout/dist/masonry.pkgd.js',
    ], {allowEmpty: true})
        .pipe(concat('masonry.min.js'))
        .pipe(uglify())
        .pipe(dest('./assets/libs/masonry'));
}

// Task build lity
async function buildLityStyle() {
    compilerLibCss('lity/dist/lity.css', 'libs/lity')
}

async function buildLityJs() {
    compilerLibJs('lity/dist/lity.js', 'libs/lity')
}

// Task build styles
async function buildStylesTheme() {
    compilerFileScss('style-theme.scss')
}

// Task build template page
async function buildTemplateStyles() {
    compilerFolderScss('templates')
}

// Task build post type
async function buildPostType() {
    compilerFolderScss('post-type', '*/**.scss')
}

// buildJSTheme
async function buildJSTheme() {
    return src([
        `${pathSrc}/js/**.js`
    ], {allowEmpty: true})
        .pipe(uglify())
        .pipe(rename( {suffix: '.min'} ))
        .pipe(dest(`${pathAssets}/js/`))
        .pipe(browserSync.stream());
}

// Task build style elementor
async function buildStylesElementor() {
    return src(`${pathSrc}/scss/elementor-addon/elementor-addon.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename( {suffix: '.min'} ))
        .pipe(sourcemaps.write())
        .pipe(dest(`${pathTheme}/extension/elementor-addon/css/`))
        .pipe(browserSync.stream());
}

async function buildJSElementor() {
    return src([
        `${pathSrc}/js/elementor-addon/*.js`
    ], {allowEmpty: true})
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathTheme}/extension/elementor-addon/js/`))
        .pipe(browserSync.stream());
}

// Task optimize images
function optimizeImages() {
    const imgDst = `${pathAssets}/images/`;

    return src([
        `${pathSrc}/images/*`,
        `${pathSrc}/images/*/**`
    ], {encoding: false})
        .pipe(imagemin())
        .pipe(dest(imgDst))
        .pipe(browserSync.stream())
}

exports.optimizeImages = optimizeImages

// Build all
async function buildAll() {
    // build lib bootstrap
    await buildStylesBootstrap()
    await buildJsBootstrap()

    // build lib owl carousel
    await buildStylesOwlCarousel()
    await buildJsOwlCarouse()

    // build lib slick
    await buildSlickStyle()
    await buildSlickJs()

    // build lib masonry
    await buildMasonryJs()

    // build lib lity
    await buildLityStyle()
    await buildLityJs()

    await buildStylesTheme()
    await buildTemplateStyles()
    await buildPostType()
    await buildJSTheme()

    await buildStylesElementor()
    await buildJSElementor()

    browserSync.reload()
}
exports.buildAll = buildAll

// watch
async function watchRun() {
    server()

    watch([
        `${pathSrc}/scss/variables-site/*.scss`,
    ], series(
        buildStylesBootstrap,
        buildStylesTheme,
        buildTemplateStyles,
        buildPostType,
        buildStylesElementor
    ))

    watch([
        `${pathSrc}/scss/bootstrap.scss`
    ], buildStylesBootstrap)

    watch([
        `${pathSrc}/scss/base/*.scss`,
        `${pathSrc}/scss/style-theme.scss`,
    ], buildStylesTheme)

    watch([
        `${pathSrc}/scss/components/*.scss`,
        `${pathSrc}/scss/templates/*.scss`
    ], buildTemplateStyles)
    
    watch([
        `${pathSrc}/scss/components/*.scss`,
        `${pathSrc}/scss/post-type/*/**.scss`
    ], buildPostType)

    watch([
        `${pathSrc}/scss/elementor-addon/*.scss`
    ], buildStylesElementor)

    watch([`${pathSrc}/js/**.js`], buildJSTheme)

    watch([
        `${pathSrc}/js/elementor-addon/*.js`
    ], buildJSElementor)

    watch(`${pathSrc}/images/**/*`, optimizeImages)

    watch([
        './*.php',
        './**/*.php',
        `${pathAssets}/images/**/*`
    ], browserSync.reload);
}

exports.watchRun = watchRun;