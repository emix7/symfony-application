module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/toastr.js': 'toastr/toastr.js',
                    'js/rrssb.js': 'RRSSB/js/rrssb.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootswatch/flatly/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css',
                    'css/toastr.css': 'toastr/toastr.css',
                    'css/rrssb.css': 'RRSSB/css/rrssb.css',
                    'css/flag-icon.css': 'flag-icon-css/css/flag-icon.css',
                    'css/gh-fork-ribbon.css': 'github-fork-ribbon-css/gh-fork-ribbon.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'font-awesome/fonts'
                }
            }
        },
        cssmin : {
            bundled:{
                src: 'web/assets/css/bundled.css',
                dest: 'web/assets/css/bundled.min.css'
            }
        },
        uglify : {
            js: {
                files: {
                    'web/assets/js/bundled.min.js': ['web/assets/js/bundled.js']
                }
            }
        },
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    'web/assets/css/bootstrap.css',
                    'web/assets/css/font-awesome.css',
                    'web/assets/css/toastr.css',
                    'web/assets/css/rrssb.css',
                    'web/assets/css/flag-icon.css',
                    'web/assets/css/gh-fork-ribbon.css',
                    'src/AppBundle/Resources/public/css/*.css'
                ],
                dest: 'web/assets/css/bundled.css'
            },
            js : {
                src : [
                    'web/assets/js/jquery.js',
                    'web/assets/js/bootstrap.js',
                    'web/assets/js/material.js',
                    'web/assets/js/toastr.js',
                    'web/assets/js/rrssb.js',
                    'src/AppBundle/Resources/public/js/*.js'
                ],
                dest: 'web/assets/js/bundled.js'
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/img',
                src: '*',
                dest: 'web/assets/images/'
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['bowercopy','copy', 'concat', 'cssmin', 'uglify']);
};
