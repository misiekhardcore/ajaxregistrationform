const gulp = require('gulp')
const sass = require('gulp-sass')
const sync = require('browser-sync').create()

// compile scss to css

function style(){
    //1. where is my scss file

    return gulp.src('./scss/**/*.scss')

    //2. pass the file through compiler

    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    
    //3. where i want the file to be saved

    .pipe(gulp.dest('./css'))

    //4. stream changes to all browser

    .pipe(sync.stream())
}

function watch(){
    sync.init({  
        proxy: 'localhost/ajaxregisterlogin/',
        port: 8000
    })
    gulp.watch('./scss/**/*.scss', style)
    gulp.watch('./*.html').on('change', sync.reload)
    gulp.watch('./*.php').on('change', sync.reload)
    gulp.watch('./js/**/*.js').on('change', sync.reload)
}

exports.style = style
exports.watch = watch

gulp.task('default',watch)

//use gulp watch in terminal ctrl + `
//use gulp watch in terminal ctrl + `
//use gulp watch in terminal ctrl + `
//use gulp watch in terminal ctrl + `