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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Class AbstractContainer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractContainer extends AbstractNode
{
    /**
     * @var ElementCollection
     */
    protected $elements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new ElementCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addElement(ElementInterface $element)
    {
        $this->elements->add($element);

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->elements->forAll(function (ElementInterface $element) use ($filter) {
            $element->addFilter($filter);
        });
    }

}