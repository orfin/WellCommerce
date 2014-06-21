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
namespace WellCommerce\Plugin\Category\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Category\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryController
 *
 * @package WellCommerce\Plugin\Category\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $tree = $this->createForm($this->get('category.tree'), null, [
            'name'  => 'category_tree',
            'class' => 'category-select'
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
        $category = $this->repository->find($id);

        // render tree
        $tree = $this->createForm($this->get('category.tree'), null, [
            'name'  => 'category_tree',
            'class' => 'category-select'
        ]);

        // render edit form
        $form = $this->createForm($this->get('category.form'), $category, [
            'name' => 'edit_category'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage(sprintf('Category "%s" saved successfully.', $category->translation->first()->name));

                return $this->redirect($this->generateUrl('admin.category.edit', ['id' => $category->id]));

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return Array(
            'tree'     => $tree,
            'category' => $category,
            'form'     => $form
        );
    }

    /**
     * Sets category repository object
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function setRepository(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
