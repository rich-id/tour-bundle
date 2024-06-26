![Logo](.github/tour-bundle.svg)

Getting Started With RichIdTourBundle
=======================================

This version of the bundle requires Symfony 6.0+ and PHP 8.1+.

[![Package version](https://img.shields.io/packagist/v/rich-id/tour-bundle)](https://packagist.org/packages/rich-id/tour-bundle)
[![Actions Status](https://github.com/rich-id/tour-bundle/workflows/Tests/badge.svg)](https://github.com/t/rich-id/tour-bundle/actions)
[![Coverage Status](https://coveralls.io/repos/github/rich-id/tour-bundle/badge.svg?branch=master)](https://coveralls.io/github/rich-id/tour-bundle?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/d9e628f4e123ec999a57/maintainability)](https://codeclimate.com/github/rich-id/tour-bundle/maintainability)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/rich-id/tour-bundle/issues)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)

The tour-bundle exposes a set of Javascript functions to easily track if a user saw a tour or not. 

# Quick start

Declare the tours in Symfony's configuration:

```yaml
rich_id_tour:
    user_class: App\Entity\User
    tours:
        tour-1:
            name: 'My tour'
            storage: cookie
            duration: '+9 months'
        additionnal-tour:
            storage: local_storage
        another-one:
            storage: database
```

Now that you declared the tours, you can now use the Javascript functions to whether execute a tour or not:

```javascript
if (isTourAvailable('tour-1')) {
    // Make the tour
   markTourAsPerformed('tour-1');
}
```


# Table of content

1. [Installation](#1-installation)
2. [Getting started](#2-getting-started)
   - [Configuration](Docs/Configuration.md)
   - [Helpers](Docs/Helpers.md)
   - [Administration](Docs/Administration.md)
3. [Versioning](#3-versioning)
4. [Contributing](#4-contributing)
5. [Hacking](#5-hacking)
6. [License](#6-license)


# 1. Installation

This version of the bundle requires Symfony 6.0+ and PHP 8.1+.

### 1.1 Composer

```bash
composer require rich-id/tour-bundle
```

### 1.2 Bundles declaration

After the installation, make sure that the bundle are declared correctly within the Kernel's bundles list. This is done automatically if you use Symfony Flex.

```php
return [
    // ...
   RichId\TourBundle\RichIdTourBundle::class => ['all' => true],
];
```

## 1.3 Mandatory configuration

Add in `config/routes` the definition of the bundle routes:


```yaml
rich_id_tour:
    resource: "@RichIdTourBundle/Resources/config/routing/routing.xml"
```

You will also need to configure the user class. Add the following configuration in the `rich_id_tour.yaml` file:

```yaml
rich_id_tour:
    user_class: App\Entity\DummyUser  # Your User class
```

## 1.4 Doctrine mapping

The bundle provides entities. You must therefore modify the structure of your database by generating a migration.


# 2. Getting started

- [Configuration](Docs/Configuration.md)
- [Helpers](Docs/Helpers.md)
- [Administration](Docs/Administration.md)

# 3. Versioning

tour-bundle follows [semantic versioning](https://semver.org/). In short the scheme is MAJOR.MINOR.PATCH where
1. MAJOR is bumped when there is a breaking change,
2. MINOR is bumped when a new feature is added in a backward-compatible way,
3. PATCH is bumped when a bug is fixed in a backward-compatible way.

Versions bellow 1.0.0 are considered experimental and breaking changes may occur at any time.


# 4. Contributing

Contributions are welcomed! There are many ways to contribute, and we appreciate all of them. Here are some of the major ones:

* [Bug Reports](https://github.com/rich-id/tour-bundle/issues): While we strive for quality software, bugs can happen, and we can't fix issues we're not aware of. So please report even if you're not sure about it or just want to ask a question. If anything the issue might indicate that the documentation can still be improved!
* [Feature Request](https://github.com/rich-id/tour-bundle/issues): You have a use case not covered by the current api? Want to suggest a change or add something? We'd be glad to read about it and start a discussion to try to find the best possible solution.
* [Pull Request](https://github.com/rich-id/tour-bundle/merge_requests): Want to contribute code or documentation? We'd love that! If you need help to get started, GitHub as [documentation](https://help.github.com/articles/about-pull-requests/) on pull requests. We use the ["fork and pull model"](https://help.github.com/articles/about-collaborative-development-models/) were contributors push changes to their personal fork and then create pull requests to the main repository. Please make your pull requests against the `master` branch.

As a reminder, all contributors are expected to follow our [Code of Conduct](CODE_OF_CONDUCT.md).


# 5. Hacking

You might use Docker and `docker-compose` to hack the project. Check out the following commands.

```bash
# Start the project
docker-compose up -d

# Install dependencies
docker-compose exec application composer install

# Run tests
docker-compose exec application bin/phpunit

# Run a bash within the container
docker-compose exec application bash
```


# 6. License

tour-bundle is distributed under the terms of the MIT license.

See [LICENSE](LICENSE.md) for details.
