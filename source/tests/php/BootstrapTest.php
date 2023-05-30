<?php

namespace APIVolunteerManagerIntegration\Tests;

use APIVolunteerManagerIntegration\Bootstrap;

class BootstrapTest extends PluginTestCase
{

    private Bootstrap $bootstrap;

    public function setUp(): void
    {
        parent::setUp();
        $this->bootstrap = new Bootstrap();
    }

    public function testSetBladeTemplatePaths(): void
    {
        $paths    = ['path1', 'path2'];
        $expected = [
            API_VOLUNTEER_MANAGER_INTEGRATION_PATH.'source/views/',
            'path1',
            'path2',
        ];

        $result = $this->bootstrap->setBladeTemplatePaths($paths);

        $this->assertEquals($expected, $result);
    }

    public function testRegisterFilters(): void
    {
        $this->wp
            ->addAction('plugins_loaded', [$this->bootstrap, 'registerModules'], 1, 1)
            ->shouldBeCalled();

        $this->wp
            ->addFilter('Municipio/blade/view_paths', [$this->bootstrap, 'setBladeTemplatePaths'],
                5, 1)
            ->shouldBeCalled();

        $this->wp
            ->addFilter('/Modularity/externalViewPath', [$this->bootstrap, 'registerViewPaths'],
                1, 3)
            ->shouldBeCalled();

        $this->pluginManager->register($this->bootstrap);
    }

    public function testRegisterViewPaths(): void
    {
        $paths = ['path1', 'path2'];

        $bootstrap = new Bootstrap();

        foreach (Bootstrap::modules() as $slug => $class) {
            $name         = $bootstrap->getClassNameWithoutNamespace($class);
            $paths[$slug] = API_VOLUNTEER_MANAGER_MODULE_PATH.$name.'/views';
        }

        $result = $bootstrap->registerViewPaths(['path1', 'path2']);

        $this->assertEquals($paths, $result);
    }

    /*    public function testRegisterModules(): void
        {
            // Assuming we're using PHPUnit's MockBuilder
            // and the global function is under the same namespace with Bootstrap

            $modules = Bootstrap::modules();

            // expect the modularity_register_module to be called with right parameters
            foreach ($modules as $slug => $class) {
                $name = $this->bootstrap->getClassNameWithoutNamespace($class);

                $this->bootstrap->expects($this->once())
                                ->method('modularity_register_module')
                                ->with(API_VOLUNTEER_MANAGER_MODULE_PATH.'/'.$name, $name);
            }

            $this->bootstrap->registerModules();
        }*/
}