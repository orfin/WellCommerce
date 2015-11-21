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

namespace WellCommerce\CoreBundle\Component\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\CoreBundle\Component\DataGrid\Configuration\OptionInterface;

/**
 * Class Load
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadEventHandler extends AbstractEventHandler
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName()
    {
        return 'load';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'route',
        ]);

        $resolver->setDefaults([
            'route' => OptionInterface::GF_NULL,
        ]);

        $resolver->setAllowedTypes([
            'route' => ['string'],
        ]);
    }
}
