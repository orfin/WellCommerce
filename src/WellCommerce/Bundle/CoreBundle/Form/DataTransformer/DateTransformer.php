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
    /**
     * @var string Date format
     */
    private $format;

    /**
     * Constructor
     *
     * @param $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * Transforms date object to string using given format
     *
     * @param DateTime|string $dateTime
     *
     * @return string
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
     * @param $value
     *
     * @return DateTime|object
     */
    public function reverseTransform($value)
    {
        if (false === $date = $this->createDateFromString($value)) {
            throw new \InvalidArgumentException(sprintf('Passed date "%s" is not a string.', $value));
        }

        return $date;
    }

    /**
     * Creates DateTime from string
     *
     * @param $date
     *
     * @return DateTime|false
     */
    private function createDateFromString($date)
    {
        return DateTime::createFromFormat($this->format, $date);
    }
} 