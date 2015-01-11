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

namespace WellCommerce\Bundle\ProductBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface;

/**
 * Class ProductController
 *
 * @package WellCommerce\Bundle\WebBundle\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ProductController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $repository;

    public function indexAction(Request $request)
    {
        $this->repository->findResource($request);

        $resource = $this->get('product.repository')->findResource($request);

        if (null === $resource) {
            throw new NotFoundHttpException($this->trans('product.resource.not_found'));
        }

        return [
            'product' => $resource
        ];
    }

    /**
     * Sets product repository
     *
     * @param ProductRepositoryInterface $repository
     */
    public function setRepository(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
