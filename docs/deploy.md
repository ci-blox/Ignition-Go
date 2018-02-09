## Deployment

(todo)

Some Tips:

1. In Apache, map the 'public' folder to localhost or other url

Example: in your httpd-vhosts.conf file, add new ```<VirtualHost>``` section and restart Apache


2. Open the /application/config/database.php file. Set the array items to correspond to values of the environment.