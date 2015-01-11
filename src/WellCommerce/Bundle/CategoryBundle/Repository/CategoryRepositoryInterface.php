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

namespace WellCommerce\Bundle\CategoryBundle\Repository;

use Symfony\Component\HttpFoundation\ParameterBag;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface CategoryRepositoryInterface
 *
 * @package WellCommerce\Bundle\CategoryBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryRepositoryInterface extends RepositoryInterface, DataSetAwareRepositoryInterface
{
    /**
     * Adds category using only its name
     * Mostly used in alert prompt on category index/edit screen
     *
     * @param ParameterBag $parameters
     *
     * @return \WellCommerce\Bundle\CategoryBundle\Entity\Category
     */
    public function quickAddCategory(ParameterBag $parameters);

    /**
     * Changes categories hierarchy
     *
     * @param $items
     *
     * @return mixed
     */
    public function changeOrder(array $items = []);
}
