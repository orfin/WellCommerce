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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Transformer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface;
use WellCommerce\Component\DataSet\Transformer\AbstractDataSetTransformer;

/**
 * Class CategoryTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CategoryTransformer extends AbstractDataSetTransformer
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    /**
     * @var Collection
     */
    private $categories;

    /**
     * CategoryTransformer constructor.
     *
     * @param UrlGeneratorInterface       $generator
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(UrlGeneratorInterface $generator, CategoryRepositoryInterface $repository)
    {
        $this->generator  = $generator;
        $this->repository = $repository;
    }

    public function transformValue($value)
    {
        if (null === $this->categories) {
            $this->loadCategories();
        }

        $identifiers      = explode(',', $value);
        $transformedValue = [];

        foreach ($identifiers as $identifier) {
            if (isset($this->categories[$identifier])) {
                $transformedValue[] = $this->categories[$identifier];
            }
        }
        
        return $transformedValue;
    }

    private function loadCategories()
    {
        $collection = $this->repository->matching(new Criteria());
        $collection->map(function (CategoryInterface $category) {
            $this->categories[$category->getId()] = [
                'name'  => $category->translate()->getName(),
                'route' => $this->generator->generate($category->translate()->getRoute()->getId())
            ];
        });
    }
}
