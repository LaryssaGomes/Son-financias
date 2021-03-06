<?php 

namespace SONFin;
use SONFin\Plugins\PluginInterface;

class Application
{
    private $serviceContainer;

    public function __constructServiceContainer(ServiceContainer $serviceContainer){
        $this->serviceContainer = $serviceContainer;
    }

    public function service($name){
        return $this->serviceContainer->get($name);
    }

    public function addService(string $name, $service): void
    {
        if(is_callable($service)){
            $this->serviceContainer->addLazy($name, $service);
        }else{
            $this->serviceContainer->add($name, $service);
        }
    }

    public function plugin(PluginInterface $plugin): void
    {
        $plugin->register($this->serviceContainer);
    }
}