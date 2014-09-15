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

namespace WellCommerce\Bundle\AttributeBundle\Repository;

use Symfony\Component\HttpFoundation\ParameterBag;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface AttributeRepositoryInterface
 *
 * @package WellCommerce\Bundle\AttributeBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns all groups with translations
     *
     * @return array
     */
    public function findAll();

    /**
     * Adds new attribute
     *
     * @param ParameterBag $parameters
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Entity\Attribute
     */
    public function addAttribute($name);

    /**
     * Finds attribute entity by its id or creates a new one
     *
     * @param $data
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Entity\Attribute
     */
    public function findOrCreate($data);

    /**
     * Returns all attributes by group id
     *
     * @param integer $id Attribute group id
     *
     * @return mixed
     */
    public function findAllByAttributeGroupId($id);
} 