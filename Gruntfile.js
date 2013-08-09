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
        files: ['assets/js/app.js'], //['**/*.js'],
        tasks: ['uglify'],
        options: {
          spawn: false
        }
      },
      scss: {
        files: ['assets/scss/*'], //['**/*.js'],
        tasks: ['compass'],
        options: {
          spawn: false
        }
      }
    },
    copy: {
      boston: { files: [ { expand: true, src: ['subdomains/beta/**'], dest: 'subdomains/boston/' } ] },
      dc:     { files: [ { expand: true, src: ['subdomains/beta/**'], dest: 'subdomains/dc/'     } ] },
      milano: { files: [ { expand: true, src: ['subdomains/beta/**'], dest: 'subdomains/milano/' } ] },
      nyc:    { files: [ { expand: true, src: ['subdomains/beta/**'], dest: 'subdomains/nyc/'    } ] }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-copy');

  // Default task(s).
  grunt.registerTask('default', ['watch']);

};