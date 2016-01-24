<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\GeneratorBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\GeneratorBundle\Resolver\ExtraMappingResolver;

/**
 * Class ExtendedEntityCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtendedEntityCacheWarmer extends AbstractContainerAware implements CacheWarmerInterface
{
    public function warmUp($cacheDir)
    {
        $extraMappingResolver = new ExtraMappingResolver();
        $extraMapping         = $extraMappingResolver->resolve();

        print_r($extraMapping);
        die();

        $this->regenerateExtendedEntities($extraMapping);
        $this->updateDataBaseSchema();
    }

    protected function regenerateExtendedEntities($extraMapping)
    {
        $entityGenerator = $this->container->get('generator.extended_entity.generator');

        foreach ($extraMapping as $extraMappingClass => $extraMappingContent) {
            $reflectionClass = new \ReflectionClass($extraMappingClass);
            $entityGenerator->generateExtendedEntity($reflectionClass, $extraMappingContent);
        }
    }

    protected function updateDataBaseSchema()
    {
        return $this->container->get('generator.doctrine_schema_updater')->execute();
    }

    public function isOptional()
    {
        return false;
    }
}
