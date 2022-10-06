<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup as Setup;
use Illuminate\Support\Facades\Config;

class DoctrineOrmServiceProvider extends ServiceProvider
{
    public function boot() {
        $configPath = __DIR__ . '/../config/doctrine.php';
        $this->publishes([$configPath => config_path('doctrine.php')]);
    }

    public function register()
    {
        $this->app->singleton(EntityManagerInterface::class, function ($app) {
            $config = $this->createMetadataDriverConfig();
            $conn   = $this->getDatabaseConnection();

            return EntityManager::create($conn, $config);
        });
    }

    private function createMetadataDriverConfig() {
        $isDevMode = env('APP_DEBUG');

        switch (Config::get('doctrine.mappings.type')) {
            case 'yaml':
                return Setup::createYAMLMetadataConfiguration(Config::get('doctrine.mappings.paths'), $isDevMode);
            case 'xml':
                return Setup::createXMLMetadataConfiguration(Config::get('doctrine.mappings.paths'), $isDevMode);
            case 'annotations':
                return Setup::createAnnotationMetadataConfiguration(Config::get('doctrine.mappings.paths'), $isDevMode);
            default:
                throw new \RuntimeException(Config::get('doctrine.mappings.type') . ' driver unsupported');
        }
    }

    private function getDatabaseConnection() {
        switch (Config::get('database.default')) {
            case 'mysql':
                return [
                    'driver' => 'pdo_mysql',
                    'dbname' => Config::get('database.connections.mysql.database'),
                    'user' => Config::get('database.connections.mysql.username'),
                    'password' => Config::get('database.connections.mysql.password'),
                    'host' => Config::get('database.connections.mysql.host'),
                    'charset' => Config::get('database.connections.mysql.charset'),
                    'prefix' => Config::get('database.connections.mysql.prefix'),
                ];

            case 'pgsql':
                return [
                    'driver' => 'pdo_pgsql',
                    'dbname' => Config::get('database.connections.pgsql.database'),
                    'user' => Config::get('database.connections.pgsql.username'),
                    'password' => Config::get('database.connections.pgsql.password'),
                    'host' => Config::get('database.connections.pgsql.host'),
                    'charset' => Config::get('database.connections.pgsql.charset'),
                    'prefix' => Config::get('databse.connections.pgsql.prefix'),
                ];

            case 'sqlite':
                return [
                    'driver' => 'pdo_sqlite',
                    'path' => Config::get('database.connections.sqlite.database'),
                    'user' => Config::get('database.connections.sqlite.username'),
                    'password' => Config::get('database.connections.sqlite.password'),
                    'prefix' => Config::get('database.connections.sqlite.prefix'),
                ];

            default:
                throw new \RuntimeException(Config::get('database.default') . ' database unsupported');
        }
    }
}