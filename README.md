# Laravel File Manager
Description of the package.

# Installation

Add this to your project's `composer.json` file

```json
{
    "config":{
        "secure-http":false
    },
    "repositories": [
        {
            "type": "composer",
            "url": "http://packages.internal.bondacom.com"
        }
    ]
}
```

Then execute `composer require bondacom/laravel-file-manager=~1.0` command.

Register the service provider in `config/app.php`

```
    'providers' => [
        /*
         * Application Service Providers...
         */
        Bondacom\LaravelFileManager\Providers\ResponsesServiceProvider::class,
    ]
```

# Usage
