<?php
/*
 * This file is part of the BeSimpleSoapBundle.
 *
 * (c) Christian Kerl <christian-kerl@web.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BeSimple\SoapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use BeSimple\SoapBundle\Controller\SoapWebServiceController;

/**
 * Adds tagged besimple.soap.definition.loader services to ebservice.definition.resolver service
 *
 * @author Francis Besset <francis.besset@gmail.com>
 */
class WebServiceContextPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->has(SoapWebServiceController::class)) {
            return;
        }

        $definition = $container->getDefinition(SoapWebServiceController::class);

        foreach ($container->findTaggedServiceIds('besimple.soap.context') as $id => $tags) {
            $definition->addMethodCall('addWebServiceContext', array($id, new Reference($id)));
        }
    }
}
