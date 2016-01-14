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

namespace WellCommerce\Bundle\CoreBundle\Factory;

/**
 * Class AbstractFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected $supportsInterface;

    /**
     * @var string
     */
    protected $className;

    /**
     * AbstractFactory constructor.
     *
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function create();

    /**
     * @return object
     */
    protected function init()
    {
        if (!$this->isSupported()) {
            throw new \LogicException(sprintf(
                'Factory "%s" supports only instances of "%s". "%s" given',
                get_class($this),
                $this->supportsInterface,
                $this->className
            ));
        }

        return new $this->className;
    }

    /**
     * Checks whether the factory supports given entity class
     *
     * @return bool
     */
    protected function isSupported()
    {
        $rc = new \ReflectionClass($this->className);

        return $rc->implementsInterface($this->supportsInterface);
    }
}
