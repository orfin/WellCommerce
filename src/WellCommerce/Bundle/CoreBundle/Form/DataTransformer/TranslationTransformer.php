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

use Doctrine\Common\Collections\ArrayCollection;
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
     * Transforms entity collection to array containing only primary keys
     *
     * @param $collection
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
            $values[$field][$translation->getLocale()] = $this->propertyAccessor->getValue($translation, $field);
        }
    }

    /**
     * Transforms passed identifiers to collection of entities
     *
     * @param $ids
     *
     * @return ArrayCollection
     */
    public function reverseTransform($data)
    {
        $collection = new ArrayCollection();
        if (null == $ids) {
            return $collection;
        }
        foreach ($ids as $id) {
            $item = $this->repository->find($id);
            $collection->add($item);
        }

        return $collection;
    }

} 