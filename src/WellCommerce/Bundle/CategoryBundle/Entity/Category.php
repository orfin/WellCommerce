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

namespace WellCommerce\Bundle\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Knp\DoctrineBehaviors\Model\Tree\Node;
use Knp\DoctrineBehaviors\Model\Tree\NodeInterface;

/**
 * Class Category
 *
 * @package WellCommerce\Bundle\CategoryBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table("category")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepository")
 */
class Category implements NodeInterface, \ArrayAccess
{
    use Node,
        Translatable,
        Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="hierarchy", type="integer", options={"default" = 0})
     */
    private $hierarchy;

    /**
     * @param  string
     *
     * @return null
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getHierarchy()
    {
        return $this->hierarchy;
    }

    public function setHierarchy($hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }


}

