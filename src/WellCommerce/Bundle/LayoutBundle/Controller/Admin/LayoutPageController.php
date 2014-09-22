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

namespace WellCommerce\Bundle\LayoutBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumn;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumnBox;

/**
 * Class LayoutPageController
 *
 * @package WellCommerce\Bundle\LayoutBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class LayoutPageController extends AbstractAdminController
{
    public function indexAction(Request $request)
    {
        $tree = $this->getFormBuilder($this->get('layout_page.tree'), null, [
            'name'  => 'layout_page_tree',
            'class' => 'category-select',
        ]);

        return [
            'tree' => $tree
        ];
    }

    public function editAction(Request $request)
    {
        $tree = $this->getFormBuilder($this->get('layout_page.tree'), null, [
            'name'  => 'layout_page_tree',
            'class' => 'category-select',
        ]);

        $resource = $this->repository->findResource($request);

        $form = $this->getFormBuilder($this->get('layout_page.form'), $resource, [
            'name' => 'layout_page_form',
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $this->manager->update($resource, $request);
            if ($form->isAction('continue')) {
                return $this->manager->getRedirectHelper()->redirectToAction('edit', $resource);
            }

            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        return [
            'tree' => $tree,
            'form' => $form
        ];
    }
}
