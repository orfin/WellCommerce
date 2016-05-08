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
namespace WellCommerce\Bundle\CoreBundle\Controller\Front;

use WellCommerce\Bundle\CategoryBundle\Storage\CategoryStorageInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\PageBundle\Storage\Front\PageStorageInterface;
use WellCommerce\Bundle\ProducerBundle\Storage\Front\ProducerStorageInterface;
use WellCommerce\Bundle\ProductBundle\Storage\ProductStorageInterface;
use WellCommerce\Bundle\ProductStatusBundle\Storage\ProductStatusStorageInterface;

/**
 * Class AbstractFrontController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontController extends AbstractController implements FrontControllerInterface
{
    protected function getCategoryStorage() : CategoryStorageInterface
    {
        return $this->get('category.storage');
    }

    protected function getProductStorage() : ProductStorageInterface
    {
        return $this->get('product.storage');
    }

    protected function getProductStatusStorage() : ProductStatusStorageInterface
    {
        return $this->get('product_status.storage');
    }

    protected function getProducerStorage() : ProducerStorageInterface
    {
        return $this->get('producer.storage');
    }
    
    protected function getPageStorage() : PageStorageInterface
    {
        return $this->get('page.storage');
    }
    
    protected function getAuthenticatedClient() : ClientInterface
    {
        return $this->getSecurityHelper()->getAuthenticatedClient();
    }
}
