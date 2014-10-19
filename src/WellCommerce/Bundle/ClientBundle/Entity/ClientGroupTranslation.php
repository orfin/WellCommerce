<?php

namespace WellCommerce\Bundle\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ClientGroupTranslation
 *
 * @ORM\Table(name="client_group_translation")
 * @ORM\Entity
 */
class ClientGroupTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Returns translation ID.
     *
     * @return integer The ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ClientGroupTranslation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.

     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

