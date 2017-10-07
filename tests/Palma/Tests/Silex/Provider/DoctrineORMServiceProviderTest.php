<?php
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Francisco Javier Palma <palmasev@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author      Francisco Javier Palma <palmasev@gmail.com>
 * @copyright   2012 Francisco Javier Palma.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://fjavierpalma.es
 */
namespace Palma\Tests\Silex\Provider;

use Palma\Silex\Provider\DoctrineORMServiceProvider;
use PHPUnit_Framework_TestCase;
use Silex\Application;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class DoctrineORMServiceProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var DoctrineORMServiceProvider
     */
    private $provider;

    /**
     * Bootstrap
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = new Application();
        $this->provider = new DoctrineORMServiceProvider();
    }

    /**
     * Shutdown
     *
     * @return void
     */
    public function tearDown()
    {
        $this->app = null;
        $this->provider = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function registerMustBeCreateResources()
    {
        $this->app->register(
            $this->provider,
            [
                'doctrine_orm.entities_path'            => __DIR__,
                'doctrine_orm.proxies_path'             => __DIR__,
                'doctrine_orm.proxies_namespace'        => 'Proxy',
                'doctrine_orm.connection_parameters'    => [
                    'driver' => 'pdo_sqlite',
                    'memory' => true,
                ],
                'doctrine_orm.simple_annotation_reader' => false
            ]
        );

        $this->assertArrayHasKey('doctrine_orm.em', $this->app);
    }

    /**
     * @test
     */
    public function registerWithoutAnnotationReaderMustBeCreateResources()
    {
        $this->app->register(
            $this->provider,
            [
                'doctrine_orm.entities_path'            => __DIR__,
                'doctrine_orm.proxies_path'             => __DIR__,
                'doctrine_orm.proxies_namespace'        => 'Proxy',
                'doctrine_orm.connection_parameters'    => [
                    'driver' => 'pdo_sqlite',
                    'memory' => true,
                ]
            ]
        );

        $this->assertArrayHasKey('doctrine_orm.em', $this->app);
    }

    /**
     * @test
     */
    public function registerWithoutConnectionParametersMustBeCreateResources()
    {
        $this->app->register(
            $this->provider,
            [
                'doctrine_orm.entities_path'            => __DIR__,
                'doctrine_orm.proxies_path'             => __DIR__,
                'doctrine_orm.proxies_namespace'        => 'Proxy',
            ]
        );

        $this->assertArrayHasKey('doctrine_orm.em', $this->app);
    }

    /**
     * @test
     */
    public function registerWithoutProxiesParametersMustBeCreateResources()
    {
        $this->app->register(
            $this->provider,
            [
                'doctrine_orm.entities_path'            => __DIR__,
                'doctrine_orm.connection_parameters'    => [
                    'driver' => 'pdo_sqlite',
                    'memory' => true,
                ]
            ]
        );

        $this->assertArrayHasKey('doctrine_orm.em', $this->app);
    }

    /**
     * @test
     */
    public function registerWithoutAnyParametersMustBeCreateResources()
    {
        $this->app->register($this->provider);

        $this->assertArrayHasKey('doctrine_orm.em', $this->app);
    }
}
