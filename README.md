[![Build Status](https://travis-ci.org/bondacom/laravel-file-manager.svg?branch=master)](https://travis-ci.org/bondacom/laravel-file-manager)
[![Latest Stable Version](https://poser.pugx.org/bondacom/laravel-file-manager/v/stable)](https://packagist.org/packages/bondacom/laravel-file-manager)
[![Total Downloads](https://poser.pugx.org/bondacom/laravel-file-manager/downloads)](https://packagist.org/packages/bondacom/laravel-file-manager)
[![License](https://poser.pugx.org/bondacom/laravel-file-manager/license)](https://packagist.org/packages/bondacom/laravel-file-manager)

# Laravel File Manager

###### [FAQ](#faq) | [Contributing](https://github.com/bondacom/laravel-file-manager/blob/master/CONTRIBUTING.md)

> Laravel File Manager is a [Bondacom](https://bondacom.com) library which provides an efficient way to read or create enormous files.

## Getting Started

### Installation

> *Note: It requires at least PHP v7.1.*

To use package in your Laravel project, run:
```
composer require bondacom/laravel-file-manager
```

> **Note**: For Laravel less than 5.5 remember to register manually the service provider!

### Configuration
Copy the config file into your project. For Laravel projects run:
```
php artisan vendor:publish --provider="Bondacom\LaravelFileManager\Providers\LaravelFileManagerServiceProvider"
```

### Usage

It's really simple!

**Example** - Read a file using default config:

```
Reader::open($file)->process(function($line) {
    // Do what you need here
});
```

**Example** - Read a file overriding default config chunk value:

```
Reader::open($file)->process(function($lines) {
    // Do what you need here
}, 1000);
```

**Example** - Read a file as csv:

```
Reader::csv()->open($file)->process(function($line) {
    // Do what you need here
});
```

**Example** - Write a file

```
$writer = Writer::new($file)
$writer->add('Hello');
$writer->add('World');
$writer->save();
```

**Example** - Write a file as csv

```
$writer = Writer::csv()->new($file)
$writer->add(['Hello', 'World']);
$writer->save();
```

## Contributing

Check out [contributing guide](https://github.com/bondacom/laravel-file-manager/blob/master/CONTRIBUTING.md) to get an overview of development.

## FAQ

#### Q: Which PHP and Laravel version does use?

Look for [composer.json](https://github.com/bondacom/laravel-file-manager/blob/master/composer.json).

## License

Laravel File Manager is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)