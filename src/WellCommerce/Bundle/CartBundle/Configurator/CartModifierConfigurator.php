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

namespace WellCommerce\Bundle\CartBundle\Configurator;

use WellCommerce\Bundle\CartBundle\Entity\CartModifierInterface;

/**
 * Class CartModifierConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartModifierConfigurator implements CartModifierConfiguratorInterface
{
    private $name;
    private $description;
    private $isSubtraction;
    private $hierarchy;

    /**
     * CartModifierConfigurator constructor.
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

    /**
     * {@inheritdoc}
     */
    public function configure(CartModifierInterface $cartModifier)
    {
        $cartModifier->setName($this->name);
        $cartModifier->setDescription($this->description);
        $cartModifier->setSubtraction($this->isSubtraction);
        $cartModifier->setHierarchy($this->hierarchy);
    }
}
