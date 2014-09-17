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
namespace WellCommerce\Bundle\ProductBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class ProductAttributeRepository
 *
 * @package WellCommerce\Bundle\ProductBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeRepository extends AbstractEntityRepository implements ProductAttributeRepositoryInterface
{
    /**
     * Returns availability entity by passed id
     *
     * @param $id
     *
     * @return mixed
     */
    private function getAvailability($id)
    {
        $repository = $this->getRepository('WellCommerce\Bundle\AvailabilityBundle\Entity\Availability');

        return $repository->find($id);
    }

    /**
     * Prepares collection from passed attribute values
     *
     * @param $values
     *
     * @return ArrayCollection
     */
    private function makeAttributeValuesCollection($values)
    {
        $collection = new ArrayCollection();
        $repository = $this->getRepository('WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue');
        foreach ($values as $value) {
            $item = $repository->find($value);
            if (null !== $item) {
                $collection->add($item);
            }
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function findOrCreate($id, $data)
    {
        /**
         * @var $attribute \WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute
         */
        $attribute = $this->find($id);
        if (null === $attribute) {
            $attribute = $this->createNew();
        }

        $attribute->setModifierType($data['suffix']);
        $attribute->setModifierValue($data['modifier']);
        $attribute->setStock($data['stock']);
        $attribute->setSymbol($data['symbol']);
        $attribute->setWeight($data['weight']);
        $attribute->setSellPrice(0);
        $attribute->setAvailability($this->getAvailability($data['availability']));
        $attribute->setAttributeValues($this->makeAttributeValuesCollection($data['attributes']));

        return $attribute;
    }

}
