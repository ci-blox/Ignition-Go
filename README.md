# Ignition Go
A Modular App Building Framework - create and reuse "blox" to build enterprise class web applications
- uses Codeigniter 3.x and Bootstrap 3.x
- can be used as a quickstart project starter/boilerplate
- *What are blox?* "Blox" are just pluggable modules or applets that are commonly used in web applications. Ignition Go will include a web-based generator.

### Coming soon (alpha in February 2016), contact us to help build the most amazing web app builder ever!  
Please contact me to help, I'm hoping to build a team of master "Blox Ignitians".
Planned example "blox" include bulk emailer, dashboard, report manager, and many more!!!  

### Server Requirements (Preferred)

* **PHP 5.5+** (mainly for [password_hash()](http://php.net/manual/en/function.password-hash.php) and [password_verify()](http://php.net/manual/en/function.password-verify.php) functions as used in this project); and also the usage of [shortcut syntax](http://php.net/manual/en/migration54.new-features.php) in this project needs  **5.4+** and above.
* **Apache 2.2+** with rewrite mod enabled
* **MySQL 5.5+**


### Features

Ignition Go will be a jumpstart for rapid development:
* Multi-faceted (e.g. Frontend Website, Admin Panel, and API) website in a single application
* Modular design using CodeIgniter HMVC extension
* Custom config files (sites.php, locale.php) for easy configuration of website behavior
* Admin Panel with AdminLTE v2 theme
* Includes usage of [Sortable](http://rubaxa.github.io/Sortable/) library and many other 3rd party optional libraries
* API Site to handle RESTful endpoints
* User authentication (optional) for Frontend Website (Sign Up, Login, Forgot Password, et al)
* User authentication for Admin Panel (Login, Change Password, et al)
* Preset layouts and templates
* Preset asset pipeline (e.g. minify scripts, image optimization) via Gulp (reference from [gulp-starter 2.0 branch](https://github.com/greypants/gulp-starter/tree/2.0))
* Buildablox blox and form builder to generate blox and CRUD form views with Bootstrap theme, form validation
* Breadcrumb and Pagination handling
* Multilingual support
* Email config setup
* CLI utility functions (e.g. cron job, database backup)


### Folder Structure

Planned folder structure (not all folders shown).

```
application/                    --- Main application (CodeIgniter) source folder
    config/                     --- Config files
        production/             --- Override Configuration when ENVIRONMENT is set as "production"
    controllers/                --- Controllers for Frontend Website; extends from MY_Controller (except Cli)
        Cli.php                 --- Utility function that can only be called from command line
        Home.php                --- Default controller for Frontend Website        
    core/                       --- Extending CodeIgniter core classes; can also be used within modules (MY_????.php)
    helpers/                    --- Contains custom helper functions being used throughout this repo
    language/                   --- Preset language files
    lib/                        --- Custom libraries (e.g. Data Importer)
    models/                     --- Sample model extending from MY_Model
    toolblox/                   --- Each blox module can be installed or removed
    modules/                    --- Each module can be accessed by http://{base_url}/{module_name}/{module_controller}/, etc.
        admin/                  --- Module for Admin Panel
            config/             --- Configuration for Admin Panel (overriding application/config/)
            controllers/        --- Controllers for Admin Panel; also extends from MY_Controller
            helpers/            --- Helper classes, e.g. to generate AdminLTE widgets
            lib/                --- Libraries admin 
            models/             --- Models only being used in Admin panel
            views/              --- Views for Admin Panel; can reuse Frontend views, or override by using same path/filename
        api/                    --- A module specific for REST API endpoints
        buildablox/             --- A module to generate and add/remove blox
        securify/               --- A module for roles, permissions, security settings
        translate/              --- A module to auto-generate translations
    third_party/
        MX/                     --- Required for HMVC extension
    views/                      --- Views for Frontend Website
public/                        --- site root
public/assets/
    css/                        --- Custom CSS files append to each site
    dist/                       --- Minified scripts, stylesheets and optimized images via Gulp tasks
    fonts/                      --- Font files copied via Gulp tasks
    images/                     --- Source image files before optimization
    js/                         --- Custom CSS files append to each site
    uploads/                    --- Default directory of upload files, where permission should set as writable
gulpfile.js/                    --- Task runner following gulp-starter 2.0 practice
sql/                            --- MySQL files
ignitcore/                         --- Ignition Go core files
ignitcore/system/                         --- CodeIgniter core files (unchanged as clean CI3 installation)

### Asset Customization (e.g. additional js/css files)

A gulp file (**gulpfile.js**) is included. It utilizes package and component tools from these sites:
* NPM [node.js](http://nodejs.org/): package manager for node modules
* Bower [bower](http://bower.io/): manager for bower components 
* GulpJS [gulp](http://gulpjs.com/): task runner to compile, combine, and minify
