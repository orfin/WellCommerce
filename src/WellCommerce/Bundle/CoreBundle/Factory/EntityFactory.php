<?php
/**
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

use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Class EntityFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class EntityFactory implements EntityFactoryInterface
{
    /**
     * @var string
     */
    private $class;
    
    /**
     * EntityFactory constructor.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }
    
    public function create(): EntityInterface
    {
        return new $this->class;
    }
}