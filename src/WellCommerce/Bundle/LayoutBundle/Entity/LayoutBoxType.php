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

namespace WellCommerce\Bundle\LayoutBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\EnableableTrait;

/**
 * LayoutBox
 *
 * @ORM\Table("layout_box_type")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\LayoutBundle\Repository\LayoutBoxTypeRepository")
 */
class LayoutBoxType
{
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="vendor", type="string", length=255)
     */
    private $vendor;

    /**
     * @var string
     *
     * @ORM\Column(name="configurator_service", type="string", nullable=true, length=255)
     */
    private $configuratorService;

    /**
     * @var string
     *
     * @ORM\Column(name="controller_service", type="string", nullable=true, length=255)
     */
    private $controllerService;

    /**
     * Returns box type identifier
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns box type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets box type
     *
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Sets box type vendor
     *
     * @param $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Returns box type vendor
     *
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Sets configurator service name
     *
     * @param $configuratorService
     */
    public function setConfiguratorService($configuratorService)
    {
        $this->configuratorService = $configuratorService;
    }

    /**
     * Returns configurator service name
     *
     * @return string
     */
    public function getConfiguratorService()
    {
        return $this->configuratorService;
    }

    /**
     * Returns name of controller service
     *
     * @return string
     */
    public function getControllerService()
    {
        return $this->controllerService;
    }

    /**
     * Sets name of controller service
     *
     * @param string $controllerService
     */
    public function setControllerService($controllerService)
    {
        $this->controllerService = $controllerService;
    }
}
