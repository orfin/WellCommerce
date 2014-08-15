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

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class AbstractEntityRepository
 *
 * @package WellCommerce\Bundle\CoreBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEntityRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @var string Current locale
     */
    private $currentLocale = null;

    /**
     * Sets current locale for repository
     *
     * @param $currentLocale
     */
    public function setCurrentLocale($currentLocale)
    {
        $this->currentLocale = $currentLocale;
    }

    /**
     * Returns current repository locale
     *
     * @return null|string
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $entity = $this->getClassName();

        return new $entity;
    }

    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRow($id)
    {
        $entity = $this->find($id);
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        $parts      = explode('\\', $this->getEntityName());
        $entityName = end($parts);

        return Helper::snake($entityName);
    }

    /**
     * Returns entity name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getEntityName();
    }

    /**
     * Resolves request parameters and tries to find corresponding entity
     *
     * @param Request $request
     * @param array   $criteria
     *
     * @return mixed|null|object
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function findResource(Request $request, array $criteria = [])
    {
        $params = [];
        if ($request->attributes->has('id')) {
            $params = [
                'id' => $request->attributes->get('id')
            ];
        }
        if ($request->attributes->has('slug')) {
            $params = [
                'slug' => $request->attributes->get('slug')
            ];
        }

        $criteria = array_merge($params, $criteria);

        if (!$resource = $this->findOneBy($criteria)) {
            throw new EntityNotFoundException($this->getEntityName());
        }

        return $resource;
    }
}