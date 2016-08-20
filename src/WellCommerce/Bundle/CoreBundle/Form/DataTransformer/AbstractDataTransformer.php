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

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractDataTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataTransformer implements RepositoryAwareDataTransformerInterface
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
     * @var DoctrineHelperInterface
     */
    private $doctrineHelper;

    /**
     * Constructor
     *
     * @param DoctrineHelperInterface|null $doctrineHelper
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper = null)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->doctrineHelper   = $doctrineHelper;
    }

    /**
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns current repository
     *
     * @return RepositoryInterface
     */
    protected function getRepository() : RepositoryInterface
    {
        if (null === $this->repository) {
            throw new \LogicException('Repository was not set during class initialization.');
        }

        return $this->repository;
    }

    /**
     * Returns the Doctrine helper
     *
     * @return DoctrineHelperInterface
     */
    protected function getDoctrineHelper() : DoctrineHelperInterface
    {
        if (null === $this->doctrineHelper) {
            throw new \LogicException('Doctrine helper was not set during class initialization.');
        }

        return $this->doctrineHelper;
    }

    /**
     * Returns mapping information for class
     *
     * @param string $class
     *
     * @return ClassMetadata
     */
    protected function getClassMetadata(string $class) : ClassMetadata
    {
        $factory = $this->getDoctrineHelper()->getMetadataFactory();
        if (!$factory->hasMetadataFor($class)) {
            throw new \InvalidArgumentException(sprintf('No metadata found for class "%s"', $class));
        }

        return $factory->getMetadataFor($class);
    }
}
