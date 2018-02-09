# Ignition Go     

A Modular (HMVC) App Building Framework - complete with front end, REST api, and admin area

CURRENTLY USES BOOTSTRAP 4 AND USES YARN INSTEAD OF NPM / BOWER NOW. (if you want the old Bootstrap 3.3 see the previous releases)

- create "blox" modules to build enterprise class web applications
- uses Codeigniter 3.x,  Bootstrap 4.0.x
- can be used as a quickstart project starter/boilerplate
- *What are blox?* "Blox" are just pluggable modules or applets that are commonly used in web applications. Ignition Go includes a web-based generator. Planned example "blox" would be a bulk emailer, report manager, and many more!!!  


### Server Requirements (Preferred)

* **PHP 5.6, 7.1, 7.2** you can run in lower (5.4/5.5) but lowest recommended version to use is [PHP 5.6](http://php.net/manual/en/migration56.new-features.php) (http://php.net/manual/en/migration55.new-features.php) for this project. 
* **Apache 2.2+** with rewrite mod enabled
* **MySQL 5.5+ or MariaDb**


### Features

Ignition Go is a jumpstart for your rapid development:
* Multi-faceted (e.g. Frontend Website, Authorized User Only modules, Admin Panel, and API) website in a single application
* Modular design using CodeIgniter HMVC extension
* Custom config files (sites.php, locale.php) for easy configuration of website behavior
* Frontend with multiple themes (with over 16 free Bootswatch themes)
* Admin Panel with AdminLTE v2 theme
* Includes usage of many other 3rd party optional libraries via Composer, NPM or Yarn
* API Site to handle RESTful endpoints
* User authentication (optional) for Frontend Website (Sign Up, Login, Forgot Password, et al)
* User authentication for Admin Panel (Login, Change Password, et al)
* Preset layouts and templates
* Preset asset pipeline (e.g. minify scripts, image optimization) via Gulp (reference from [gulp-starter 2.0 branch](https://github.com/greypants/gulp-starter/tree/2.0))
* Buildablox blox module/form builder to generate blox and CRUD form views with Bootstrap theme, form validation
* Breadcrumb and Pagination handling
* Multilingual support
* Email config setup
* CLI utility functions (e.g. cron job, database backup)
* Guzzle client integrated as library (use instead of Curl)
* Use gulp serve to instantly see updates to code


### Folder Structure

Folder structure (most but not all folders shown). **=not available yet

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
        translate/              --- A module to edit  (and auto-generate**) translations
    third_party/
        MX/                     --- Required for HMVC extension
    views/                      --- Views for Frontend Website
public/                         --- SITE ROOT (point Apache here)
public/assets/
    css/                        --- Custom CSS files append to each site
    dist/                       --- Minified scripts, stylesheets (and optionally) optimized images via Gulp tasks
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

A gulp configuration (**gulpfile.js**) is included. It utilizes package and component tools from these sites:
* Yarn [yarnpkg.com](https://yarnpkg.com/en/): package manager for dependencies
* GulpJS [gulpjs](http://gulpjs.com/): task runner to compile, combine, and minify
* Guzzle [guzzlephp](http://guzzlephp.com/): integrated for use as a REST client or for complex curl operations

### Documentation
There are several markdown files with information on various features.  Here is a listing of some key concepts documents:
* [Ignition-Go ACL: Users, Roles and Permissions](http://ci-blox.github.io/Ignition-Go/DocACL.html)
* [Ignition-Go Module Blox](http://ci-blox.github.io/Ignition-Go/DocBuildABlox.html)
* [Ignition-Go Controllers](http://ci-blox.github.io/Ignition-Go/DocControllers.html)
* [Ignition-Go Models](http://ci-blox.github.io/Ignition-Go/DocModels.html)
* [Ignition-Go Views and Themes (the Template library)](http://ci-blox.github.io/Ignition-Go/DocViewsThemes.html)

### Acknowledgements
Special thanks to the [Bonfire](http://cibonfire.com) project and those who contributed to it - many features and infrastructure concepts were inspired or incorporated outright from that project.  Also thanks to all the projects like GuzzlePHP and countless others that are open source, whose components are incorporated and allow this initiative to exist.  Finally, thanks especially to the CodeIgniter team, with whom CodeIgniter continues to thrive!
