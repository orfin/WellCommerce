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

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class LanguageFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LanguageFieldset extends RepeatableFieldset implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'languages',
        ]);

        $count = function (Options $options) {
            return count($options['name']);
        };

        $resolver->setDefaults([
            'languages'  => [],
            'repeat_min' => $count,
            'repeat_max' => $count,
        ]);

        $resolver->setAllowedTypes([
            'languages' => 'array',
        ]);
    }

    /**
     * Formats field javascript
     *
     * @return string
     */
    protected function formatLanguagesJs()
    {
        $options = [];
        foreach ($this->getLanguages() as $language) {
            $value     = addslashes($language['code']);
            $label     = addslashes($language['code']);
            $flag      = addslashes(sprintf('%s.png', substr($label, 0, 2)));
            $options[] = "{sValue: '{$value}', sLabel: '{$label}',sFlag: '{$flag}' }";
        }

        return 'aoLanguages: [' . implode(', ', $options) . ']';
    }

    /**
     * Returns languages set as fieldset option
     *
     * @return array
     */
    protected function getLanguages()
    {
        return $this->options['languages'];
    }
}
