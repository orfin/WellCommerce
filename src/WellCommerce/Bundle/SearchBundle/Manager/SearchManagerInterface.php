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
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Adapter\AdapterInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Interface SearchManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchManagerInterface
{
    public function search(IndexTypeInterface $indexType, Request $request) : array;

    public function getAdapter() : AdapterInterface;

    public function createDocument(EntityInterface $entity, IndexTypeInterface $indexType, string $locale) : DocumentInterface;

    public function addEntity(EntityInterface $entity, IndexTypeInterface $indexType, string $locale);

    public function updateEntity(EntityInterface $entity, IndexTypeInterface $indexType, string $locale);

    public function removeEntity(EntityInterface $entity, IndexTypeInterface $indexType, string $locale);

    public function getIndexType(string $type) : IndexTypeInterface;
}
