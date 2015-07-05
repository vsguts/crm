CRM System for non-profit organizations
=======================================

System allows you to manage partners and relationships with them.

###### Features:
- Partners management
  - Built-in available partner types: People, Organization, NPO, Church
  - Partner photos management (with gallery widget to view)
  - Tag system allows you to conveniently search for partners
  - Child partners: Organization -> People
- Partner visits management
  - Visit photos
- Partner donates management
- Tasks system (many-to-many relation with partners)
- Users management
  - RBAC access control system
  - Built-in roles: Root, Accountant, Missionary, User
- Contries and states management
- File storage (common and personal)
- Export to CSV
  - Partners
  - Visits
  - Donates
  - Tasks
- Multi Language support (currently English and Russian languages are available)

###### Technologies
- Written in PHP (>5.4). Based on Yii 2 Framework.
- MySQL database (via ORM)
- Bootstrap 3


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

The minimum requirement by this application that your Web server supports PHP 5.4.0.


INSTALLATION
------------

Clone repo:

```bash
git clone git@github.com:vsguts/crm.git
```

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Install composer plugin using the following command:

~~~
php composer.phar global require "fxp/composer-asset-plugin:1.0.0"
~~~

Install composer dependencies

~~~
php composer.phar update
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

**NOTE:** CRM won't create the database for you, this has to be done manually before you can access it.

Use following to create database

```sql
CREATE DATABASE crm CHARACTER SET utf8;
```

Use following to apply migrations:

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

TODO
------------

- Mailing lists
- Partners on map
