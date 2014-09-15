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

namespace WellCommerce\Bundle\AttributeBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AttributeController
 *
 * @package WellCommerce\Bundle\AttributeBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class AttributeController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepositoryInterface
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new MethodNotAllowedException('Cannot call AttributeController::indexAction directly.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new MethodNotAllowedException('Cannot call AttributeController::addAction directly.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function editAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new MethodNotAllowedException('Cannot call AttributeController::editAction directly.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new MethodNotAllowedException('Cannot call AttributeController::editAction directly.');
        }
    }


}
