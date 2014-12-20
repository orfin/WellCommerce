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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

use DateTime;

/**
 * Class DateTransformer
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTransformer implements DataTransformerInterface
{
    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * Transforms date object to string using given format
     *
     * @param $dateTime
     *
     * @return mixed
     */
    public function transform($dateTime)
    {
        if ($dateTime instanceof DateTime) {
            $dateTime->format($this->format);
        }

        return $dateTime;
    }

    /**
     * Transforms date string to DateTime object
     *
     * @param $date
     *
     * @return DateTime|object
     */
    public function reverseTransform($date)
    {
        $date = DateTime::createFromFormat($this->format, $date);

        return $date;
    }
} 