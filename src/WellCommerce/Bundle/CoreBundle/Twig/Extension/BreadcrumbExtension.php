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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItemCollectionInterface;

/**
 * Class BreadcrumbExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param BreadcrumbItemCollectionInterface $builder
     */
    public function __construct(BreadcrumbItemCollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    public function getBreadcrumbs()
    {
        return $this->collection->all();
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('breadcrumbs', [$this, 'getBreadcrumbs'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'breadcrumb';
    }
}
