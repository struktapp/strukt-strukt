Strukt Project
==============

[![Latest Stable Version](https://poser.pugx.org/strukt/strukt/v/stable)](https://packagist.org/packages/strukt/strukt)
[![Total Downloads](https://poser.pugx.org/strukt/strukt/downloads)](https://packagist.org/packages/strukt/strukt)
[![Latest Unstable Version](https://poser.pugx.org/strukt/strukt/v/unstable)](https://packagist.org/packages/strukt/strukt)
[![License](https://poser.pugx.org/strukt/strukt/license)](https://packagist.org/packages/strukt/strukt)

### Getting started

```sh
composer create-project "strukt/strukt:dev-master" --prefer-dist
```

Listing console commands:

```sh
./console -l
```

### Generate an application

```sh
./console generate:app payroll
```

The file structure generated should look as below:

```
app/
└── src
    └── Payroll
        └──  AuthModule
             ├── Controller
             │   └── User.php
             ├── Form
             │   └── User.php
             ├── Model
             │   └── User.php
             ├── Router
             │   ├── Auth.php
             │   └── Index.php
             └── PayrollAuthModule.php
```

There is a default module i.e `AuthModule` when you generate an application. Folders generate in a module can be changed in `cfg/module.ini` this also indicates part of alias used to access classes/objects. You'll also find a config file `cfg/app.ini` that holds the active applications name.

### Generate a module

Command syntax for generating a module:

```sh
./console generate:module <app_name> <module_name> <module_alias>
```

Example command:

```sh
./console generate:module payroll human_resource hr
```

Now the file structure should look as below:

```
app/
└── src
    └── Payroll
        ├── AuthModule
        └── HumanResourceModule
```

When an application or module is created they are loaded by running the command below, otherwise strukt won't see them:

```sh
./console generate:loader
```

The above command will create a `App/Loader.php` in the `lib/` folder at the root of your project. This file should NEVER be edited because everything will be overwritten once the above command is run. 

### Things to note

The simplest way to run the project is via the php in-built server:

```sh
php -S localhost:8080 index.php
```

**IMPORTANT**: You may encounter problems with shortening urls: i.e for example using `http://localhost/strukt/test` in Apache with `.htaccess` strukt will interpret the url as `/strukt/test` but in the php in-built server as `/test`. You may use the flags below to enable and disable shortening to easily overcome this issue:

```php
$r = \Strukt\Framework\Registry::getInstance();
$r->set("shorten_url", false);
// $r->set("shorten_url", true); 
```

**IMPORTANT**: The folder `tpl/` in the root of the project contains `sgf/` folder that has class template files used to generate the application its modules and migrations. Ensure to not change it until you've understood [strukt-generator](https://github.com/pitsolu/strukt-generator)

Have a good one!