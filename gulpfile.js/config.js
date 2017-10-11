/**
 * Gulp configuration file
 */

// basic paths
var dir_bower = "./public/components",
	dir_public = "./public",
	dir_asset = "./public/assets",
	dir_dist = dir_asset + "/dist",
	dir_fonts = dir_asset + "/fonts";

module.exports = {

	// php server (php 5.4+)
	php: {
		src: "application/**/*.php",
		settings: {
			base: dir_public,
			port: 8010,
			keepalive: true
		}
	},

	// browser-sync (linked with php server for live reload)
	browserSync: {
		settings: {
			proxy: "127.0.0.1:8010",
			port: 8080,
			open: false,
			notify: false
		}
	},
	
	// clean
	clean: {
		src: [
			dir_dist + "**/*",
			dir_fonts + "**/*",
			"!" + dir_dist + "/index.html",
			"!" + dir_fonts + "/index.html",
		]
	},

	// copy
	copy: {
		src: {
			fonts: [
				// bower files
				dir_bower + '/bootstrap/dist/fonts/*',
				dir_bower + '/font-awesome/fonts/*',
				dir_bower + '/ionicons/fonts/*'
			],
			scripts: [
				// js files
				dir_bower + '/jquery/dist/jquery.min.js',
				dir_bower + '/bootstrap/dist/js/bootstrap.min.js',
			],
			csslib: [
				dir_bower + '/bootstrap/dist/css/bootstrap.min.css'				
			]
		},
		dest: {
			fonts: dir_fonts,
			scripts: dir_dist,
			csslib: dir_dist
		}
	},

	// css (minify)
	css: {
		src: {
			frontend: [
				// bower files
				dir_bower + '/bootstrap/dist/css/bootstrap-theme.css',
				dir_bower + '/font-awesome/css/font-awesome.css',
				// custom files
				dir_asset + '/css/frontend.css'
			],
			admin: [
				// bower files
				dir_bower + '/font-awesome/css/font-awesome.css',
				dir_bower + '/ionicons/css/ionicons.min.css',
				dir_bower + '/admin-lte/dist/css/AdminLTE.min.css',
				//dir_bower + '/admin-lte/dist/css/skins/_all-skins.css',
				// custom files
				dir_asset + '/css/admin.css'
			]
		},
		dest: dir_dist,
		dest_file: {
			frontend: 'app.min.css',
			admin: 'admin.min.css'
		},
		settings: {
			keepBreaks: false,
			compatibility: 'ie8'
		}
	},

	// js (uglify)
	js: {
		src: {
			frontend: [
				// bower files
				// dir_bower + '/jquery/dist/jquery.js',
				//dir_bower + '/bootstrap/dist/js/bootstrap.min.js',
				// custom files
				dir_asset + '/js/frontend.js'
			],
			admin: [
				// bower files 
				//dir_bower + '/jquery-legacy/dist/jquery.js',
				dir_bower + '/jquery-migrate/jquery-migrate.js',
				dir_bower + '/admin-lte/bootstrap/js/bootstrap.js',
				//dir_bower + '/admin-lte/plugins/fastclick/fastclick.js',
				dir_bower + '/admin-lte/dist/js/adminlte.js',
				//dir_bower + '/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
				dir_bower + '/Sortable/Sortable.js',
				// custom files
				dir_asset + '/js/admin.js'
			]
		},
		dest: dir_dist,
		dest_file: {
			frontend: 'frontend.min.js',
			admin: 'admin.min.js'
		},
		settings: {
			outSourceMap: true
		}
	} //,

	// imagemin
	//images: {
	//	src: dir_asset + "/images/**/*.{png,jpg,gif}",
	//	dest: dir_dist + "/images"
	//}

};
