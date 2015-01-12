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

namespace WellCommerce\Bundle\CmsBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;

/**
 * Class PageBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class PageBoxController extends AbstractBoxController implements BoxControllerInterface
{
    public function indexAction(Request $request)
    {
        $page = $this->findOr404($request, [
            'publish' => 1
        ]);

        $translations = $page->translate();

        return [
            'page' => [
                'name'    => $translations->getName(),
                'content' => $translations->getContent(),
            ]
        ];
    }
}
