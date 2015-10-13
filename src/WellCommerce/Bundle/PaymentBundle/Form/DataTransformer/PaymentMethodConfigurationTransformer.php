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

namespace WellCommerce\Bundle\PaymentBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\FormBundle\DataTransformer\DataTransformerInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodConfigurationInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\PaymentBundle\Factory\PaymentMethodConfigurationFactory;

/**
 * Class PaymentMethodConfigurationCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodConfigurationTransformer extends CollectionToArrayTransformer implements DataTransformerInterface
{
    /**
     * @var PaymentMethodConfigurationFactory
     */
    protected $factory;

    /**
     * @param PaymentMethodConfigurationFactory $factory
     */
    public function setFactory(PaymentMethodConfigurationFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $items = [];
        if ($modelData instanceof Collection) {
            $modelData->map(function (PaymentMethodConfigurationInterface $configuration) use (&$items) {
                $items[$configuration->getName()] = $configuration->getValue();
            });
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        $em                 = $this->getDoctrineHelper()->getEntityManager();
        $collection         = $this->createConfigurationCollection($modelData, $values);
        $previousCollection = $this->propertyAccessor->getValue($modelData, $propertyPath);

        foreach ($previousCollection as $oldEntity) {
            $em->remove($oldEntity);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }

    /**
     * Creates and filters the configuration collection
     *
     * @param object|PaymentMethodInterface $paymentMethod
     * @param array                         $values
     *
     * @return Collection|static
     */
    protected function createConfigurationCollection(PaymentMethodInterface $paymentMethod, array $values = [])
    {
        $processor  = $paymentMethod->getProcessor();
        $collection = new ArrayCollection();
        foreach ($values as $name => $value) {
            $configuration = $this->factory->create();
            $configuration->setName($name);
            $configuration->setPaymentMethod($paymentMethod);
            $configuration->setValue($value);
            $collection->add($configuration);
        }

        return $collection->filter(function (PaymentMethodConfigurationInterface $configuration) use ($processor) {
            return substr($configuration->getName(), 0, strlen($processor)) === $processor;
        });
    }
}
