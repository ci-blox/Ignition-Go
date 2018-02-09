## Quick Start

1. GIT clone this repository

Example: git clone https://github.com/ci-blox/Ignition-Go.git myigoapp

2. Either:<br>
a) map your webserver to the 'public' folder to use pre-installed versions of packages<br>
(skip to step 7)<br>
-or-<br>
b) use Yarn and Gulpjs (recommended)

3. Install NPM [node.js](http://nodejs.org/): package manager for node modules, and [install Yarn] (https://yarnpkg.com/lang/en/docs/install/) 

4. Change directory to new site/web app root<br>
Example: ```cd myigoapp```

5. Install all the packages and components <br>
Type: ```yarn install``` <br>

6. Run 'gulp' (note that gulp will run continuously in 'watch' mode, watching for css and js changes).<br> then<br>
EITHER type: ```gulp```<br>
OR..  type: ```gulp serve```

7. (Optional, required if no gulp or in production) In Apache, map the 'public' folder to localhost or other url

Example: in your httpd-vhosts.conf file, add new ```<VirtualHost>``` section and restart Apache

8. Create an empty mysql database and a user

Example: use HeidiSQL and create both a database and a user with privileges to new database 

9. Go to http://[your-web-root-from-step-7]/install/init in your browser to finish using install wizard 

eg if you had created virtual host igotestlocal.com, then go to http://igotestlocal.com/install/init in your browser
