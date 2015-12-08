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

namespace WellCommerce\Component\Form\DataTransformer;

use DateTime;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Class DateTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTransformer implements DataTransformerInterface
{
    /**
     * @var string Date format
     */
    private $format;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * Constructor
     *
     * @param $format
     */
    public function __construct($format)
    {
        $this->format           = $format;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Transforms date object to string using given format
     *
     * @param DateTime|string $dateTime
     *
     * @return string
     */
    public function transform($modelData)
    {
        if ($modelData instanceof DateTime) {
            return $modelData->format($this->format);
        }

        return null;
    }

    /**
     * Transforms date string to DateTime object
     *
     * @param object                $modelData
     * @param PropertyPathInterface $propertyPath
     * @param mixed                 $value
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        if (false === $date = $this->createDateFromString($value)) {
            $date = null;
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $date);
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
