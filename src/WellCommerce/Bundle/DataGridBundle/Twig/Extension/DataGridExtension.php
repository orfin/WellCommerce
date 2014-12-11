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
namespace WellCommerce\Bundle\DataGridBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;

/**
 * Class DataGridExtension
 *
 * @package WellCommerce\Bundle\DataGridBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $template;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     * @param string             $template Twig template used to render datagrid
     */
    public function __construct(ContainerInterface $container, $template)
    {
        $this->container = $container;
        $this->template  = $template;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('datagrid_renderer', [$this, 'render'], ['is_safe' => ['html', 'javascript']])
        ];
    }

    /**
     * Renders DataGrid
     *
     * @param DataGridInterface $datagrid DataGrid instance
     *
     * @return string
     */
    public function render(DataGridInterface $datagrid)
    {
        return $this->container->get('twig')->render($this->template, [
            'datagrid' => $datagrid
        ]);
    }

    public function getName()
    {
        return 'datagrid_renderer';
    }
}