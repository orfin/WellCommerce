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

namespace WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\OptionInterface;

/**
 * Class DeleteGroupEventHandler
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DeleteGroupEventHandler extends AbstractEventHandler implements EventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName()
    {
        return 'delete_group';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'function',
            'route',
            'group_action',
        ]);

        $resolver->setDefaults([
            'function'     => OptionInterface::GF_NULL,
            'route'        => false,
            'group_action' => false,
        ]);

        $resolver->setAllowedTypes([
            'function'     => ['string', 'int'],
            'route'        => ['bool', 'string'],
            'group_action' => ['bool', 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getJavascriptFunction()
    {
        return "
        function {$this->options['function']}(dg, ids) {
            var title = '{% trans %}Delete{% endtrans %}';
            var msg = '{% trans %}Are you sure to delete {% endtrans %} ' + ids.join(', ') + '?';
            var params = {
                dg: dg,
                ids: ids
            };
            var func = function(p) {
                oRequest = {
                    ids: p.ids
                }
                DataGrid.MakeRequest(Routing.generate('{$this->options['route']}', {ids: p.ids}), {}, function(oData){
                    if(oData.success){
                        GMessage(p.ids + ' successfully deleted');
                        DataGrid.LoadData();
                        DataGrid.ClearSelection();
                    }
                    if(oData.error){
                        GError(oData.error);
                        DataGrid.ClearSelection();
                    }
                });
            };
            new GF_Alert(title, msg, func, true, params);
        };";
    }
} 