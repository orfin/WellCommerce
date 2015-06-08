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
namespace WellCommerce\Bundle\CoreBundle\Twig;

use WellCommerce\Bundle\CoreBundle\Entity\Address;
use WellCommerce\Bundle\CoreBundle\Entity\ContactDetails;

/**
 * Class AddressFormatterExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AddressFormatterExtension extends \Twig_Extension
{
    const LINES_SEPARATOR = '<br />';

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('format_address', [$this, 'formatAddress'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('format_contact_details', [$this, 'formatContactDetails'],
                ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'address_formatter';
    }

    /**
     * Formats address as html
     *
     * @param Address $address
     * @param string  $lineSeparator
     *
     * @return string
     */
    public function formatAddress(Address $address, $lineSeparator = self::LINES_SEPARATOR)
    {
        $lines   = [];
        $lines[] = sprintf('%s %s', $address->getFirstName(), $address->getLastName());
        $lines[] = sprintf('%s %s%s', $address->getStreet(), $address->getStreetNo(), '/' . $address->getFlatNo());
        $lines[] = sprintf('%s, %s %s', $address->getCountry(), $address->getPostCode(), $address->getCity());

        return implode($lineSeparator, $lines);
    }

    /**
     * Formats contact details as html
     *
     * @param ContactDetails $details
     * @param string         $lineSeparator
     *
     * @return string
     */
    public function formatContactDetails(ContactDetails $details, $lineSeparator = self::LINES_SEPARATOR)
    {
        $lines   = [];
        $lines[] = $details->getPhone();
        $lines[] = $details->getSecondaryPhone();
        $lines[] = $details->getEmail();

        return implode($lineSeparator, $lines);
    }
}
