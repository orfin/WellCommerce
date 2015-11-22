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
namespace WellCommerce\AppBundle\Twig\Extension;

use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class PageExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageExtension extends \Twig_Extension
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * Constructor
     *
     * @param DataSetInterface $dataset
     */
    public function __construct(DataSetInterface $dataset)
    {
        $this->dataset = $dataset;
    }

    public function getGlobals()
    {
        return [
            'cmsPages' => $this->getCmsPages()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cms_page';
    }

    /**
     * @return array
     */
    public function getCmsPages()
    {
        return $this->dataset->getResult('tree', [
            'order_by' => 'hierarchy'
        ]);
    }
}
