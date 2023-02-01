Strukt
===

[![Latest Stable Version](https://poser.pugx.org/strukt/strukt/v/stable)](https://packagist.org/packages/strukt/strukt)
[![Total Downloads](https://poser.pugx.org/strukt/strukt/downloads)](https://packagist.org/packages/strukt/strukt)
[![Latest Unstable Version](https://poser.pugx.org/strukt/strukt/v/unstable)](https://packagist.org/packages/strukt/strukt)
[![License](https://poser.pugx.org/strukt/strukt/license)](https://packagist.org/packages/strukt/strukt)

### Getting started

```sh
composer create-project "strukt/strukt:1.1.5-alpha" --prefer-dist
```

Listing console commands:

```sh
./console -l
```

### Generate an application

```sh
./console make:app payroll
```

The file structure generated should look as below:

```
app
└── src
    └── Payroll
        ├── AuthModule
        │   ├── Controller
        │   │   └── User.php
        │   ├── Form
        │   │   └── User.php
        │   ├── PayrollAuthModule.php
        │   ├── Router
        │   │   ├── Auth.php
        │   │   └── Index.php
        │   └── Tests
        │       └── UserTest.php
        └── User.php

```

There is a default module i.e `AuthModule` when you generate an application. Folders generate in a module can be changed in `cfg/module.ini` this also indicates part of alias used to access classes/objects. You'll also find a config file `cfg/app.ini` that holds the active applications name.

When an application or module is created/generated they are loaded by running the command below, otherwise strukt won't detect them:

```sh
./console make:loader
```

The above command will create a `App/Loader.php` in the `lib/` folder at the root of your project. This file should NEVER be edited because everything will be overwritten once the above command is run. 

### Generate a module

Command syntax for generating a module:

```sh
./console make:module <app_name> <module_name> <module_alias>
```

Example command:

```sh
./console make:module payroll human_resource hr
```

Now the file structure should look as below:

```
app/
└── src
    └── Payroll
        ├── AuthModule
        └── HumanResourceModule
```

Remember to run the `make:loader` command to load the module.

### Drop into shell

`strukt-strukt` uses [psysh](https://github.com/bobthecow/psysh).

```sh
$ ./console shell:exec
>>> ls
Variables: $core, $registry
>>> $core->get("au.ctr.User")->getAll()
=> "AuthModule\Controller\User::getAll Not Yet Implemented!"
>>> $core->get("User")
=> Payroll\User {#...
```

### Things to note

The `make:router` and `make:module` commands will not appear on cli console until you run `make:app` and `make:loader` commands firstly and respectively.

**IMPORTANT**: The folder `tpl/` in the root of the project contains `sgf/` folder that has class template files used to generate the application its modules and migrations. Ensure to not change it until you've understood 
[strukt-generator](https://github.com/pitsolu/strukt-generator)

Have a good one!
