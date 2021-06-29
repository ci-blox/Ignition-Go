# Ignition Go     |  [![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NV6YA38KWC8U4)
<small>  &nbsp;Status:</small> <img src="https://travis-ci.org/ci-blox/Ignition-Go.svg?branch=master"/> <img src="https://styleci.io/repos/49680592/shield?style=plastic&branch=master" />

A Modular (HMVC) App Building Framework - complete with front end, REST api, and 2 admin areas (Admin / Secure)

- create "blox" modules to build enterprise class web applications
- uses Codeigniter 3.x and Bootstrap 4.x.x
- can be used as a quickstart project starter/boilerplate
- *What are blox?* "Blox" are just pluggable modules or applets that are commonly used in web applications. Ignition Go includes a web-based generator (see BuildABlox). Planned example "blox" would be a bulk emailer, report manager, and many more!!!  

### Documentation
Documentation is now available: [Ignition-Go Documentation on GitHub] (http://ci-blox.github.io/Ignition-Go/#/concepts/ACL)
Take a look at the key concepts documents and also see the /docs folder for more.

### Server Requirements (Preferred)

* **PHP 7.3** you can run in lower (5.6) but the recommended version for production to use is [PHP 7.3](http://php.net/manual/en/migration70.php) for your projects.  PHP 7.3 is now supported in the latest code and anything below PHP 7.3 is no longer officially supported.
* **Apache 2.4+** with rewrite mod enabled
* **MySQL 5.5+ or MariaDb**

### Installing 

****NOTE: now using [Yarn](https://yarnpkg.com/en/) for packages (so Bower is not needed / optional).

1. GIT clone this repository

Example: git clone https://github.com/ci-blox/Ignition-Go.git myigoapp

2. Either:<br>
2a) use Yarn and Gulpjs (highly recommended for non-experts) - go to step 3<br>
-or-<br>
2b) map your webserver to the 'public' folder to use pre-installed versions of packages<br>
(skip to step 8)<br>

3. Install NPM [node.js](http://nodejs.org/): package manager for node modules, and [install Yarn] (https://yarnpkg.com/lang/en/docs/install/) 

4. Change directory to new site/web app root<br>
Example: ```cd myigoapp```

5. Install all the packages and components <br>
Type: ```yarn install``` <br>

6. Create an empty mySql or MariaDb database (default db name is ci_blox) and a user (default is root/no password).  Note that the database.php file in application/config contains these configuration settings.<br>

Example: use a tool like HeidiSQL or phpMyAdmin and create both a database and a user with privileges that new database<br> 

7. Run 'gulp' (note that gulp will run continuously in 'watch' mode, watching for css and js changes).<br> then<br>
EITHER type: ```gulp```<br>
OR..  type: ```gulp serve``` 
OR..  type: ```gulp build``` which just rebuilds the JS and CSS

8. (Optional, required if no gulp or in production) In Apache, map the 'public' folder to localhost or other url

Example: in your httpd-vhosts.conf file, add new ```<VirtualHost>``` section and restart Apache

9. Go to http://[your-web-root-from-step-7]/install/init in your browser to finish using install wizard<br> 

eg if you used gulp, goto http://localhost:8080/install/init<br>
if you had created virtual host igotestlocal.com, then go to http://igotestlocal.com/install/init in your browser


### Features

Ignition Go is a jumpstart for your rapid development:
* Multi-faceted (e.g. Frontend Website, Authorized User Only modules, Admin Panel, and API) website in a single application
* Modular design using CodeIgniter HMVC extension
* Custom config files (sites.php, locale.php) for easy configuration of website behavior
* Frontend with multiple themes (with over 16 free Bootswatch themes)
* Admin Panel with AdminLTE v3 theme
* Includes usage of many other 3rd party optional libraries via Composer, NPM or Yarn
* API Site to handle RESTful endpoints
* User authentication (optional) for secure area in Frontend Website (Sign Up, Login, Forgot Password, et al)
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
        logs/                   --- A module for viewing the daily logs
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
igocore/                         --- Ignition Go core files
igocore/system/                         --- CodeIgniter core files (clean CI3 installation with modifications only to reference IGO core)
```

### Asset Customization (e.g. additional js/css files)

A gulp configuration (**gulpfile.js**) is included. It utilizes package and component tools from these sites:
* NPM [node.js](http://nodejs.org/): package manager for node modules
* [Yarn](https://yarnpkg.com/): package manager
* GulpJS [gulp](http://gulpjs.com/): task runner to compile, combine, and minify
* Guzzle [guzzle](http://guzzlephp.com/): integrated for use as a REST client or for complex curl operations

### Help wanted please: contact us to help enhance this amazing web app builder!  
Please contact us to contribute.

### Acknowledgements
Special thanks to the [Bonfire](http://cibonfire.com) project and those who contributed to it - many features and infrastructure concepts were inspired or incorporated outright from that project.  Also thanks to all the projects like GuzzlePHP and countless others that are open source, whose components are incorporated and allow this initiative to exist.  Finally, thanks especially to the CodeIgniter team, with whom CodeIgniter continues to thrive!
