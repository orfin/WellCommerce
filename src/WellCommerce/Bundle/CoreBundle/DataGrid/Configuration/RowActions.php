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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class RowActions
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RowActions extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'actions',
        ]);

        $resolver->setDefaults([
            'actions' => [
                DataGridInterface::ACTION_EDIT,
                DataGridInterface::ACTION_DELETE,
            ]
        ]);

        $resolver->setAllowedTypes([
            'actions' => 'array'
        ]);
    }

    public function __toString()
    {
        return implode(",\n", $this->options['actions']);
    }
} 