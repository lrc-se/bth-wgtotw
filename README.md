[BTH] WGTOTW (Allt om sci-fi)
=============================

This is the repo for the [examination project](https://dbwebb.se/kurser/ramverk1/kmom10) in the course *ramverk1* in BTH's web development programme.


Installation
------------

Perform the following steps to run the website on your own system:

1. Clone the repo
2. Run `composer install` to install all dependencies
3. Edit `config/db-example.php` with your connection details and rename the file to `config/db.php`
4. Run `sql/setup.sql` on the database server you configured in step #3 to create the database (remove the insert operations first if you don't want any sample data)
5. Edit the paths in `htdocs/.htaccess` to match your setup
6. Start a PHP-enabled webserver (5.6+) and browse to `htdocs/`

That's it. Enjoy!  
[*kabc16@student.bth.se*](mailto:kabc16@student.bth.se)
