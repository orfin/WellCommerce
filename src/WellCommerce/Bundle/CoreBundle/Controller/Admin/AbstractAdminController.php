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
namespace WellCommerce\Bundle\CoreBundle\Controller\Admin;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\DataGrid\Request\Request;

/**
 * Class AbstractAdminController
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{

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
        return $this->getFlashBag()->add(AdminControllerInterface::MESSAGE_TYPE_SUCCESS, $this->trans($message, [], 'flashes'));
    }

    /**
     * {@inheritdoc}
     */
    public function addErrorMessage($message)
    {
        return $this->getFlashBag()->add(AdminControllerInterface::MESSAGE_TYPE_ERROR, $this->trans($message, [], 'flashes'));
    }

    /**
     * {@inheritdoc}
     */
    public function trans($id, $params = [], $domain = 'admin')
    {
        return $this->getTranslator()->trans($id, $params, $domain);
    }
}