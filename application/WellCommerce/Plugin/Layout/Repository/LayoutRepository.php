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

namespace WellCommerce\Plugin\Layout\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Layout\Model\LayoutPage;

/**
 * Class LayoutRepository
 *
 * @package WellCommerce\Plugin\Layout\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutRepository extends AbstractRepository implements LayoutRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return LayoutPage::with('column', 'column.box')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($page)
    {
        return LayoutPage::with('column', 'column.boxes', 'column.boxes.box')->where('name', '=', $page)->first();
    }

}