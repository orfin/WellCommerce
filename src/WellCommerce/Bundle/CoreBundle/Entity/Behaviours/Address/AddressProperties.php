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

namespace WellCommerce\Bundle\CoreBundle\Entity\Behaviours\Address;

/**
 * Class AddressProperties
 *
 * @package WellCommerce\Bundle\CoreBundle\Entity\Behaviours\Address
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait AddressProperties
{
    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="street_no", type="string", length=255, nullable=true)
     */
    private $streetNo;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_no", type="string", length=255, nullable=true)
     */
    private $flatNo;

    /**
     * @var string
     *
     * @ORM\Column(name="post_code", type="string", length=255, nullable=true)
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=true)
     */
    private $country;
} 