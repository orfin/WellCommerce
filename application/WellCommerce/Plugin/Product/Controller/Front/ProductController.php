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
namespace WellCommerce\Plugin\Product\Controller\Front;

use WellCommerce\Core\Component\Controller\Front\AbstractFrontController;
use WellCommerce\Plugin\Product\Layout\ProductLayout;
use WellCommerce\Plugin\Product\Repository\ProductRepositoryInterface;

/**
 * Class ProductController
 *
 * @package WellCommerce\Plugin\Product\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductController extends AbstractFrontController
{
    public function indexAction($slug)
    {
        $product = $this->repository->findBySlug($slug);

        if (!$product) {
            throw $this->createNotFoundException($this->trans('The product does not exist'));
        }

        $this->get('product.provider')->setCurrent($product);

        return [
            'layout' => $this->renderLayout()
        ];
    }

    /**
     * Sets repository
     *
     * @param ProductRepositoryInterface $repository
     */
    public function setRepository(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
