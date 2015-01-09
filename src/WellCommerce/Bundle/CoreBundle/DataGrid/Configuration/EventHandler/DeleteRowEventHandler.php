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

/**
 * Class DeleteRow
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DeleteRowEventHandler extends AbstractRowEventHandler implements EventHandlerInterface
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