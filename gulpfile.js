const { src, dest, series } = require('gulp');
const replace = require('gulp-replace');
const { argv } = require('yargs');
const { pascalCase, paramCase, snakeCase, capitalCase, camelCase } = require("change-case");
const rename = require('gulp-rename');
const del = require('del');

const viewDirectories = [
    'views/plates-4',
    'views/plates',
    'views/twig',
    'views/blade'
];

const viewClasses = {
    'plates-4': 'LegacyPlatesView',
    'blade': 'BladeView',
    'twig': 'TwigView',
    'plates': 'PlatesView',
};

function swapNameStrings() {
    let paths = [
        'app/**/**',
        'composer.json',
        'package.json.stub',
        'webpack.config.js',
        'replace-me.php',
        'uninstall.php',
        'tests/**/**',
        'phpstan.neon.exaample'
    ];
    let pascalName = pascalCase(argv.name);
    let kebabName = paramCase(argv.name);
    let snakeName = snakeCase(argv.name);
    let titleName = capitalCase(argv.name);
    return src(paths, { base: "./" })
        .pipe(replace('ReplaceMe', pascalName))
        .pipe(replace('replace-me', kebabName))
        .pipe(replace('replace_me', snakeName))
        .pipe(replace('Replace Me', titleName))
        .pipe(dest('./'));
}

function swapVendorStrings() {
    if (typeof argv.vendor === "undefined") {
        argv.vendor = "App";
    }
    let paths = [
        'app/**/**',
        'composer.json',
        'replace-me.php',
        'uninstall.php'
    ];
    let pascalName = pascalCase(argv.vendor);
    let kebabName = paramCase(argv.vendor);
    let camelName = camelCase(argv.vendor);
    return src(paths, { base: "./" })
        .pipe(replace('VendorName', pascalName))
        .pipe(replace('vendor-name', kebabName))
        .pipe(replace('vendorName', camelName))
        .pipe(dest('./'));
}

function renameFiles() {
    let paths = [
        'replace-me.php',
        'languages/replace-me.pot'
    ];
    let kebabName = paramCase(argv.name);
    return src(paths, { base: "./" })
        .pipe(rename(function (path) {
            path.basename = kebabName;
        }))
        .pipe(dest('./'));
}

function deleteRenamedFiles() {
    return del([
        'replace-me.php',
        'languages/replace-me.pot'
    ]);
}

function copyViews() {
    if (typeof argv.view === "undefined") {
        argv.view = "plates-4";
    }
    // copy contents to /views/
    return src('views/' + argv.view + '/**/**').pipe(dest('./views/'));
}

function deleteSourceViews() {
    return del(viewDirectories);
}

function updateViewClass() {
    if (typeof argv.view === "undefined") {
        argv.view = "plates-4";
    }
    return src('./app/Core/View.php')
        .pipe(replace('ViewClassGoesHere', viewClasses[argv.view]))
        .pipe(dest('./app/Core/'));
}

exports.default = series(swapNameStrings, swapVendorStrings, renameFiles, deleteRenamedFiles, copyViews, deleteSourceViews, updateViewClass);
