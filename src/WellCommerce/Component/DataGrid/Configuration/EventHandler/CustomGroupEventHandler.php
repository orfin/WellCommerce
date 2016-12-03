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

namespace WellCommerce\Component\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomGroupEventHandler
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CustomGroupEventHandler extends AbstractEventHandler
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName() : string
    {
        return $this->get('group_action');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setRequired([
            'group_action',
        ]);
        
        $resolver->setAllowedTypes('group_action', ['bool', 'string']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function isCustomEvent() : bool
    {
        return true;
    }
}
