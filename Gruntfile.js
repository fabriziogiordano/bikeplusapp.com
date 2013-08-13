module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        mangle : true,
        report: 'gzip',
        preserveComments: false,
        compress: {
          global_defs: {
            "DEBUG": false
          },
          dead_code: true
        },
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd HH:MM") %> */\n'
      },
      build: {
        src:  ['subdomains/assets/js/tmpl.js','subdomains/assets/js/app.js'],
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
      },
      dot: {
        files: ['subdomains/assets/dotT/*'], //['**/*.js'],
        tasks: ['dot', 'uglify'],
        options: {
          spawn: false
        }
      }
    },
    copy: {
      beta:   { files: [ { expand: true, dot: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/beta/'   } ] },
      boston: { files: [ { expand: true, dot: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/boston/' } ] },
      dc:     { files: [ { expand: true, dot: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/dc/'     } ] },
      london: { files: [ { expand: true, dot: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/london/' } ] },
      mi:     { files: [ { expand: true, dot: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/mi/'     } ] },
      nyc:    { files: [ { expand: true, dot: true, cwd: 'subdomains/dev/', src: ['**'], dest: 'subdomains/nyc/'    } ] }
    },
    dot: {
      dist: {
        options: {
          variable  : 'bikeplusoptions.tmpl',
          //root      : __dirname + '/app/profiles',
          //requirejs : false,
          //node      : false
        },
        src  : ['subdomains/assets/dotT/*.dot'],
        dest : 'subdomains/assets/js/tmpl.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-dot-compiler');

  // Default task(s).
  grunt.registerTask('default', ['watch']);

};