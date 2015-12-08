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

namespace WellCommerce\Bundle\LocaleBundle\Form\DataTransformer;

use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\AbstractDataTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\RepositoryAwareDataTransformerInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;

/**
 * Class TranslationTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class TranslationTransformer extends AbstractDataTransformer implements RepositoryAwareDataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $values = [];

        if ($modelData instanceof PersistentCollection) {
            $mapping  = $modelData->getMapping();
            $metaData = $this->getClassMetadata($mapping['targetEntity']);
            $fields   = $metaData->getFieldNames();

            foreach ($modelData as $translation) {
                $this->transformTranslation($translation, $fields, $values);
            }
        }

        return $values;
    }

    /**
     * Transforms single translation
     *
     * @param LocaleAwareInterface $translation
     * @param array                $fields
     * @param array                $values
     */
    protected function transformTranslation(LocaleAwareInterface $translation, $fields, &$values)
    {
        foreach ($fields as $field) {
            $values[$translation->getLocale()][$field] = $this->propertyAccessor->getValue($translation, $field);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        foreach ($value as $locale => $fields) {
            $translation = $modelData->translate($locale);
            foreach ($fields as $fieldName => $fieldValue) {
                $this->propertyAccessor->setValue($translation, $fieldName, $fieldValue);
            }
        }

        $modelData->mergeNewTranslations();
    }
}
