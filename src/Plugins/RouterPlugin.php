<?php
declare(strict_types=1);

use Aura\Router\RouterContainer;
namespace SONFin\Plugins;

use SONFin\ServiceContainerInterface;
use Aura\Router\RouterContainer;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;
use Psr\Container\ContainerInterface;

class RoutePlugin implements PluginInterface
{	
	function register(ServiceContainerInterface $container) 
    {
        $routerContainer = new RouterContainer();
        /* Registrar as rotas da aplicação */
        $map = $routerContainer->getMap();
        /* Tem a função de identificar a rota que está sendo acessada */
        $matcher = $routerContainer->getMatcher();
        /* Tem a funão de gerar links com base nas rotas registradas*/
        $generator = $routerContainer->getGenerator();
        $request =$this->getRequest();       
        $container->add("routing", $map);
        $container->add("routing.matcher", $matcher);
        $container->add("routing.generator", $generator);
        $container->add(RequestInterface::class, $request);
        $container->addLazy("route", function (ContainerInterface $container)
        {
            $matcher = $container->get("routing.matcher");
            $request =  $container->get(RequestInterface::class);
            return $matcher->match($request);
        });

    }

    protected function getRequest(): RequestInterface
    {
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }
}