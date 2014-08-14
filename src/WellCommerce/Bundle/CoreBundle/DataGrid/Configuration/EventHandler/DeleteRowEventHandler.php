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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;

/**
 * Class DeleteRow
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DeleteRowEventHandler extends AbstractEventHandler implements EventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName()
    {
        return 'delete_row';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'function',
            'row_action',
            'context_action',
            'route'
        ]);

        $resolver->setDefaults([
            'function'       => OptionInterface::GF_NULL,
            'row_action'     => false,
            'context_action' => false,
            'route'          => false
        ]);

        $resolver->setAllowedTypes([
            'function'       => ['string', 'int'],
            'row_action'     => ['bool', 'string'],
            'context_action' => ['bool', 'string'],
            'route'          => ['bool', 'string'],
        ]);
    }

    public function getJavascriptFunction()
    {
        return "
        function {$this->options['function']}(dg, id) {
            var oRow = DataGrid.GetRow(id);
            var title = '{% trans %}Delete{% endtrans %}';
            var msg = '{% trans %}Are you sure to delete {% endtrans %} ' + oRow.name + '?';
            var params = {
                id: id
            };
            var func = function(p) {
                oRequest = {
                    id: p.id
                }
                DataGrid.MakeRequest(Routing.generate('{$this->options['route']}', {id: p.id}), {}, function(oData){
                    if(oData.success){
                        GMessage(oRow.name + ' successfully deleted');
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
        }";
    }
}