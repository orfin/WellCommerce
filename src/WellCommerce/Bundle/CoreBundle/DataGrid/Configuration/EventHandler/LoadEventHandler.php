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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;

/**
 * Class Load
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadEventHandler extends AbstractEventHandler implements EventHandlerInterface
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'function',
            'route',
        ]);

        $resolver->setDefaults([
            'function' => OptionInterface::GF_NULL,
            'route'    => OptionInterface::GF_NULL,
        ]);

        $resolver->setAllowedTypes([
            'function' => ['string'],
            'route'    => ['string'],
        ]);
    }

    public function getJavascriptFunction()
    {
        return "
        function {$this->options['function']}(oRequest) {
            DataGrid.MakeRequest(Routing.generate('{$this->options['route']}'), oRequest, GF_Datagrid.ProcessIncomingData);
        }";
    }
}