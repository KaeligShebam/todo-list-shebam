<?php

namespace ContainerMbjIALu;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_IFNi2vdService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.IFNi2vd' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.IFNi2vd'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'customerModify' => ['privates', '.errored..service_locator.IFNi2vd.App\\Entity\\Customer', NULL, 'Cannot autowire service ".service_locator.IFNi2vd": it references class "App\\Entity\\Customer" but no such service exists.'],
        ], [
            'customerModify' => 'App\\Entity\\Customer',
        ]);
    }
}
