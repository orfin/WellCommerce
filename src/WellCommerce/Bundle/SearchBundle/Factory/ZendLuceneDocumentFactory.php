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

namespace WellCommerce\Bundle\SearchBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\SearchBundle\Context\DocumentContextInterface;
use WellCommerce\Bundle\SearchBundle\Model\SearchField;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;

/**
 * Class ZendLuceneDocumentFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ZendLuceneDocumentFactory implements DocumentFactoryInterface
{
    /**
     * @var string
     */
    private $contextClass;
    
    /**
     * ZendLuceneDocumentFactory constructor.
     *
     * @param string $contextClass
     */
    public function __construct(string $contextClass)
    {
        $this->contextClass = $contextClass;
    }
    
    public function createDocument(EntityInterface $entity) : Document
    {
        $document         = new Document();
        $context          = $this->createContext($entity);
        $fieldsCollection = $context->getFieldsCollection();

        $document->addField(Field::unIndexed('identifier', $entity->getId()));

        $fieldsCollection->map(function (SearchField $field) use ($document) {
            $document->addField(Field::text($field->getName(), $field->getValue()));
        });

        return $document;
    }

    private function createContext(EntityInterface $entity) : DocumentContextInterface
    {
        return new $this->contextClass($entity);
    }
}
