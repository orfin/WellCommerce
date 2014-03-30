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
namespace WellCommerce\Plugin\Product\Controller\Frontend;

use WellCommerce\Core\Controller\FrontendController;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use WellCommerce\Core\Layout\XmlFileLoader;

/**
 * Class ProductController
 *
 * @package WellCommerce\Plugin\Contact\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductController extends FrontendController
{

    public function indexAction()
    {
        echo $this->getLayoutManager()->renderLayout('Product');
        die();
        return [
            'layout' => $this->getLayoutManager()->renderLayout('Product')
        ];
    }
}
