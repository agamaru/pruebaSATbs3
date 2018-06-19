var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();

gulp.task('default', function() {

    // copiar scss de Bootstrap
    gulp.src('node_modules/bootstrap-sass/assets/stylesheets/*')
        .pipe(gulp.dest('web/scss/bootstrap'));

    // copiar scss de Bootstrap
    gulp.src('node_modules/bootstrap-sass/assets/stylesheets/bootstrap/*')
        .pipe(gulp.dest('web/scss/bootstrap/bootstrap'));

    // copiar scss de Bootstrap
    gulp.src('node_modules/bootstrap-sass/assets/stylesheets/bootstrap/mixins/*')
        .pipe(gulp.dest('web/scss/bootstrap/bootstrap/mixins'));

    // copiar css del tema de bootstrap para Select2
    gulp.src('node_modules/select2-bootstrap-theme/dist/*')
        .pipe(gulp.dest('web/css'));

    // copiar css de Select2
    gulp.src('node_modules/select2/dist/css/*')
        .pipe(gulp.dest('web/css'));

    // copiar css de DataTables
    gulp.src('node_modules/datatables.net-bs/css/*')
        .pipe(gulp.dest('web/css'));

    // copiar fuentes de Bootstrap
    gulp.src('node_modules/bootstrap-sass/assets/fonts/bootstrap/*')
        .pipe(gulp.dest('web/fonts/bootstrap'));

    // copiar jQuery
    gulp.src('node_modules/jquery/dist/*.min.js')
        .pipe(gulp.dest('web/js/jquery'));

    // copiar Javascript de Bootstrap
    gulp.src('node_modules/bootstrap-sass/assets/javascripts/*.min.js')
        .pipe(gulp.dest('web/js/bootstrap'));

    // copiar Javascript de Select2
    gulp.src('node_modules/select2/dist/js/*')
        .pipe(gulp.dest('web/js/select2'));

    // copiar Javascript de Select2
    gulp.src('node_modules/select2/dist/js/i18n/*')
        .pipe(gulp.dest('web/js/select2/i18n'));

    // copiar Javascript de DataTables
    gulp.src(['node_modules/datatables.net/js/*', 'node_modules/datatables.net-bs/js/*'])
        .pipe(gulp.dest('web/js/datatables'));

});
