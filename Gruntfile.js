module.exports = function(grunt) {
	var path_srv = grunt.file.readJSON("path_srv.json");
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
		//personnal use for ftp deploy to delete
        'sftp-deploy': {
            'one': {
                auth: {
                    host: path_srv.server.dest1.host,
                    port: 22,
                    authKey: 'key1'
                },
                src: path_srv.local.path,
                dest: path_srv.server.dest1.path,
                exclusions: path_srv.exclusions,
                serverSep: '/',
                localSep: '/',
                concurrency: 4,
                progress: true
            },
            'two': {
                auth: {
                    host: path_srv.server.dest2.host,
                    port: 22,
                    authKey: 'key1'
                },
                src: path_srv.local.path,
                dest: path_srv.server.dest2.path,
                exclusions: path_srv.exclusions,
                serverSep: '/',
                localSep: '/',
                concurrency: 4,
                progress: true
            },
            'three': {
                auth: {
                    host: path_srv.server.dest3.host,
                    port: 22,
                    authKey: 'key1'
                },
                src: path_srv.local.path,
                dest: path_srv.server.dest3.path,
                exclusions: path_srv.exclusions,
                serverSep: '/',
                localSep: '/',
                concurrency: 4,
                progress: true
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