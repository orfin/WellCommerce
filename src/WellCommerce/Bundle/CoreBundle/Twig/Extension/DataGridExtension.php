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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

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

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('datagrid_renderer', [$this, 'render'], ['is_safe' => ['html','javascript']])
        ];
    }

    /**
     * Renders DataGrid
     *
     * @param DataGridInterface $datagrid DataGrid instance
     *
     * @return mixed
     */
    public function render(DataGridInterface $datagrid)
    {
        return $this->container->get('templating')->render('WellCommerceCoreBundle:DataGrid:datagrid.html.twig', [
            'datagrid' => $datagrid
        ]);
    }

    public function getName()
    {
        return 'datagrid_renderer';
    }
}
