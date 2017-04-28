'use-strict';

var gulp = require('gulp'),
        
    // Sass/CSS processes
    bourbon = require('bourbon').includePaths,
    neat = require('bourbon-neat').includePaths,
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssmqpacker = require('css-mqpacker'),
    sourcemaps = require('gulp-sourcemaps'),
    cssminify = require('gulp-cssnano'),
    sasslint = require('gulp-sass-lint'),
    uglifyjs = require('gulp-uglify'),
    moduleimporter = require('sass-module-importer'),
    
    // Utilities
    rename = require('gulp-rename'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber');
    
    
/************
 * Utilities
 ************/ 

/**
 * Error handling
 * 
 * @function
 */
function handleErrors() {
    var args = Array.prototype.slice.call(arguments);
    
    notify.onError({
        title: 'Task Failed [<%= error.message %>',
        message: 'See console.',
        sound: 'Sosumi'
    }).apply(this, args);
    
    gutil.beep(); // Beep 'sosumi' again
    
    // Prevent the 'watch' task from stopping
    this.emit('end');
}
    
/************
 * CSS Tasks
 ************/   


/**
 * PostCSS Task Handler
 */
gulp.task('postcss', function(){
   
    return gulp.src('assets/sass/style.scss')
    
        // Error handling
        .pipe(plumber({
            errorHandler: handleErrors
        }))
    
        // Wrap tasks in a sourcemap
        .pipe( sourcemaps.init())

        .pipe( sass({
            includePaths: [].concat( bourbon, neat),
            errLogToConsole: true,
            outputStyle: 'expanded'
        }))
        
        .pipe( postcss([
            autoprefixer({
                browsers: ['> 2%', 'last 2 versions']
            }),
            cssmqpacker({
                sort: true
            })
        ]))
        // creates the sourcemap
        .pipe(sourcemaps.write())
        
        .pipe(gulp.dest('./'));
});

gulp.task('css:minify', ['postcss'], function() {
    return gulp.src('style.css')
    
        // Error handling
        .pipe(plumber({
            errorHandler: handleErrors
        }))
            
        .pipe( cssminify({
            safe: true
        }))
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('./'))

        .pipe(notify({
            message: 'Styles are built.'
        }));
});

gulp.task('sass:lint', ['css:minify'], function() {
    gulp.src([
        'assets/sass/style.scss',
        '!assets/sass/base/html5-reset/_normalize.scss',
        '!assets/sass/utilities/animate/**/*.*'
    ])
    .pipe(sasslint())
    .pipe(sasslint.format())
    .pipe(sasslint.failOnError());
});

/************
 * All Tasks Listeners
 ************/   

gulp.task('watch', function() {
    gulp.watch('assets/sass/**/*.scss', ['styles']);
});

/**
 * Individual tasks.
 */


// Build and compress styles with 'gulp styles'
gulp.task('styles', ['sass:lint']);

// Compress js with 'gulp compress-js'
gulp.task('compress-js', function () {
    return gulp.src('assets/js/theme-scripts.js')
    
        // Error handling
        .pipe(plumber({
            errorHandler: handleErrors
        }))
        
        .pipe(uglifyjs())
        
        .pipe(rename('theme-scripts.min.js'))

        .pipe(gulp.dest('assets/js/'))
        
        .pipe(notify({
            message: 'JS is compressed.'
        }));
});