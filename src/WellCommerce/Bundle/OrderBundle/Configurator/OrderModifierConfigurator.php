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

namespace WellCommerce\Bundle\OrderBundle\Configurator;

use WellCommerce\Bundle\OrderBundle\Entity\OrderModifierInterface;

/**
 * Class OrderModifierConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderModifierConfigurator implements OrderModifierConfiguratorInterface
{
    private $name;
    private $description;
    private $isSubtraction;
    private $hierarchy;
    
    /**
     * OrderModifierConfigurator constructor.
     *
     * @param string $name
     * @param string $description
     * @param bool   $isSubtraction
     * @param int    $hierarchy
     */
    public function __construct(string $name, string $description, bool $isSubtraction, int $hierarchy)
    {
        $this->name          = $name;
        $this->description   = $description;
        $this->isSubtraction = $isSubtraction;
        $this->hierarchy     = $hierarchy;
    }
    
    public function configure(OrderModifierInterface $modifier)
    {
        $modifier->setName($this->name);
        $modifier->setDescription($this->description);
        $modifier->setSubtraction($this->isSubtraction);
        $modifier->setHierarchy($this->hierarchy);
    }
}
