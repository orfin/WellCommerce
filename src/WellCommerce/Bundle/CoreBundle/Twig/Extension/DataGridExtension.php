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

use WellCommerce\Component\DataGrid\DataGridInterface;


/**
 * Class DataGridExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataGridExtension extends \Twig_Extension
{
    /**
     * @var string Template name
     */
    private $templateName;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * Constructor
     *
     * @param $templateName
     */
    public function __construct($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * Initializes Twig
     *
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('datagrid_renderer', [$this, 'render'], ['is_safe' => ['html', 'javascript']])
        ];
    }

    public function getName()
    {
        return 'datagrid_renderer';
    }

    /**
     * Renders the datagrid
     *
     * @param DataGridInterface $datagrid
     *
     * @return string
     */
    public function render(DataGridInterface $datagrid)
    {
        return $this->environment->render($this->templateName, [
            'datagrid' => $datagrid
        ]);
    }
}
