# Deployment Checklist

## 1. Server Requirements

PHP version 8.1.10 or higher is required, with the following extensions installed:
- CodeIgniter 4 requires the following PHP extensions:
  - intl
  - mbstring
  - json
- App-specific requirements:
  - curl
  - gd
- Database dependent extensions

Supported databases (CodeIgniter 4.5.1):
- MySQL (5.1+)
- PostgreSQL (7.4+)
- SQLite3
- Microsoft SQL Server (2012+)
- Oracle Database (12.1+)

## 2. Optimizations

Spark Optimizations:
```bash
php spark optimize
```

## 3. Shared Hosting Deployment

Document Root:
- Set the document root to the `public` folder.
- The `public` folder contains the `index.php` file.
- The `public` folder is the only folder that should be exposed to the web.
- The `app` folder should be outside the document root.


## 4. Environment Configuration

### `app.baseURL`

Depends on application URL. Example:

```php
app.baseURL = 'http://example.com/'
```

### Database Configuration:

Set accordingly to the database credentials. Example:

```php
database.default.hostname = 'localhost'
database.default.database = 'mydatabase'
database.default.username = 'myusername'
database.default.password = 'mypassword'
database.default.DBDriver = 'MySQLi'
database.default.encrypt  = {"ssl_verify":true,"ssl_ca":"path/to/ca.pem"} // Accept JSON format for SSL connection
```

### SILABOR Configuration:

Set accordingly to the SILABOR API URL. Example:

```php
silabor.silaborAPIURL.getAllBebasLabURL = 'http://url.to/api/example'
```

## 4. Database Migration

Run the following command to migrate the database:

```bash
php spark migrate --all
```

This includes the following namespaces:
- App
- CodeIgniter\Shield
- CodeIgniter\Settings







<br>
<br>
<br>
<br>
<br>
<br>
> from codeigniter4/appstarter (January 4th, 2024)

# CodeIgniter 4 Application Starter (By CodeIgniter4)

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

The user guide corresponding to the latest version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> **Warning**
> The end of life date for PHP 7.4 was November 28, 2022. If you are
> still using PHP 7.4, you should upgrade immediately. The end of life date
> for PHP 8.0 will be November 26, 2023.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
