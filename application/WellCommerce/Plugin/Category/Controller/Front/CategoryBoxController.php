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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Core\Component\Controller\AbstractFrontController;

/**
 * Class CategoryBoxController
 *
 * @package WellCommerce\Plugin\Category\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxController extends AbstractFrontController
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