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

namespace WellCommerce\Bundle\CoreBundle\Repository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Interface RepositoryInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RepositoryInterface
{
    /**
     * Creates new entity
     *
     * @return \Doctrine\Entity
     */
    public function createNew();

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias);

    /**
     * Returns entity alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns entities name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns property accessor
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    public function getPropertyAccessor();

    /**
     * Returns a resource for given primary key
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Returns all available and configured locales
     *
     * @return array
     */
    public function getLocales();

    /**
     * Returns current repository locale
     *
     * @return null|string
     */
    public function getCurrentLocale();

    /**
     * Sets translator service
     *
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator);

    /**
     * Builds and executes query to fetch collection of items to use in optioned fields
     *
     * @param $identifier
     * @param $labelField
     * @param $targetClass
     * @param $tableName
     * @param $associationTableName
     *
     * @return array
     */
    public function getCollection($identifier, $labelField, $targetClass, $tableName, $associationTableName);

    /**
     * Returns collection prepared to use in optioned form fields
     *
     * @param string $labelField
     *
     * @return array
     */
    public function getCollectionToSelect($labelField = 'name');

} 