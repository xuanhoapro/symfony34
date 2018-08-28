symfony3.4
==========

A Symfony project created on August 27, 2018, 7:03 am.

* Configure your application in `app/config/parameters.yml` file.
* Run your application:
    1. Execute the `php bin/console server:run` command.
    2. Browse to the [http://localhost:8000](http://localhost:8000) URL.
    
* Read the documentation at [https://symfony.com/doc](https://symfony.com/doc)

#### Compiling Assets (webpack)
1. Compile assets once: `yarn encore dev`
2. Compile assets automatically when file change: `yarn encore dev --watch`
3. Create production build: `yarn encore production`