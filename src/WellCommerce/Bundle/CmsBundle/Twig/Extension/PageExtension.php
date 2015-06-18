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
namespace WellCommerce\Bundle\CmsBundle\Twig\Extension;

use WellCommerce\Bundle\DataSetBundle\CollectionBuilder\CollectionBuilderFactoryInterface;

/**
 * Class PageExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageExtension extends \Twig_Extension
{
    /**
     * @var CollectionBuilderFactoryInterface
     */
    protected $collectionBuilder;

    /**
     * Constructor
     *
     * @param CollectionBuilderFactoryInterface $collectionBuilder
     */
    public function __construct(CollectionBuilderFactoryInterface $collectionBuilder)
    {
        $this->collectionBuilder = $collectionBuilder;
    }

    public function getGlobals()
    {
        return [
            'cmsPageTree' => $this->collectionBuilder->getTree()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cms_page';
    }
}
