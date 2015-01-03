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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Fieldset;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class RepeatableFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class RepeatableFieldset extends AbstractFieldset implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'repeat_min',
            'repeat_max',
        ]);

        $resolver->setAllowedTypes([
            'repeat_min' => ['numeric'],
            'repeat_max' => ['numeric'],
        ]);
    }

    protected function formatRepeatableJs()
    {
        $min = $this->options['repeat_min'];
        $max = $this->options['repeat_max'];

        return "oRepeat: {iMin: {$min}, iMax: {$max}}";
    }

    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'oRepeat' => [
                'iMin' => $this->options['repeat_min'],
                'iMax' => $this->options['repeat_max'],
            ]
        ];
    }
}
