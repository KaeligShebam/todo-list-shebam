<?php

namespace ContainerMbjIALu;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_S3xOnWJService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.s3xOnWJ' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.s3xOnWJ'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'quoteAdmin' => ['privates', 'App\\Repository\\QuoteRepository', 'getQuoteRepositoryService', true],
            'rendezvousAdmin' => ['privates', 'App\\Repository\\RendezvousRepository', 'getRendezvousRepositoryService', true],
            'task2Admin' => ['privates', 'App\\Repository\\Task2Repository', 'getTask2RepositoryService', true],
            'taskAdmin' => ['privates', 'App\\Repository\\TaskRepository', 'getTaskRepositoryService', true],
        ], [
            'quoteAdmin' => 'App\\Repository\\QuoteRepository',
            'rendezvousAdmin' => 'App\\Repository\\RendezvousRepository',
            'task2Admin' => 'App\\Repository\\Task2Repository',
            'taskAdmin' => 'App\\Repository\\TaskRepository',
        ]);
    }
}
