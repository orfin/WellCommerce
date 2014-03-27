<?php

/**
 * WellCommerce, Open Source E-Commerce Solution
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 *
 * @package     WellCommerce\Core\Template
 * @subpackage  WellCommerce\Core\Template\Extension
 * @author      Adam Piotrowski <adam@wellcommerce.org>
 * @copyright   Copyright (c) 2008-2014 WellCommerce sp. z o.o. (http://www.gekosale.com)
 */
namespace WellCommerce\Core\Template\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

class DataGrid extends \Twig_Extension
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('datagrid_renderer', array(
                $this,
                'render'
            ), array(
                'is_safe' => Array(
                    'html'
                )
            ))
        );
    }

    public function render(DataGridInterface $dataGrid)
    {
        $columns = $dataGrid->getColumns();

        return $this->container->get('twig')->render('datagrid.twig', [
            'datagrid_options'      => $dataGrid->getOptions(),
            'datagrid_columns'      => $columns
        ]);
    }

    public function getName()
    {
        return 'datagrid_renderer';
    }
}
