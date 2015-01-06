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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;

/**
 * Class TranslationTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class TranslationTransformer implements DataTransformerInterface
{
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Constructor
     *
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper)
    {
        $this->doctrineHelper   = $doctrineHelper;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function transform($modelData, PropertyPathInterface $propertyPath)
    {
        $values = [];

        if ($modelData instanceof PersistentCollection) {
            $mapping  = $modelData->getMapping();
            $metaData = $this->doctrineHelper->getClassMetadata($mapping['targetEntity']);
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