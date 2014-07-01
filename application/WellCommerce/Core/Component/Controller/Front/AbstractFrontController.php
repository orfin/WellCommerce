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
namespace WellCommerce\Core\Component\Controller\Front;

use WellCommerce\Core\Component\Controller\AbstractController;
use WellCommerce\Core\Layout\Layout;
use WellCommerce\Core\Layout\LayoutInterface;

/**
 * Class AbstractFrontController
 *
 * @package WellCommerce\Core\Component\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontController extends AbstractController implements FrontControllerInterface
{
    /**s
     *
     * @var \WellCommerce\Core\Layout\LayoutInterface
     */
    private $layout = null;

    /**
     * {@inheritdoc}
     */
    public function setLayout($name, $cache = true, $ttl = LayoutInterface::CACHE_TTL)
    {
        $this->layout = new Layout($name, $cache, $ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function renderLayout()
    {
        if (null === $this->layout) {
            throw new \LogicException(sprintf('Layout for controller is not set. You must use setLayout method in controller service definition.'));
        }

        return $this->getLayoutRenderer()->load($this->layout);
    }
}