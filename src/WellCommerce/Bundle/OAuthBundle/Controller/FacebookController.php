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

namespace WellCommerce\Bundle\OAuthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;

/**
 * Class FacebookController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FacebookController extends AbstractController
{
    public function connectAction(Request $request)
    {
        return $this->get('oauth.authentificator.facebook')->start($request);
    }
    
    public function checkAction()
    {
    }
}
