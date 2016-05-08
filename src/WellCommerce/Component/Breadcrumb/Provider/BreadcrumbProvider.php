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

namespace WellCommerce\Component\Breadcrumb\Provider;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Breadcrumb\Model\BreadcrumbCollection;
use WellCommerce\Component\Breadcrumb\Model\BreadcrumbInterface;

/**
 * Class BreadcrumbProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class BreadcrumbProvider implements BreadcrumbProviderInterface
{
    /**
     * @var BreadcrumbCollection
     */
    private $collection;

    /**
     * BreadcrumbProvider constructor.
     *
     * @param BreadcrumbCollection $collection
     */
    public function __construct(BreadcrumbCollection $collection)
    {
        $this->collection = $collection;
    }

    public function getBreadcrumbs() : Collection
    {
        return $this->collection;
    }

    public function add(BreadcrumbInterface $breadcrumb)
    {
        $this->collection->add($breadcrumb);
    }
}
