<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerB4xlWxp\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerB4xlWxp/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerB4xlWxp.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerB4xlWxp\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerB4xlWxp\App_KernelDevDebugContainer([
    'container.build_hash' => 'B4xlWxp',
    'container.build_id' => '5eea00e1',
    'container.build_time' => 1620854476,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerB4xlWxp');
