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
     * Transforms translations collection
     *
     * @param $translations
     *
     * @return array
     */
    public function transform($translations)
    {
        $values = [];

        if ($translations instanceof PersistentCollection) {
            $mapping  = $translations->getMapping();
            $metaData = $this->doctrineHelper->getClassMetadata($mapping['targetEntity']);
            $fields   = $metaData->getFieldNames();

            foreach ($translations as $translation) {
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
     * Transforms translations to model representation
     *
     * @param array  $values
     * @param object $modelData
     */
    public function reverseTransform($values, $modelData)
    {
        foreach ($values as $locale => $fields) {
            $translation = $modelData->translate($locale);
            foreach ($fields as $fieldName => $fieldValue) {
                $this->propertyAccessor->setValue($translation, $fieldName, $fieldValue);
            }
        }

        $modelData->mergeNewTranslations();
    }

} 