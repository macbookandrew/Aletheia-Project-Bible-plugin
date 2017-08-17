module.exports = function (grunt) {
  grunt.initConfig({
    // Watch task config
    watch: {
        javascript: {
            files: ["inc/*.js", "!inc/*.min.js"],
            tasks: ['uglify'],
        },
    },
    uglify: {
        custom: {
            files: {
                'inc/frontend.min.js': ['inc/frontend.js'],
            },
        },
    },
  });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', [
        'watch',
    ]);
};
