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
namespace WellCommerce\Bundle\WebBundle\Twig\Extension;

use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbBuilderInterface;

/**
 * Class BreadcrumbExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var BreadcrumbBuilderInterface
     */
    protected $builder;

    /**
     * Constructor
     *
     * @param BreadcrumbBuilderInterface $builder
     */
    public function __construct(BreadcrumbBuilderInterface $builder)
    {
        $this->builder = $builder;
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


    public function getBreadcrumbs()
    {
        return $this->builder->all();
    }
}
