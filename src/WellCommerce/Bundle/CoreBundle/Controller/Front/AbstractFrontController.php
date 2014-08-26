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

use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\LayoutBundle\Manager\Layout;
use WellCommerce\Bundle\LayoutBundle\Manager\LayoutInterface;

/**
 * Class AbstractFrontController
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontController extends AbstractController implements FrontControllerInterface
{
    /**
     * @var null|Layout
     */
    private $layout = null;

    /**
     * {@inheritdoc}
     */
    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * {@inheritdoc}
     */
    protected function renderLayout()
    {
        if (null !== $this->layout) {
            $this->getLayoutRenderer()->load($this->layout);
        }

        return '';
    }
}