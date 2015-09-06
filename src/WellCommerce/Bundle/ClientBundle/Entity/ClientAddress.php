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
namespace WellCommerce\Bundle\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;

/**
 * Client
 *
 * @ORM\Table(name="client_address")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ClientBundle\Repository\ClientAddressRepository")
 */
class ClientAddress implements ClientAwareInterface
{
    use Timestampable;
    use Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ClientInterface
     *
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ClientBundle\Entity\Client", inversedBy="addresses")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    protected $client;

    /**
     * @var AddressInterface
     *
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Address", columnPrefix = "address_")
     */
    protected $address;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client = null)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;
    }
}
