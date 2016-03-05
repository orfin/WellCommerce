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

namespace WellCommerce\Bundle\ContactBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\AppBundle\Doctrine\ORM\Behaviours\AddressTrait;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;

/**
 * Class ContactTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTranslation implements LocaleAwareInterface
{
    use Translation;
    use AddressTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $businessHours;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getBusinessHours()
    {
        return $this->businessHours;
    }

    /**
     * @param string $businessHours
     */
    public function setBusinessHours($businessHours)
    {
        $this->businessHours = $businessHours;
    }

    /**
     * {@inheritdoc}
     */
    public function getCopyingSensitiveProperties()
    {
        return [
            'name',
        ];
    }
}
