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

namespace WellCommerce\Plugin\Category\Controller\Frontend;

use WellCommerce\Core\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryBoxController
 *
 * @package WellCommerce\Plugin\Category\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxController extends FrontendController
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