<?php
namespace Palma\Silex\Provider\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\Common\EventManager;
use Doctrine\Common\Cache\ArrayCache;

class DoctrineORMServiceProvider implements ServiceProviderInterface {
    public function register(Application $app){
        $app['doctrine_orm.configuration'] = $app->share(function($app){
            $configuration = new Configuration();
            if($app['doctrine_orm.metadata_cache']){
	            $configuration->setMetadataCacheImpl($app['doctrine_orm.metadata_cache']);
	        } else {
	        	$configuration->setMetadataCacheImpl(new ArrayCache());
	        }
            $driverImpl = $configuration->newDefaultAnnotationDriver($app['doctrine_orm.entities_path']);
            $configuration->setMetadataDriverImpl($driverImpl);

            if($app['doctrine_orm.query_cache']){
	            $configuration->setQueryCacheImpl($app['doctrine_orm.query_cache']);
	        } else {
	        	$configuration->setQueryCacheImpl(new ArrayCache());
	        }
            $configuration->setProxyDir($app['doctrine_orm.proxies_path']);
            $configuration->setProxyNamespace($app['doctrine_orm.proxies_namespace']);
            $configuration->setAutogenerateProxyClasses(false);
            if($app['doctrine_orm.autogenerate_proxy_classes']){
                $configuration->setAutogenerateProxyClasses($app['doctrine_orm.autogenerate_proxy_classes']);
            }
            return $configuration;
        });

        $app['doctrine_orm.connection'] = $app->share(function($app){
            return DriverManager::getConnection($app['doctrine_orm.connection_parameters'], $app['doctrine_orm.configuration'], new EventManager());
        });

        $app['doctrine_orm.em'] = $app->share(function($app) {
            return EntityManager::create($app['doctrine_orm.connection'], $app['doctrine_orm.configuration'], $app['doctrine_orm.connection']->getEventManager());
        });
		
    }

    public function boot(Application $app) {
        
    }
}

?>