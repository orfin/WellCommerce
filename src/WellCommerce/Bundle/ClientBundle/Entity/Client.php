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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as Behaviors;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ClientBundle\Repository\ClientRepository")
 */
class Client implements ClientInterface
{
    use Behaviors\Timestampable\Timestampable;
    use Behaviors\Blameable\Blameable;

    const ROLE_CLIENT = 'ROLE_CLIENT';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="decimal", precision=15, scale=4, nullable=true)
     */
    protected $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true, nullable=false)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=40)
     */
    protected $salt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ClientBundle\Entity\ClientAddress", mappedBy="client", cascade={"persist"}, orphanRemoval=true)
     */
    protected $addresses;

    /**
     * @var ClientGroup
     *
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ClientBundle\Entity\ClientGroup", inversedBy="clients")
     * @ORM\JoinColumn(name="client_group_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $group;

    /**
     * @var bool
     *
     * @ORM\Column(name="conditions_accepted", type="boolean")
     */
    protected $conditionsAccepted;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter_accepted", type="boolean")
     */
    protected $newsletterAccepted;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @inheritDoc
     */
    public function setDiscount($discount)
    {
        $this->discount = (float)$discount;
    }

    /**
     * @inheritDoc
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @inheritDoc
     */
    public function setAddresses(ArrayCollection $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @inheritDoc
     */
    public function addAddress(ClientAddress $address)
    {
        $this->addresses[] = $address;
    }

    /**
     * @return ClientGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @inheritDoc
     */
    public function setGroup(ClientGroup $clientGroup)
    {
        $this->group = $clientGroup;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string)$firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string)$lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        $this->email    = (string)$email;
        $this->username = (string)$email;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        if (strlen($password)) {
            $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        }
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = (string)$salt;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = (string)$username;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [
            self::ROLE_CLIENT
        ];
    }

    /**
     * @inheritDoc
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @inheritDoc
     */
    public function setPhone($phone)
    {
        $this->phone = (string)$phone;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) = unserialize($serialized);
    }

    /**
     * @inheritDoc
     */
    public function isEqualTo(UserInterface $user)
    {
        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->email !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isConditionsAccepted()
    {
        return $this->conditionsAccepted;
    }

    /**
     * @inheritDoc
     */
    public function setConditionsAccepted($conditionsAccepted)
    {
        $this->conditionsAccepted = (bool)$conditionsAccepted;
    }

    /**
     * @inheritDoc
     */
    public function isNewsletterAccepted()
    {
        return $this->newsletterAccepted;
    }

    /**
     * @inheritDoc
     */
    public function setNewsletterAccepted($newsletterAccepted)
    {
        $this->newsletterAccepted = (bool)$newsletterAccepted;
    }
}
