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

namespace WellCommerce\AppBundle\Controller\Box;

use WellCommerce\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class PageBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        return $this->displayTemplate('index');
    }
}
