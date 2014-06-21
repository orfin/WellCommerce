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
namespace WellCommerce\Plugin\Layout\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Layout\Repository\LayoutPageRepositoryInterface;

/**
 * Class LayoutPageController
 *
 * @package WellCommerce\Plugin\LayoutPage\Controller\Admin
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
        $layoutPage = $this->repository->find($id);

        // render tree
        $tree = $this->createForm($this->get('layout_page.tree'), null, [
            'name'  => 'layout_page_tree',
            'class' => 'category-select'
        ]);

        // render edit form
        $form = $this->createForm($this->get('layout_page.form'), $layoutPage, [
            'name' => 'layout_page'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage(sprintf('Page "%s" saved successfully.', $layoutPage->translation->first()->name));

                return $this->redirect($this->generateUrl('admin.layout_page.edit', ['id' => $layoutPage->id]));

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return Array(
            'tree'        => $tree,
            'layout_page' => $layoutPage,
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
