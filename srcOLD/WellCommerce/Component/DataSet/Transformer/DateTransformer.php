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

namespace WellCommerce\Component\DataSet\Transformer;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DateTransformer extends AbstractDataSetTransformer
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'format'
        ]);

        $resolver->setDefaults([
            'format' => 'Y-m-d'
        ]);

        $resolver->setAllowedTypes('format', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function transformValue($value)
    {
        if (null === $value) {
            return $value;
        }

        if (!$value instanceof \DateTime) {
            throw new \InvalidArgumentException('DateTransformer expects valid DateTime object or null value');
        }

        if (false === $date = $this->formatDate($value)) {
            return $value;
        }

        return $date;
    }

    private function formatDate(\DateTime $date)
    {
        if (null === $this->options['format']) {
            $locale = \Locale::getDefault();
            $ftm    = new \IntlDateFormatter($locale, \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);

            return $ftm->format($date);
        }

        return $date->format($this->options['format']);
    }
}
