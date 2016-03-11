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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Component\Form\DataTransformer\DataTransformerCollection;
use WellCommerce\Component\Form\DataTransformer\DataTransformerInterface;
use WellCommerce\Component\Form\Exception\MissingFormDataTransformerException;

/**
 * Class DataTransformerFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataTransformerFactory extends AbstractContainerAware
{
    /**
     * @var DataTransformerCollection
     */
    protected $collection;

    /**
     * @param DataTransformerCollection $collection
     */
    public function __construct(DataTransformerCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Creates and returns a new instance of form data transformer
     *
     * @param string $alias
     *
     * @return DataTransformerInterface
     */
    public function createRepositoryTransformer(string $alias) : DataTransformerInterface
    {
        if (!$this->collection->has($alias)) {
            throw new MissingFormDataTransformerException($alias);
        }

        $serviceId = $this->collection->get($alias);

        return $this->get($serviceId);
    }
}
