DoctrineORM Service Provider for Silex
======================================
This library provides you a Silex DoctrineORM Service provider.

This service provider requires PHP 5.3+, Silex and DoctrineORM.

DoctrineORM is included in composer.json. Silex is not included in composer.json so you can use silex.phar.

Registering
-----------
```php

$app->register(new Palma\Silex\Provider\DoctrineORMServiceProvider(), array(
    'doctrine_orm.entities_path'     => __DIR__.'/Entities/',
    'doctrine_orm.proxies_path'      => __DIR__.'/Proxies',
    'doctrine_orm.proxies_namespace' => 'MyProject\Proxies',
    'doctrine_orm.connection_parameters' => array(
    			'driver'        => 'pdo_mysql',
                'dbname'        => 'dbname',
                'user'          => 'usename',
                'password'      => '******',
                'host'          => 'localhost',
                'charset'       => 'utf8',
    		)
));
```

Usage
-----

```php

<?php

$app->get('/blog/show/{id}', function ($id) use ($app) {
    
    $post = $['doctrine_orm.em']->find('Post', $id);
	
	return  "<h1>{$post->getTitle()}</h1>".
            "<p>{$post->getBody()}</p>";
});

```