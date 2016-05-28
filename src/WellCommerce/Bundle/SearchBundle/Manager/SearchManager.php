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

namespace WellCommerce\Bundle\SearchBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\SearchBundle\Converter\EntityConverterInterface;
use WellCommerce\Bundle\SearchBundle\Storage\SearchResultStorage;
use WellCommerce\Bundle\SearchBundle\Adapter\AdapterInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Exception\IndexTypeNotFoundException;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeCollection;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class SearchManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchManager implements SearchManagerInterface
{
    /**
     * @var IndexTypeCollection
     */
    private $indexTypes;
    
    /**
     * @var SearchResultStorage
     */
    private $storage;
    
    /**
     * @var EntityConverterInterface
     */
    private $converter;
    
    /**
     * @var AdapterInterface
     */
    private $adapter;
    
    /**
     * SearchManager constructor.
     *
     * @param IndexTypeCollection      $indexTypes
     * @param SearchResultStorage      $storage
     * @param EntityConverterInterface $converter
     * @param AdapterInterface         $adapter
     */
    public function __construct(
        IndexTypeCollection $indexTypes,
        SearchResultStorage $storage,
        EntityConverterInterface $converter,
        AdapterInterface $adapter
    ) {
        $this->indexTypes = $indexTypes;
        $this->storage    = $storage;
        $this->converter  = $converter;
        $this->adapter    = $adapter;
    }
    
    public function search(IndexTypeInterface $indexType, Request $request) : array
    {
    }
    
    public function getAdapter() : AdapterInterface
    {
        return $this->adapter;
    }

    public function createDocument(EntityInterface $entity, IndexTypeInterface $indexType, string $locale) : DocumentInterface
    {
        return $this->converter->convert($entity, $indexType, $locale);
    }

    public function addEntity(EntityInterface $entity, IndexTypeInterface $indexType, string $locale)
    {
        return $this->adapter->addDocument($this->createDocument($entity, $indexType, $locale));
    }

    public function updateEntity(EntityInterface $entity, IndexTypeInterface $indexType, string $locale)
    {
        return $this->adapter->updateDocument($this->createDocument($entity, $indexType, $locale));
    }

    public function removeEntity(EntityInterface $entity, IndexTypeInterface $indexType, string $locale)
    {
        return $this->adapter->removeDocument($this->createDocument($entity, $indexType, $locale));
    }
    
    public function getIndexType(string $type) : IndexTypeInterface
    {
        if (false === $this->indexTypes->containsKey($type)) {
            throw new IndexTypeNotFoundException($type, $this->indexTypes->getKeys());
        }
        
        return $this->indexTypes->get($type);
    }
}
