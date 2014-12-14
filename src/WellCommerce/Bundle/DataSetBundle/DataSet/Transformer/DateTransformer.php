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

namespace WellCommerce\Bundle\DataSetBundle\DataSet\Transformer;

/**
 * Class DateTransformer
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\Transformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTransformer implements TransformerInterface
{
    /**
     * Formats passed DateTime object to format
     * @param $value
     *
     * @return bool|string
     */
    public function transform($value)
    {
        if (!$value instanceof \DateTime) {
            throw new \InvalidArgumentException('DateTransformer expects valid DateTime object');
        }
        $locale = \Locale::getDefault();
        $ftm    = new \IntlDateFormatter($locale, \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);

        return $ftm->format($value);
    }
} 