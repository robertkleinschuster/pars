## PARS: PSR-15 Application Core

PARS is a PHP Application Core without dependencies. It features PSR-15 based approach with nested applications (modules).
It also features a component based view system with TypeScript and SCSS support by webpack.

### Applications

By extending the WebApplication class it is possible to setup multiple nested applications under different base paths.

### Development Mode

Enable using: `./bin/console development enable`

### Config

Config files are dynamically loaded from the `config/` directory.
Suffix your development configs with `*.development.php`.

Example: config/database.php

```php
return [
  "user" => "pars",
  "pw" => "pars",
  "host" => "localhost",  
  "port" => "3306",
];
```

Example: config/database.development.php

```php
return [
  "user" => "dev",
  "pw" => "dev",
  "host" => "localhost",  
  "port" => "3306",
];
```


### View

### Composed RequestHandler

