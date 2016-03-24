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

namespace WellCommerce\Bundle\SearchBundle\Indexer;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Manager\SearchIndexManagerInterface;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;

/**
 * Class LuceneProductIndexer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LuceneProductIndexer implements ProductIndexerInterface
{
    /**
     * @var SearchIndexManagerInterface
     */
    protected $searchIndexManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * LuceneProductIndexer constructor.
     *
     * @param SearchIndexManagerInterface $searchIndexManager
     */
    public function __construct(SearchIndexManagerInterface $searchIndexManager, ProductRepositoryInterface $productRepository)
    {
        $this->searchIndexManager = $searchIndexManager;
        $this->productRepository  = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product, $indexName = ProductIndexerInterface::DEFAULT_INDEX_NAME)
    {
        $index = $this->searchIndexManager->getIndex(ProductIndexerInterface::DEFAULT_INDEX_NAME);

        $document = new Document();
        $document->addField(Field::unIndexed('identifier', $product->getId()));
        $document->addField(Field::text('name', $product->translate('en')->getName()));
        $document->addField(Field::text('shortDescription', $product->translate()->getShortDescription()));
        $document->addField(Field::text('description', $product->translate()->getDescription()));
        $index->addDocument($document);
        $index->commit();
    }

    public function reindexProducts()
    {
        $products = $this->productRepository->findAll();
        $this->searchIndexManager->eraseIndex(ProductIndexerInterface::DEFAULT_INDEX_NAME);

        foreach ($products as $product) {
            $this->addProduct($product);
        }

        $index = $this->searchIndexManager->getIndex(ProductIndexerInterface::DEFAULT_INDEX_NAME);
        $index->optimize();
    }
}
