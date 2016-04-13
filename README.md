# Ignition Go     | <a style="text-align:right" href='https://pledgie.com/campaigns/30957'><img alt='Click here to lend your support to: Ignition Go - development fund and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/30957.png?skin_name=chrome' border='0' ></a>
A Modular App Building Framework - complete with front end, REST api and admin area
- [Soon] create and reuse "blox" to build enterprise class web applications
- uses Codeigniter 3.x and Bootstrap 3.x
- can be used as a quickstart project starter/boilerplate
- *What are blox?* "Blox" are just pluggable modules or applets that are commonly used in web applications. Ignition Go will include a web-based generator. Planned example "blox" include bulk emailer, dashboard, report manager, and many more!!!  

### In progress (see below folder structure for progress), contact us to help build the most amazing web app builder ever!  
Please contact us to contribute.

### Server Requirements (Preferred)

* **PHP 5.4+** ideal is 5.5 but minimum is [PHP 5.4](http://php.net/manual/en/migration54.new-features.php) for this project. Use of [GuzzlePHP](http://guzzlephp.com) requires PHP 5.5
* **Apache 2.2+** with rewrite mod enabled
* **MySQL 5.5+**

### Installing
1.Install NPM [node.js](http://nodejs.org/): package manager for node modules
2.Install Bower [bower](http://bower.io/): manager for bower components 
3.GIT clone this repository
4.Install and run 'gulp'
5.In Apache, map to the public folder to localhost or other url
6.Create an empty mysql db
7.Go to http://localhost/install/init to finish 

### Features

Ignition Go will be a jumpstart for your rapid development:
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
* Guzzle client integrated as library
* Frontend theme (default) is integrated to work easily with over 16 free Bootswatch themes


### Folder Structure

Planned folder structure (not all folders shown). **=not available yet

```
application/                    --- Main application (CodeIgniter) source folder
    config/                     --- Config files
        production/             --- Override Configuration when ENVIRONMENT is set as "production"
    controllers/                --- Controllers for Frontend Website; extends from MX_Controller, Base_Controller or Front_Controller
        Cli.php                 --- Utility function that can only be called from command line
        Home.php                --- Default controller for Frontend Website        
    core/                       --- Extending CodeIgniter core classes; can also be used within modules (MY_????.php); Also extendable controllers here
    helpers/                    --- Contains custom helper functions being used throughout this repo
    language/                   --- Preset language files
    lib/                        --- Custom libraries (e.g. Data Importer)
    models/                     --- Sample model extending from MY_Model
    toolblox/ **                --- Each blox module can be installed or removed
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
        securinator/            --- A module for roles, permissions, security settings
        translate/ **           --- A module to auto-generate translations
    third_party/
        MX/                     --- Required for HMVC extension
    views/                      --- Views for Frontend Website
public/                         --- SITE ROOT (point Apache here)
public/assets/
    css/                        --- Custom CSS files append to each site
    dist/ **                    --- Minified scripts, stylesheets and optimized images via Gulp tasks
    fonts/                      --- Font files copied via Gulp tasks
    img/                        --- Source image files before optimization
    js/                         --- Custom CSS files append to each site
    uploads/                    --- Default directory of upload files, where permission should set as writable
gulpfile.js/                    --- Task runner following gulp-starter 2.0 practice
sql/                            --- MySQL files
ignitcore/                         --- Ignition Go core files
ignitcore/system/                         --- CodeIgniter core files (clean CI3 installation with modifications only to reference IGO core)
```

### Asset Customization (e.g. additional js/css files)

A gulp file (**gulpfile.js**) is included. It utilizes package and component tools from these sites:
* NPM [node.js](http://nodejs.org/): package manager for node modules
* Bower [bower](http://bower.io/): manager for bower components 
* GulpJS [gulp](http://gulpjs.com/): task runner to compile, combine, and minify
* Guzzle [guzzle](http://guzzlephp.com/): integrated for use as a REST client or for complex curl operations

### Acknowledgements
Special thanks to the [Bonfire](http://cibonfire.com) project and those who contributed to it - many features and infrastructure concepts were inspired or incorporated outright from that project.  Also thanks to all the projects like GuzzlePHP and countless others that are open source, whose components are incorporated and allow this initiative to exist.
