const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/admin.js", "public/js/admin/")
    .js("resources/js/admin/customDropzone.js", "public/js/admin/")
    .combine(
        [
            "public/js/admin/admin.js",
            "node_modules/persian-date/dist/persian-date.min.js",
            "node_modules/persian-datepicker/dist/js/persian-datepicker.min.js",
            "public/plugins/persian-date-picker/custom.js",
            "public/plugins/jstree/jstree.min.js",
            "public/plugins/tinymce/tinymce.min.js",
            "public/plugins/tinymce/custom.js",
            "public/js/admin/customDropzone.js"
        ],
        "public/js/bundle/admin.js"
    );

// mix.sass('resources/sass/font-awesome.scss', 'public/plugins/fontawesome');

mix.combine(
    [
        "public/plugins/fontawesome/font-awesome.css",
        "public/css/admin/adminlte.min.css",
        "public/css/admin/bootstrap-rtl.min.css",
        "public/css/admin/custom-style.css",
        "public/plugins/datatables/dataTables.bootstrap4.css",
        "node_modules/persian-datepicker/dist/css/persian-datepicker.min.css",
        "public/plugins/persian-date-picker/custom.css",
        "public/plugins/jstree/style.min.css",
        "node_modules/dropzone/dist/min/basic.min.css",
        "node_modules/dropzone/dist/min/dropzone.min.css"
    ],
    "public/css/bundle/admin.css"
);
