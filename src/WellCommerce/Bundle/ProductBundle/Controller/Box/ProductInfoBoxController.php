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

namespace WellCommerce\Bundle\ProductBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\ProductBundle\Helper\VariantHelperInterface;
use WellCommerce\Bundle\ReviewBundle\Repository\ReviewRepositoryInterface;
use WellCommerce\Bundle\ShippingBundle\Context\ProductContext;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class ProductInfoBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductInfoBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $product             = $this->getProductStorage()->getCurrentProduct();
        $shippingMethodCosts = $this->getShippingMethodProvider()->getCosts(new ProductContext($product));
        $variants            = $this->getVariantHelper()->getVariants($product);
        $attributes          = $this->getVariantHelper()->getAttributes($product);

        return $this->displayTemplate('index', [
            'product'       => $product,
            'shippingCosts' => $shippingMethodCosts,
            'variants'      => json_encode($variants),
            'attributes'    => $attributes,
            'reviews'       => $this->getReviewRepository()->getProductReviews($product)
        ]);
    }

    private function getShippingMethodProvider() : ShippingMethodProviderInterface
    {
        return $this->get('shipping_method.provider');
    }

    private function getVariantHelper() : VariantHelperInterface
    {
        return $this->get('variant.helper');
    }

    private function getReviewRepository() : ReviewRepositoryInterface
    {
        return $this->get('review.repository');
    }
}
