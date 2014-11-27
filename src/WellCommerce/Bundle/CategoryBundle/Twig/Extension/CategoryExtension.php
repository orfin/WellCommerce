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
namespace WellCommerce\Bundle\CategoryBundle\Twig\Extension;

use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryExtension
 *
 * @package WellCommerce\Bundle\CategoryBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryExtension extends \Twig_Extension
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'categoriesTree' => $this->repository->getCategoriesTree()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category';
    }
}
