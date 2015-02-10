MatchTracker
============

What is MatchTracker?
---------------------
MatchTracker is an online competition creator and match tracker tool created by 3 ICT students during the course Projecten2 at [KAHO Sint-Lieven](http://www.kaho.be). Follow our [development blog](http://www.matchtracker.be/blog) for the latest news and development articles.

[ ![Image](http://i.imgur.com/7BzHUf4m.png "Frontend") ](http://i.imgur.com/7BzHUf4.png) 
[ ![Image](http://i.imgur.com/piR54w1m.png "Frontend") ](http://i.imgur.com/piR54w1.png) 
[ ![Image](http://i.imgur.com/o48SldQm.jpg "iPhone") ](http://i.imgur.com/o48SldQ.jpg) 

[WATCH THE PREVIEW VIDEO](https://vimeo.com/58601582)

Installation
-----------
Since we use the [Symfony Framework](http://symfony.com), you need at least PHP version 5.3.

 * Clone this GIT repository to your webserver
 * Go to your the config wizard, e.g. `matchtracker.localhost/web/config.php` to generate a new `/app/config/parameters.yml` with your database settings.
 * If composer (`composer.phar`) isn't already installed, run `curl -s http://getcomposer.org/installer | php`to install it. 
 * Install the vendors: `php composer.phar install`
 * Import the `dev/db.sql` database dump to your database.
 * Run MatchTracker: `matchtracker.localhost/web/app_dev.php`
