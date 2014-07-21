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
namespace WellCommerce\Core\Controller\Admin;

use WellCommerce\Core\Controller\AbstractController;
use WellCommerce\Core\Controller\Admin\AdminControllerInterface;

/**
 * Class AbstractAdminController
 *
 * @package WellCommerce\Core\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->getSession()->get('user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultUrl()
    {
        list($mode, $controller) = explode('.', $this->getRequest()->attributes->get('_route'), 3);

        $url = sprintf('%s.%s.%s', $mode, $controller, 'index');

        return $this->generateUrl($url);
    }

    /**
     * {@inheritdoc}
     */
    public function addSuccessMessage($message)
    {
        return $this->getFlashBag()->add(AdminControllerInterface::MESSAGE_TYPE_SUCCESS, $this->trans($message));
    }

    /**
     * {@inheritdoc}
     */
    public function addErrorMessage($message)
    {
        return $this->getFlashBag()->add(AdminControllerInterface::MESSAGE_TYPE_ERROR, $this->trans($message));
    }
}