CRM System for non-profit organizations
=======================================

System allows you to manage partners and relationships with them.

###### Features:
- Partners management
  - Built-in available partner types: People, Organization, NPO, Church
  - Partner photos management (with gallery widget to view)
  - Tag system allows you to conveniently search for partners. Public and personal tags are available.
  - Child partners: Organization -> People
- Partner communications management
  - Communication photos
- Partner donates management
- Tasks system (many-to-many relation with partners)
- Users management
  - RBAC access control system
  - Built-in roles: Root, Accountant, Missionary, User
- Contries and states management
- File storage (common and personal)
- Export to CSV
  - Partners
  - Communications
  - Donates
  - Tasks
- Multi Language support (currently English and Russian languages are available)
- PDF documents for partners generator

###### Technologies
- Written in PHP (>=5.4). Based on Yii 2 Framework.
- MySQL database (via ORM)
- Bootstrap 3


REQUIREMENTS
------------

- Docker
- Docker compose

INSTALLATION
------------

Clone repo:

```bash
git clone git@github.com:vsguts/finance.git
```

Prepare configs
~~~
cp docker-compose-local.yml docker-compose.yml
cp .env.dist .env
~~~

Edit configs.

Run docker containers:
~~~
docker-compose up -d
~~~

Install composer plugin using the following command:

~~~
docker-compose exec php composer require "fxp/composer-asset-plugin:^1.3.1"
~~~

Install composer dependencies

~~~
docker-compose exec php composer install
~~~

Check requirements (if necessary):

~~~
docker-compose exec php php requirements.php
~~~

Restore DB dump (if necessary):

~~~
docker-compose exec php ./app migrate/up --migrationPath=migrations/dump --interactive=0
~~~

Apply DB migrations (if necessary):

~~~
docker-compose exec php ./app migrate/up --interactive=0
~~~

Apply user roles:

~~~
docker-compose exec php ./app rbac/init
~~~

RUNNING
-------

You can then access the application through the following URL:

~~~
http://localhost:8080/
~~~

To login use folowing:
~~~
login: root@example.com
password: root
~~~

USAGE
-----

| Service       | Default host/port     | Additional info            |
| :---          | :---                  | :---                       |
| Application   | http://127.0.0.1:8080 | `root@example.com`/`root`  |
| MySQL         | `127.0.0.1:3307`      | `gvs`/`gvs`; `root`/`root` |
| Redis         | `127.0.0.1:6380`      |                            |
| phpMyAdmin    | http://127.0.0.1:8010 | `gvs`/`gvs`; `root`/`root` |

