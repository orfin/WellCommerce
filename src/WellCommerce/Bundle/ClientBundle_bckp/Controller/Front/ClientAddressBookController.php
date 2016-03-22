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

namespace WellCommerce\Bundle\ClientBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class ClientAddressBookController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientAddressBookController extends AbstractFrontController
{
    public function indexAction() : Response
    {
        return $this->displayTemplate('index');
    }
}
