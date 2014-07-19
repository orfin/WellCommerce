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

namespace WellCommerce\Category\Controller\Box;

use WellCommerce\Core\Component\Controller\Box\AbstractBoxController;
use WellCommerce\Category\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryInfoBoxController
 *
 * @package WellCommerce\Category\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryInfoBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $category = $this->get('category.provider')->getCurrent();

        return [
            'category' => $category
        ];
    }
}