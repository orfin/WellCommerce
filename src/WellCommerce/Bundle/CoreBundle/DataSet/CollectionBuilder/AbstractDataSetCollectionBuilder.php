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

namespace WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;

/**
 * Class AbstractDataSetCollectionBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSetCollectionBuilder
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $rows;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Constructor
     *
     * @param DataSetInterface $dataset
     * @param array            $options
     */
    public function __construct(DataSetInterface $dataset, array $options = [])
    {
        $this->dataset   = $dataset;
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options          = $optionsResolver->resolve($options);
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Configures collection builder options
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'limit',
            'order_by',
            'order_dir',
        ]);

        $resolver->setDefaults([
            'conditions' => null,
        ]);

        $resolver->setAllowedTypes([
            'limit'      => ['numeric'],
            'order_by'   => ['string'],
            'order_dir'  => ['string'],
            'conditions' => ['null', 'WellCommerce\Bundle\CoreBundle\DataSet\Conditions\ConditionsCollection'],
        ]);
    }

    /**
     * Creates new dataset request object
     *
     * @return DataSetRequest
     */
    protected function getDataSetRequest()
    {
        return new DataSetRequest([
            'limit'      => $this->options['limit'],
            'orderBy'    => $this->options['order_by'],
            'orderDir'   => $this->options['order_dir'],
            'conditions' => $this->options['conditions'],
        ]);
    }

    /**
     * Returns dataset rows
     *
     * @return array
     */
    protected function getDataSetRows()
    {
        if (empty($this->rows)) {
            $this->rows = $this->getResults();
        }

        return $this->rows;
    }

    /**
     * Returns dataset result rows
     *
     * @return array
     */
    protected function getResults()
    {
        $request = $this->getDataSetRequest();
        $results = $this->dataset->getResults($request);

        return $results['rows'];
    }
}
