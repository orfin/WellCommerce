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

use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
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
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Shortcut to get any service from container
     *
     * @param $id
     *
     * @return object
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function get($id)
    {
        if (!$this->container->has($id)) {
            throw new ServiceNotFoundException($id);
        }

        return $this->container->get($id);
    }

    /**
     * Returns current locale from request
     */
    public function getCurrentLocale()
    {
        return $this->container->get('request')->getLocale();
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
    public function updateRow(array $request)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMultipleRows(array $ids)
    {
        return false;
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

    public function getName()
    {
        return $this->getEntityName();
    }


}