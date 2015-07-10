symfony
=======

A wikipedia title prefix search application implemented with symfony. The project took me start to finish around 10 hours.


What do I need?
---------------

You need to meet the following requirements:

* PHP >=5.3.9
* PHP pdo sqlite extension
* composer (https://getcomposer.org/doc/00-intro.md)


How to install the dependencies?
--------------------------------

Just run the following command within the project root directory

`composer install`


How to initialize the database?
-------------------------------

To initialize the database just make sure you configured the database settings correctly 
in your `app/config/parameters.yml` config file.

After that just run the following command

`app/console doctrine:database:create`

After that follow the "How to update the database?" instructions.


How to update the database?
---------------------------

`app/console doctrine:fixtures:migrate`



How to start the dev server?
----------------------------

1. Execute the `php app/console server:run` command.
1. Browse to the `http://localhost:8000` URL.


Thinks I would improve for a real world application
---------------------------------------------------

* Asset combination and minimization (Using assetic)
* Using `less` instead of `css`
* Using mysql or something similar (no sqlite db)
* Validate the response before parsing it
* More login methods (e.g. Facebook, Twitter)
* Email validation for registration (disabled because there is most likely no email server running)
* Paginating for search results
* Paginating for favorites list
* Added unit testing
* A general refactor of all the JS code and only include Js where it is really needed