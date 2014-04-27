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

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\Component\Repository\RepositoryInterface;

/**
 * Class AbstractAdminController
 *
 * @package WellCommerce\Core\Component\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    /**
     * Get user identifier
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->getSession()->get('user_id');
    }

    /**
     * Evaluates default route for current controller. All admin controllers must have indexAction
     *
     * @return string
     */
    protected function getDefaultUrl()
    {
        list($mode, $controller) = explode('.', $this->getRequest()->attributes->get('_route'), 3);

        $url = sprintf('%s.%s.%s', $mode, $controller, 'index');

        return $this->generateUrl($url);
    }
}