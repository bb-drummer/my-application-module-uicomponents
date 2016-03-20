# ZF2 CRUD module template


## Introduction

This is a simple standard CRUD module template based upon ZF2's `zend-tool` created basic module structure. Just checkou from our GitLab and modify and/or extend it to your need

More information and examples are available on the [Wiki](https://gitlab.bjoernbartels.earth/zf2/module-crud-template/wikis/home)



## Requirements

* [php](http://php.net) (>= v5.4.40)
* [Zend Framework 2](https://github.com/zendframework/zf2) (>= v2.4.0)
* [ZF2BaseApp](https://gitlab.bjoernbartels.earth/zf2/application-base) (latest master).
* [ZFC-User](https://github.com/ZF-Commons/ZfcUser) (optional).



## Features / Goals

* standard CRUD module template



## Get started

1. checkout from our GitLab (https://gitlab.bjoernbartels.earth/zf2/module-crud-template) ...

2. you maybe want to do a search/replace over all files replacing 'Yourmodname' and 'yourmodname' with actually your own module/table name (case-sensitive), rename files and folders accordingly...

3. modify and adjust the of the files, including your table and column settings, routes, views, controller and form stuf and so on... or in other words: "CODE YOUR STUFF !!!" :D



## Add your CRUD module to your ZF2 application

1. create an own repository 'your-namespace/yourmodname.git' and push your CRUD module

2. add that module repository in your composer.json:

    ``...
    "repositories": [
        {
            "type" : "git"
            "url" : "http://git.yourdomain.tld/your-namespace/yourmodname.git"
        }
    ]
    ...
    "require": {
        "your-namespace/yourmodname": "dev-master"
    }    
    ...``

3. now tell composer to download/update the module by running the command:

    ``
    $ php composer.phar update
    ``



## Post installation

1. if applicable, import the SQL schema located somewhere your module's source files, like `./vendor/your-namespace/yourmodname/data/schema.sql` (if you installed using the Composer)

2. enabling it in your `application.config.php` file.

    ``
    <?php
    return array(
        'modules' => array(
            // ...
            'Yourmodname',
        ),
        // ...
    );
    ``

3. enabling it in your `navigation.global.php` file.



## LICENCE



## COPYRIGHT

&copy; 2015 [dragon-projects.net], info@dragon-projects.net, all rights reserved.