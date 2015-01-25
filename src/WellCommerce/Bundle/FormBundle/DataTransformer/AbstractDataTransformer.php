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

namespace WellCommerce\Bundle\FormBundle\DataTransformer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractDataTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataTransformer
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Constructor
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository = null)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->repository       = $repository;
    }

    /**
     * Returns current repository
     *
     * @return RepositoryInterface
     */
    protected function getRepository()
    {
        if (null === $this->repository) {
            throw new \LogicException('Repository was not set during class initialization.');
        }

        return $this->repository;
    }

    /**
     * Returns mapping information for class
     *
     * @param $class
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    protected function getClassMetadata($class)
    {
        $factory = $this->getRepository()->getMetadataFactory();
        if (!$factory->hasMetadataFor($class)) {
            throw new \InvalidArgumentException(sprintf('No metadata found for class "%s"', $class));
        }

        return $factory->getMetadataFor($class);
    }
}
