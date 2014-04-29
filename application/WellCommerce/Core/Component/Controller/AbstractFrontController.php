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
namespace WellCommerce\Core\Component\Controller;

use WellCommerce\Core\Layout\Page\LayoutPageInterface;

/**
 * Class AbstractFrontController
 *
 * @package WellCommerce\Core\Component\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontController extends AbstractController
{
    /**
     * @var
     */
    protected $layout;

    /**
     * Sets Layout manager for controller
     *
     * @param LayoutPageInterface $layout
     */
    public function setLayout(LayoutPageInterface $layout)
    {
        $this->layout = $layout;
    }

    /**
     * As box settings are passed as another key in forwarded requests
     * we need to fetch them using accessor
     *
     * @param $id
     *
     * @return mixed
     */
    final protected function getSetting($id)
    {
        $accessor = $this->getPropertyAccessor();

        return $accessor->getValue($this->getParam('_box_settings'), '[' . $id . ']');
    }
}