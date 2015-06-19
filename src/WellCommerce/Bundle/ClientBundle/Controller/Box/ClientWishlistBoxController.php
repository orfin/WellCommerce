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

namespace WellCommerce\Bundle\ClientBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientWishlistBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        return $this->render('WellCommerceClientBundle:Box/ClientWishlist:index.html.twig');
    }
}
