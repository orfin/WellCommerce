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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractField;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class LayoutBoxesList
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxesList extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'boxes',
        ]);

        $resolver->setDefaults([
            'boxes' => []
        ]);

        $resolver->setAllowedTypes([
            'boxes' => 'array',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'aoBoxes'                     => $this->getOption('boxes')
        ];
    }
}
