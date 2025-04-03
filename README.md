Strukt
===

[![Latest Stable Version](https://poser.pugx.org/strukt/strukt/v/stable)](https://packagist.org/packages/strukt/strukt)
[![Total Downloads](https://poser.pugx.org/strukt/strukt/downloads)](https://packagist.org/packages/strukt/strukt)
[![Latest Unstable Version](https://poser.pugx.org/strukt/strukt/v/unstable)](https://packagist.org/packages/strukt/strukt)
[![License](https://poser.pugx.org/strukt/strukt/license)](https://packagist.org/packages/strukt/strukt)

### Getting started

```sh
composer create-project strukt/strukt:1.1.8-alpha --prefer-dist
```

Listing console commands:

```sh
./xcli -l
```

### Generate Application

```sh
./xcli app:make payroll
```

The file structure generated should look as below:

```sh
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
        └── User.php # Models are stored in the root of your app (i.e payroll)

```

There is a default module i.e `AuthModule` when you generate an application. Folders generated in a module (facets) can be changed in `cfg/module.ini` this also indicates part of alias used to access classes/objects. You'll also find a config file `cfg/app.ini` that holds the active application name.

When an application or module is created/generated it is loaded by running the command below, otherwise strukt won't detect it:

```sh
./xcli app:reload
```

The above command will create a `App/Loader.php` in the `lib/` folder at the root of your project. This file should NEVER be edited because everything will be overwritten once the above command is rerun. 

### Generate Module

Command syntax for generating a module:

```sh
./xcli make:module <app_name> <module_name> <module_alias>
```

Example command:

```sh
./xcli make:module payroll human_resource hr
```

Now the file structure should look as below:

```sh
app/
└── src
    └── Payroll
        ├── AuthModule
        └── HumanResourceModule
```

Remember to run the `app:reload` command to load the module.

### Execute Shell

`strukt-strukt` uses [Psysh](https://github.com/bobthecow/psysh).

To drop into shell:

```sh
$ ./xcli shell:exec
>>> ls
Variables: $core
>>> $core->get("au.ctr.User")->getAll()
=> "AuthModule\Controller\User::getAll Not Yet Implemented!"
>>> $core->get("User")
=> Payroll\User {#...
```

## Cli

View `providers` and `middlewares`

```sh
./xcli sys:ls middlewares # view for console
```

View `index.php` middlewares

```sh
./xcli sys:ls middlewares --idx # view for index.php
```

You can also view `providers` by replacing `middlewares`

### Cli Utility

Enable and disable `commands` , `middlewares` and `providers`

Example:

```sh
./xcli sys:util enable commands pub-make
```

### Run Application

```sh
./xcli app:exec
```

Uses `.env` `server_{var}` variables to run application.

## Notes

The `make:router` and `make:module` commands will not work on cli console until you run `app:make` and `app:reload` commands are run respectively.

**IMPORTANT**: The folder `.tpl/` in the root of the project contains `sgf/` folder that contains class template files used to generate the application modules and migrations. Ensure to **NOT** change it until you've understood [strukt-generator](https://github.com/pitsolu/strukt-generator)

Have a good one!