[BTH] WGTOTW (Allt om sci-fi)
=============================

[![Travis CI Build Status](https://travis-ci.org/lrc-se/bth-wgtotw.svg?branch=master)](https://travis-ci.org/lrc-se/bth-wgtotw)
[![Scrutinizer Build Status](https://scrutinizer-ci.com/g/lrc-se/bth-wgtotw/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lrc-se/bth-wgtotw/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lrc-se/bth-wgtotw/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lrc-se/bth-wgtotw/?branch=master)

This is my repo for the [examination project](https://dbwebb.se/kurser/ramverk1/kmom10) in the course *ramverk1* in BTH's web development programme.


Installation
------------

Perform the following steps to run the website on your own system:

1. Clone the repo
2. Run `composer install` to install all dependencies
3. Edit `config/db-example.php` with your connection details and rename the file to `config/db.php` (make sure to keep the table prefix empty)
4. Run `sql/setup.sql` on the database server you configured in step #3 to create the database (remove the insert operations first if you don't want any sample data)
5. Edit the paths in `htdocs/.htaccess` to match your setup
6. Start a PHP-enabled webserver (5.6+) and browse to `htdocs/`

__That's it. Enjoy!__  
/[*Kalle*](mailto:kabc16@student.bth.se)
