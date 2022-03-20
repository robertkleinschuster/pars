# Package: App

This package should contain your applications.

Applications are parts of your project that are reachable under their respective base paths like "/admin".
These applications must not depend on each other.
They usually define a layout with header, navigation and footer.
The content is loaded into the `<main>` section of the application layout.
So it should only handle the common parts of the page.

Examples would be Admin, Dashboard, Api, Site etc...

Applications extend an application base class and are registered using configuration.

**Base classes**

For web applications that render a HTML website, you can use `Core\Application\Web\WebApplication` as your base class.
If you want to build an API you use `Core\Application\Api\ApiApplication` as your base class.

**Config**

Registering your application is as easy as referencing it in your `config/apps.php` file.

Example:
```php
<?php
// config/apps.php

use Pars\App\Admin\AdminApplication;
use Pars\App\Frontend\FrontendApplication;

return [
    '/admin' => AdminApplication::class,
    '/' => FrontendApplication::class,
]; 
```

**Middleware and Handlers**
To register middleware or handlers for your app you need to overload the `init()` method in your application class.

Example:
```php
   protected function init()
    {
        parent::init();
        $this->pipe($this->getContainer()->get(AuthenticationMiddleware::class));
        $this->route('/user/:id', $this->getContainer()->get(UserHandler::class));
    }
```

**Layout**

To modify the layout, e.g. add navigation, you use the layout object `$this->getLayout()`.
You can implement this in the `init` or in the `handle` method of the application class.
