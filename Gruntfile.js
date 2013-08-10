module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd HH:MM") %> */\n'
      },
      build: {
        src:  'subdomains/assets/js/app.js',
        dest: 'subdomains/assets/js/app.min.js'
      }
    },
    compass: {
      dist: {
        options: {
          config: 'subdomains/assets/config.rb'
        }
      }
    },
    watch: {
      //options: {
      //  livereload: true
      //},
      js: {
        files: ['subdomains/assets/js/app.js'], //['**/*.js'],
        tasks: ['uglify'],
        options: {
          spawn: false
        }
      },
      scss: {
        files: ['subdomains/assets/scss/*'], //['**/*.js'],
        tasks: ['compass'],
        options: {
          spawn: false
        }
      }
    },
    copy: {
      boston: { files: [ { expand: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/boston/' } ] },
      dc:     { files: [ { expand: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/dc/'     } ] },
      mi:     { files: [ { expand: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/mi/'     } ] },
      nyc:    { files: [ { expand: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/nyc/'    } ] },
      beta:   { files: [ { expand: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/beta/'   } ] }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-copy');

  // Default task(s).
  grunt.registerTask('default', ['watch']);

};