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

namespace WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;

/**
 * Class RowActions
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RowActions extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
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