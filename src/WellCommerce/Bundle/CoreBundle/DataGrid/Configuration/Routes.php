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

/**
 * Class Routes
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Routes extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
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