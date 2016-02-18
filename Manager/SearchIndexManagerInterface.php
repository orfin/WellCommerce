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

namespace WellCommerce\Bundle\SearchBundle\Manager;

/**
 * Interface SearchIndexManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchIndexManagerInterface
{
    /**
     * Creates an index
     *
     * @param string $name
     */
    public function createIndex($name);

    /**
     * Returns an existing index by its name
     *
     * @param string $name
     *
     * @return object
     */
    public function getIndex($name);

    /**
     * Checks whether the index exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasIndex($name);

    /**
     * Removes the given index
     *
     * @param string $name
     */
    public function removeIndex($name);

    /**
     * Erases the given index
     *
     * @param string $name
     */
    public function eraseIndex($name);
}
