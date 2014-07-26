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

namespace WellCommerce\Core\DataGrid\Configuration\EventHandler;

/**
 * Class DeleteGroupEventHandler
 *
 * @package WellCommerce\Core\DataGrid\Configuration\EventHandler
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
                {$this->options['callback']}(oRequest, GCallback(function(eEvent){
                    DataGrid.LoadData();
                    DataGrid.ClearSelection();
                }));
            };
            new GF_Alert(title, msg, func, true, params);
        };";
    }
} 