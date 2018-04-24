/**
 * Gulp configuration file
 */

// basic paths
var dir_packages = "./node_modules",
	dir_public = "./public",
	dir_asset = "./public/assets",
	dir_dist = dir_asset + "/dist",
	dir_fonts = dir_asset + "/fonts";
	dir_scss = dir_asset + "/scss";

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
				// font files to copy
				// dir_packages + '/bootstrap/dist/fonts/*',
				dir_packages + '/font-awesome/fonts/*',
				dir_packages + '/ionicons/dist/fonts/*'
			],
			scripts: [
				// js files
				dir_packages + '/jquery/dist/jquery.min.js',
				dir_packages + '/popper.js/dist/umd/popper.min.js',
				dir_packages + '/bootstrap/dist/js/bootstrap.min.js',
				dir_packages + '/admin-lte/dist/js/AdminLTE.min.js',
				dir_packages + '/admin-lte/plugins/iCheck/icheck.min.js'
			],
			scssbootstrap: [
				dir_packages + '/bootstrap/scss/**'				
			],
			csslib: [
				dir_packages + '/bootstrap/dist/css/bootstrap.min.css',				
				dir_packages + '/admin-lte/dist/css/AdminLTE.min.css',
				dir_packages + '/admin-lte/dist/css/skins/_all-skins.css',
				dir_packages + '/admin-lte/dist/css/skins/skin-purple.min.css'
			]
		},
		dest: {
			fonts: dir_fonts,
			scripts: dir_dist,
			scssbootstrap: dir_scss + '/bootstrap',
			csslib: dir_dist
		}
	},

	// css (minify)
	css: {
		src: {
			frontend: [
				// yarn files
				dir_packages + '/bootstrap/dist/css/bootstrap-theme.css',
				dir_packages + '/font-awesome/css/font-awesome.css',
				dir_packages + '/admin-lte/plugins/iCheck/all.css',
				// custom files
				dir_asset + '/css/frontend.css'
			],
			admin: [
				// yarn files
				dir_packages + '/font-awesome/css/font-awesome.css',
				dir_packages + '/ionicons/css/ionicons.min.css',
				dir_packages + '/admin-lte/plugins/iCheck/all.css',
				dir_packages + '/jquery-powertip/dist/css/jquery.powertip.css',
				//dir_packages + '/admin-lte/dist/css/AdminLTE.min.css',
				//dir_packages + '/admin-lte/dist/css/skins/_all-skins.css',
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
				// yarn files
				// dir_packages + '/jquery/dist/jquery.js',
				//dir_packages + '/bootstrap/dist/js/bootstrap.min.js',
				// custom files
				dir_asset + '/js/frontend.js'
			],
			admin: [
				// yarn files 
				//dir_packages + '/jquery-legacy/dist/jquery.js',
				//dir_packages + '/jquery-migrate/jquery-migrate.js',
				dir_packages + '/bootstrap/js/bootstrap.js',
				//dir_packages + '/admin-lte/plugins/fastclick/fastclick.js',
				dir_packages + '/admin-lte/dist/js/adminlte.js',
				dir_packages + '/jquery-powertip/dist/jquery.powertip.js',				
				dir_packages + '/jquery-slimscroll/jquery.slimscroll.js',
				dir_packages + '/Sortable/Sortable.js',
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
