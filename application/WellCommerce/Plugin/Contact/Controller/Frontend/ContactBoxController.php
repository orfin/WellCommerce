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

namespace WellCommerce\Plugin\Contact\Controller\Frontend;

use WellCommerce\Core\Controller\FrontendController;

/**
 * Class ContactBoxController
 *
 * @package WellCommerce\Plugin\Contact\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactBoxController extends FrontendController
{

    public function indexAction()
    {
        return [
            'categories' => $this->getRepository()->getCategoriesTree()
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('category.repository');
    }
} 