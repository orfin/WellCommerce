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
namespace WellCommerce\Bundle\CoreBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class AbstractFrontController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractBoxController extends AbstractFrontController implements BoxControllerInterface
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        return $this->displayTemplate('index');
    }
}
