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

namespace WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder;

/**
 * Interface CollectionBuilderFactoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface CollectionBuilderFactoryInterface
{
    /**
     * Returns tree structure
     *
     * @param array $options
     *
     * @return array
     */
    public function getTree(array $options = []);

    /**
     * Returns flat tree structure
     *
     * @param array $options
     *
     * @return array
     */
    public function getFlatTree(array $options = []);

    /**
     * Returns select items
     *
     * @param array $options
     *
     * @return array
     */
    public function getSelect(array $options = []);
} 