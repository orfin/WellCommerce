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
    public function indexAction()
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

        $form = $this->getFormBuilder($this->get('layout_page.form'), null, [
            'name' => 'layout_page_form',
        ]);

        $pageColumns = $this->get('layout_page_column.repository')->findBy(['theme' => $this->getParam('id')]);
        $form->populate($this->prepareData($pageColumns));

        if ($form->handleRequest($request)->isValid()) {
            $formData = $form->getSubmitValuesGrouped();
            $theme    = $this->get('layout_theme.repository')->find($this->getParam('id'));

            // first delete all columns
            foreach ($pageColumns as $page) {
                $this->getEntityManager()->remove($page);
            }

            // iterate through submitted data
            foreach ($formData as $pageId => $columnsData) {
                $pageId     = substr($pageId, 12);
                $layoutPage = $this->get('layout_page.repository')->find($pageId);

                // iterate through all columns and add them to page
                foreach ($columnsData['columns_data'] as $column) {
                    $layoutPageColumn = new LayoutPageColumn();
                    $layoutPageColumn->setTheme($theme);
                    $layoutPageColumn->setPage($layoutPage);
                    $layoutPageColumn->setWidth($column['width']);
                    $this->getEntityManager()->persist($layoutPageColumn);

                    // add boxes to each column
                    $this->saveColumnBoxes($column['layout_boxes'], $layoutPageColumn);
                }
            }

            $this->getEntityManager()->flush();

            return $this->manager->getRedirectHelper()->redirectTo('admin.layout_page.edit', [
                'id' => $this->getParam('id')
            ]);
        }

        return [
            'tree' => $tree,
            'form' => $form
        ];
    }

    protected function saveColumnBoxes($boxes, LayoutPageColumn $column)
    {
        if (!empty($boxes)) {
            foreach ($boxes as $box) {
                $boxId               = $box['layoutbox'];
                $layoutBox           = $this->get('layout_box.repository')->find($boxId);
                $layoutPageColumnBox = new LayoutPageColumnBox();
                $layoutPageColumnBox->setBox($layoutBox);
                $layoutPageColumnBox->setColumn($column);
                $layoutPageColumnBox->setSpan($box['span']);
                $this->getEntityManager()->persist($layoutPageColumnBox);
            }
        }
    }

    protected  function prepareData($pageColumns)
    {
        $formData = [];

        foreach ($pageColumns as $column) {

            $boxes = [];
            foreach ($column->getBoxes() as $box) {
                $boxes[] = [
                    'box'       => $box->getBox()->getId(),
                    'span'      => $box->getSpan(),
                    'collapsed' => 0
                ];
            }

            $formData['layout_page_' . $column->getPage()->getId()]['columns_data'][$column->getId()] = [
                'width'        => $column->getWidth(),
                'layout_boxes' => $boxes
            ];
        }

        return $formData;
    }
}
