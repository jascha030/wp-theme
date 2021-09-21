# jascha030/wp-theme

Description: A simple project description similar to the one found in your `composer.json`.

## Getting started

## Prerequisites

* Php `^7.4 || ^8.0`
* Composer `^2`

### Installation

```shell
composer require jascha030/wp-theme
```

#### Distribution

Alternative steps for distribution.

```shell
composer require --no-dev jascha030/wp-theme
```

## Usage

Extensive instructions in how to use your package in general or for use in the development of other projects.

### Testing

Included with the package are a set of Unit tests using `phpunit/phpunit`. For ease of use a composer script command is
defined to run the tests.

```shell
composer run phpunit
```

A code coverage report is generated in the project's root as `cov.xml`. The `cov.xml` file is not ignored in the
`.gitignore` by default. You are encouraged to commit the latest code coverage report, when deploying new features.

### Code style & Formatting

A code style configuration for `friendsofphp/php-cs-fixer` is included, defined in `.php-cs-fixer.dist.php`.

To use php-cs-fixer without having it necessarily installed globally, a composer script command is also included to
format php code using the provided config file and the vendor binary of php-cs-fixer.

```shell
composer run format
```
