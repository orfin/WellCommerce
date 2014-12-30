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

namespace WellCommerce\Bundle\CoreBundle\Form\DataMapper;

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class DataMapper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataMapper implements DataMapperInterface
{
    protected $data;

    protected $propertyAccessor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function mapDataToForm($data, FormInterface $form)
    {
        $this->data = $data;

        $this->mapDataToElementCollection($form);
    }

    public function mapFormToData(FormInterface $form, $data)
    {
    }

    /**
     * Maps data to single element
     *
     * @param ElementInterface $parent
     * @param ElementInterface $child
     */
    protected function mapDataToElement(ElementInterface $parent, ElementInterface $child)
    {
        echo "Parent: " . $parent->getOption('name') . ', Child: ' . $child->getOption('name') . PHP_EOL;
        echo "Data: ".PHP_EOL;
        print_r($child->getPropertyPath()->getElements());
        echo "=====================================".PHP_EOL;

        if ($child->getChildren()->count()) {
            $this->mapDataToElementCollection($child, $child->getChildren());
        }
    }

    /**
     * Maps data to children collection
     *
     * @param ElementInterface  $parent
     * @param ElementCollection $children
     */
    protected function mapDataToElementCollection(ElementInterface $parent)
    {
        foreach ($parent->getChildren()->all() as $child) {
            $this->mapDataToElement($parent, $child);
        }
    }
} 