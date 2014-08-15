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

namespace WellCommerce\Bundle\CategoryBundle\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * Class RecursiveCategoryIterator
 *
 * @package WellCommerce\Bundle\CategoryBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RecursiveCategoryIterator implements \RecursiveIterator
{
    private $_data;

    public function __construct(Collection $data)
    {
        $this->_data = $data;
    }

    public function hasChildren()
    {
        return (!$this->_data->current()->getChildCategories()->isEmpty());
    }

    public function getChildren()
    {
        return new RecursiveCategoryIterator($this->_data->current()->getChildCategories());
    }

    public function current()
    {
        return $this->_data->current();
    }

    public function next()
    {
        $this->_data->next();
    }

    public function key()
    {
        return $this->_data->key();
    }

    public function valid()
    {
        return $this->_data->current() instanceof Category;
    }

    public function rewind()
    {
        $this->_data->first();
    }
} 