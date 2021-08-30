<?php
declare(strict_types=1);
namespace SONFin\Plugins;


use SONFin\ServiceContainerInterface;

interface PluginInterface
{
    public function register(ServiceContainerInterface $container);
}