<?php
?>
<html>
<head>
<title>Ignition Go</title>
</head>
<body>
<h1>Ignition Go</h1>
<div class="alert alert-danger">
      <h3>Oops!</h3>
      Your Web Root should be set to the <strong>public</strong> folder,but it's <strong>not</strong>. It's pointing to the <strong>Root</strong> folder.<br><br>
      Here is an example entry to set up in Apache if your folder is myigosite:
<pre>&lt;VirtualHost *:80&gt;
    DocumentRoot "[...]/htdocs/myigosite/public"
    ServerName myigosite
    ServerAlias myigosite.local
&lt;/VirtualHost&gt;</pre>
            </div><p>
			<h4>Here are the install instructions, in case you missed them or still need them:</h4>
<ol>
<li><p>Install NPM <a href="http://nodejs.org/">node.js</a>: package manager for node modules</p></li>
<li><p>GIT clone this repository<br>
Example: <code>git clone https://github.com/ci-blox/Ignition-Go.git myigosite</code></p></li>
<li><p>Change directory to new site/web app root<br>
Example: <code>cd myigosite</code></p></li>
<li><p>Install Bower <a href="http://bower.io/">bower</a>: manager for bower components<br>
Type: <code>npm install -g bower</code></p></li>
<li><p>Install all the NPM and bower components<br>
Type: <code>npm install</code> then<br>
Type: <code>bower install</code></p></li>
<li><p>Install and run 'gulp' (note that gulp will run continuously in 'watch' mode, watching for css and js changes).<br>
Type: <code>npm install gulp</code> then<br>
EITHER type: <code>gulp</code>
OR..  type: <code>gulp serve</code></p></li>
<li><p>(Optional) In Apache, map the public folder to localhost or other url
Example: in your httpd-vhosts.conf file, add new  section and restart Apache</p></li>
<li><p>Create an empty mysql db
Example: use HeidiSQL and create both a database and a user with privileges to new database </p></li>
<li><p>Go to http://[your web root from step 5]/install/init in your browser to finish using install wizard 
eg if you had created virtual host myigosite.local, then go to <a href="http://myigosite.local/install/init">http://myigosite.local/install/init</a> in your browser</p></li>
</ol>
</body>
</html>