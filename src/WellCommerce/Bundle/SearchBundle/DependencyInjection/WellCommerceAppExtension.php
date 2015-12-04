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

namespace WellCommerce\Bundle\SearchBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;

/**
 * Class WellCommerceAppExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceAppExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
        $type          = $config['type'];

        $container->setParameter('search_term_min_length', $config['search_term_min_length']);
        $container->setAlias('product_search.indexer', sprintf('product_search.indexer.%s', $type));
        $container->setAlias('search_index.manager', sprintf('search_index.manager.lucene', $type));
        $container->setAlias('product_search.provider', sprintf('product_search.provider.lucene', $type));
    }
}
