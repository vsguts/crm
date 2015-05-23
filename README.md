CRM System for non-profit organizations
=======================================

System allows you to manage partners and relationships with them.

Based on Yii 2 Basic Application Template.


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      behaviors/          contains behaviors definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      widgets/            contains widgets for view files for the Web application



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

Clone repo:

```bash
git clone git@bitbucket.org:wycliffe/crm.git
```

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Install composer plugin using the following command:

~~~
php composer.phar global require "fxp/composer-asset-plugin:1.0.0"
~~~

Install composer dependencies

~~~
php composer update
~~~

You can then access the application through the following URL:

~~~
http://localhost/crm/web/
~~~


CONFIGURATION
-------------

### Check requirements

Console:
```bash
php requirements.php
```

Web:
~~~
http://localhost/crm/requirements.php
~~~

### Database

Copy the file `config/db.php.example` into the `config/db.php` and edit them with real data. For example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=crm',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Use following to create database

```sql
CREATE DATABASE crm CHARACTER SET utf8;
```

Use following to apply mogrations:

```bash
./yii migrate
```

Copy the file `config/params.php.example` into the `config/params.php` and edit them with real data. For example:

```php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'admin@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'brandName' => 'CRM',
    'applicationName' => 'My CRM',
    'companyName' => 'My Company',
];
```