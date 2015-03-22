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

namespace WellCommerce\Bundle\CategoryBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;

/**
 * Class CategoryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CategoryController extends AbstractAdminController
{
    public function indexAction()
    {
        $categories = $this->getManager()->getRepository()->findAll();

        if (count($categories)) {
            $category = current($categories);

            return $this->redirectToAction('edit', [
                'id' => $category->getId()
            ]);
        }

        $tree = $this->buildTreeForm();

        return [
            'tree' => $tree
        ];
    }

    public function addAction(Request $request)
    {
        $shop          = $this->get('shop.context')->getCurrentScope();
        $currentLocale = $request->getLocale();
        $parameters    = $request->request;
        $name          = $parameters->get('name');
        $parent        = $this->getRepository()->find((int)$parameters->get('parent'));
        $locales       = $this->getRepository()->getLocales();

        $category = new Category();
        $category->setHierarchy(0);
        $category->setEnabled(1);
        $category->setParent($parent);
        $category->addShop($shop);

        /** @var $locale \WellCommerce\Bundle\IntlBundle\Entity\Locale */
        foreach ($locales as $locale) {
            $slug = Sluggable::makeSlug($name);
            if ($locale->getCode() != $currentLocale) {
                $slug = Sluggable::makeSlug(sprintf('%s-%s', $name, $locale->getCode()));
            }
            $category->translate($locale->getCode())->setName($name);
            $category->translate($locale->getCode())->setSlug($slug);
        }
        $category->mergeNewTranslations();
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();

        return $this->jsonResponse([
            'id' => $category->getId(),
        ]);
    }

    public function editAction(Request $request)
    {
        $manager  = $this->getManager();
        $tree     = $this->buildTreeForm();
        $resource = $manager->findResource($request);
        $form     = $manager->getForm($resource);

        if ($form->handleRequest()->isValid()) {
            $manager->updateResource($resource, $request);

            return $this->redirectToAction('edit', [
                'id' => $resource->getId()
            ]);
        }

        return [
            'tree' => $tree,
            'form' => $form
        ];
    }

    public function sortAction(Request $request)
    {
        $items      = $request->request->get('items');
        $repository = $this->getRepository();
        $em         = $this->getEntityManager();

        foreach ($items as $item) {
            $parent = $repository->find($item['parent']);
            $child  = $repository->find($item['id']);
            if (null !== $child) {
                $child->setParent($parent);
                $child->setHierarchy($item['weight']);
                $em->persist($child);
            }
        }

        $em->flush();

        return $this->jsonResponse(['success' => true]);
    }

    /**
     * Builds nested tree form
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    private function buildTreeForm()
    {
        return $this->get('category_tree.form_builder')->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select',
        ]);
    }

    /**
     * @return \WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository();
    }
}
