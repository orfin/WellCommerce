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
namespace WellCommerce\Layout\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Layout\Repository\LayoutPageRepositoryInterface;

/**
 * Class LayoutPageController
 *
 * @package WellCommerce\LayoutPage\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $tree = $this->createForm($this->get('layout_page.tree'), null, [
            'name'  => 'layout_page_tree',
            'class' => 'category-select',
        ]);

        return Array(
            'tree' => $tree
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $layoutPageColumns = $this->repository->findPagesByThemeId($id);

        // render tree
        $tree = $this->createForm($this->get('layout_page.tree'), null, [
            'name'  => 'layout_page_tree',
            'class' => 'category-select'
        ]);

        // render edit form
        $form = $this->createForm($this->get('layout_page.form'), $layoutPageColumns, [
            'name' => 'layout_page_columns'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesGrouped(), $id);
                $this->addSuccessMessage(sprintf('Layout pages saved successfully.'));

                return $this->redirect($this->generateUrl('admin.layout_page.edit', ['id' => $id]));

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return Array(
            'tree'        => $tree,
            'form'        => $form
        );
    }

    /**
     * Sets layout_page repository object
     *
     * @param LayoutPageRepositoryInterface $repository
     */
    public function setRepository(LayoutPageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
