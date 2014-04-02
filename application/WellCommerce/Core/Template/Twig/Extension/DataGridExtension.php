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
namespace WellCommerce\Core\Template\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;

/**
 * Class DataGridExtension
 *
 * Provides DataGrid rendering function in Twig
 *
 * @package WellCommerce\Core\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridExtension extends \Twig_Extension
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
            'datagrid_options' => $dataGrid->getOptions(),
            'datagrid_columns' => $columns
        ]);
    }

    public function getName()
    {
        return 'datagrid_renderer';
    }
}
