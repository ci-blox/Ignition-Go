## Deployment

(todo)

Some Tips:

1. In Apache, map the 'public' folder to localhost or other url

Example: in your httpd-vhosts.conf file, add new ```<VirtualHost>``` section and restart Apache


2. Open the /application/config/database.php file. Set the array items to correspond to values of the environment.


3. For the best security, both the igocore and application folders should be placed above web root so that they are not directly accessible via a browser. By default, .htaccess files are included in each folder to help prevent direct access, but it is best to remove them from public access entirely in case the web server configuration changes or doesn’t abide by the .htaccess.


4. One additional measure to take in production environments is to disable PHP error reporting and any other development-only functionality. This can be done by setting the ENVIRONMENT constant, which is more fully described on the CodeIgniter docs in their security page.

