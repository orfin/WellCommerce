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

/**
 * Class Routes
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Routes extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional([
            'grid',
            'add',
            'edit',
            'delete',
        ]);

        $resolver->setAllowedTypes([
            'grid'   => 'string',
            'add'    => 'string',
            'edit'   => 'string',
            'delete' => 'string',
        ]);
    }
}