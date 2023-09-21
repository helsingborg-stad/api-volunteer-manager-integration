<?php

namespace APIVolunteerManagerIntegration;

use APIVolunteerManagerIntegration\Helper\DIContainer\DIContainer;
use APIVolunteerManagerIntegration\Helper\HttpClient\CurlClientFactory;
use APIVolunteerManagerIntegration\Helper\HttpClient\HttpClientFactory;
use APIVolunteerManagerIntegration\Helper\PluginManager\ActionHookSubscriber;
use APIVolunteerManagerIntegration\Helper\PluginManager\FilterHookSubscriber;
use APIVolunteerManagerIntegration\Helper\PluginManager\PluginManager;
use APIVolunteerManagerIntegration\Modularity\AssignmentForm\AssignmentForm;
use APIVolunteerManagerIntegration\Modularity\VolunteerForm\VolunteerForm;
use APIVolunteerManagerIntegration\Services\ACFService\ACFService;
use APIVolunteerManagerIntegration\Services\ACFService\ACFServiceFactory;
use APIVolunteerManagerIntegration\Services\AssetsService\Assets;
use APIVolunteerManagerIntegration\Services\AssetsService\AssetsService;
use APIVolunteerManagerIntegration\Services\MyPages\MyPages;
use APIVolunteerManagerIntegration\Services\MyPages\MyPagesService;
use APIVolunteerManagerIntegration\Services\WPService\WPService;
use APIVolunteerManagerIntegration\Services\WPService\WPServiceFactory;
use ReflectionClass;
use ReflectionException;


class Bootstrap implements FilterHookSubscriber, ActionHookSubscriber
{
    public static function addFilters(): array
    {
        return [
            ['Municipio/blade/view_paths', 'setBladeTemplatePaths', 5],
            ['/Modularity/externalViewPath', 'registerViewPaths', 1, 3],
        ];
    }

    public static function addActions(): array
    {
        return [['plugins_loaded', 'registerModules', 1]];
    }

    public function setBladeTemplatePaths(array $paths): array
    {
        array_unshift($paths, API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'source/views/');

        return $paths;
    }

    public function bootstrap(
        DIContainer $DI
    ): void {
        /**
         * Binds classname/interface, and their extending interface name as key to the DI container.
         *
         * @param  class-string  $className  The abstract class or interface (usually)
         *
         * @return class-string[]
         * @throws ReflectionException
         */
        $withExtensions = static fn(string $className): array => [
            $className,
            ...((new ReflectionClass($className))->getInterfaceNames() ?: []),
        ];

        $DI->bind($withExtensions(WPService::class), WPServiceFactory::create());
        $DI->bind($withExtensions(ACFService::class), ACFServiceFactory::create());
        $DI->bind(HttpClientFactory::class, new CurlClientFactory());

        $DI->bind(PluginManager::class, $DI->make(PluginManager::class));
        $DI->bind(MyPages::class, new MyPagesService());
        $DI->bind(AssetsService::class, new Assets());

        $plugin = $DI->resolve(PluginManager::class);
        $plugin->register($this);
    }

    public function registerModules(): void
    {
        foreach (self::modules() as $class) {
            $this->registerModule($class);
        }
    }

    /**
     * @return array<string, class-string>
     * @psalm-suppress MissingDependency
     */
    public static function modules(): array
    {
        // Register modules here
        return [
            'mod-volunteer-form' => VolunteerForm::class,
            'mod-v-assign-form'  => AssignmentForm::class,
        ];
    }

    /**
     * @param  string  $class
     *
     * @return void
     */
    public function registerModule(string $class): void
    {
        if (function_exists('modularity_register_module')) {
            /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
            modularity_register_module(
                API_VOLUNTEER_MANAGER_MODULE_PATH.'/'.$this->getClassNameWithoutNamespace($class),
                $this->getClassNameWithoutNamespace($class)
            );
        }
    }

    /**
     * @param  class-string  $class
     *
     * @psalm-suppress MissingDependency
     */
    public function getClassNameWithoutNamespace(string $class): string
    {
        $path = explode('\\', $class);

        return array_pop($path);
    }

    /**
     *
     * @param  array<string, string>  $paths
     *
     * @return array<string, string>
     */
    public function registerViewPaths(array $paths): array
    {
        foreach (self::modules() as $slug => $class) {
            $name         = $this->getClassNameWithoutNamespace($class);
            $paths[$slug] = API_VOLUNTEER_MANAGER_MODULE_PATH.$name.'/views';
        }

        return $paths;
    }
}