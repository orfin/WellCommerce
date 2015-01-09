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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Transformer;

/**
 * Class DateTransformer
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet\Transformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTransformer implements TransformerInterface
{
    /**
     * @var null
     */
    protected $format;

    /**
     * Constructor
     *
     * @param $format
     */
    public function __construct($format = null)
    {
        $this->format = $format;
    }

    /**
     * Formats passed DateTime object to format
     *
     * @param string $value
     *
     * @return string
     */

    public function transform($value)
    {
        if (!$value instanceof \DateTime) {
            throw new \InvalidArgumentException('DateTransformer expects valid DateTime object');
        }

        if (false === $date = $this->formatDate($value)) {
            return $value;
        }

        return $date;
    }

    private function formatDate(\DateTime $date)
    {
        if (null === $this->format) {
            $locale = \Locale::getDefault();
            $ftm    = new \IntlDateFormatter($locale, \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);

            return $ftm->format($date);
        }

        return $date->format($this->format);
    }
} 