module.exports = function(grunt) {
	require('load-grunt-tasks')(grunt);
	
	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				options: {
					style: 'compressed'
				},
				files: {
					'app/views/template/css/style.css': 'app/views/template/css/style.scss',
                    'app/views/template/css/404.css': 'app/views/template/css/404.scss',
                    'admin/views/template/css/style.css': 'admin/views/template/css/style.scss',
				}
			}
		},
        watch: {
            styles: {
                files: '**/*.scss', // tous les fichiers Sass de n'importe quel dossier
                tasks: ['sass:dist']
            }
        }
	});
    
    grunt.registerTask('default', ['sass']);
};