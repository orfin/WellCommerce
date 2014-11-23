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

namespace WellCommerce\Bundle\CategoryBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CategoryBundle\Exception\CategoryNotFoundException;
use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryProvider
 *
 * @package WellCommerce\Bundle\CategoryBundle\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryProvider implements CategoryProviderInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $repository;

    /**
     * @var array Current category info
     */
    protected $currentCategory;

    /**
     * Constructor
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getTree()
    {

    }

    public function findCurrentCategory(Request $request)
    {
        $category = $this->repository->findResource($request, [
            'enabled' => 1
        ]);

        if (null === $category) {
            throw new CategoryNotFoundException('Category not found');
        }

        $this->currentCategory = $this->prepareCategoryData($category);
    }

    public function getCurrentCategory()
    {
        return $this->currentCategory;
    }

    private function prepareCategoryData(Category $category)
    {
        $data         = [];
        $accessor     = PropertyAccess::createPropertyAccessor();
        $translations = $category->translate();

        $accessor->setValue($data, '[translation]', [
            'name'              => $translations->getName(),
            'short_description' => $translations->getDescription(),
        ]);

        return $data;
    }

} 