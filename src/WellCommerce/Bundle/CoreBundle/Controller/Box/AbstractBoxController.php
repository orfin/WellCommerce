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

use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;

/**
 * Class AbstractFrontController
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractBoxController extends AbstractController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBoxId()
    {
        return $this->getParam('_box_id');
    }

    /**
     * {@inheritdoc}
     */
    public function getBoxSetting($id)
    {
        $accessor = $this->getPropertyAccessor();

        return $accessor->getValue($this->getParam('_box_settings'), '[' . $id . ']');
    }


}