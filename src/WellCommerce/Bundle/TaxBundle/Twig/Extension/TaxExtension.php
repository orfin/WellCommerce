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
namespace WellCommerce\Bundle\TaxBundle\Twig\Extension;

use WellCommerce\Bundle\DataSetBundle\CollectionBuilder\SelectBuilder;
use WellCommerce\Bundle\TaxBundle\DataSet\TaxDataSet;

/**
 * Class TaxExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxExtension extends \Twig_Extension
{
    /**
     * @var TaxDataSet
     */
    protected $dataSet;

    /**
     * Constructor
     *
     * @param TaxDataSet $dataSet
     */
    public function __construct(TaxDataSet $dataSet)
    {
        $this->dataSet = $dataSet;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        $taxSelectBuilder = new SelectBuilder($this->dataSet, [
            'label_key' => 'value',
            'order_by'  => 'value',
        ]);

        return [
            'taxes' => $taxSelectBuilder->getItems()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tax';
    }
}
