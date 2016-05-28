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

namespace WellCommerce\Bundle\SearchBundle\Converter;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\SearchBundle\Document\Document;
use WellCommerce\Bundle\SearchBundle\Document\DocumentField;
use WellCommerce\Bundle\SearchBundle\Document\DocumentFieldCollection;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeFieldInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class EntityConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityConverter implements EntityConverterInterface
{
    public function convert(EntityInterface $entity, IndexTypeInterface $type, string $locale) : DocumentInterface
    {
        $language = new ExpressionLanguage();
        $fields   = new DocumentFieldCollection();
        
        $type->getFields()->map(function (IndexTypeFieldInterface $indexTypeField) use ($entity, $fields, $language, $locale) {
            $fields->add(new DocumentField(
                $indexTypeField->getName(),
                $this->getFieldValue($entity, $locale, $indexTypeField->getPathExpression(), $language),
                $indexTypeField->isIndexable(),
                $indexTypeField->getBoost()
            ));
        });
        
        return new Document($entity->getId(), $type, $fields, $locale);
    }

    private function getFieldValue(EntityInterface $entity, string $locale, string $expression, ExpressionLanguage $language) : string
    {
        $value = $language->evaluate($expression, [
            'resource' => $entity,
            'locale'   => $locale
        ]);

        return $value ?? '';
    }
}
