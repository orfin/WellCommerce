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
namespace WellCommerce\Bundle\AdminBundle\Twig\Extension;

use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\Twig\AbstractTwigExtension;

/**
 * Class DataGridExtension
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridExtension extends AbstractTwigExtension
{
    /**
     * @var string Template name
     */
    protected $templateName;

    /**
     * Constructor
     *
     * @param $templateName
     */
    public function __construct($templateName)
    {
        $this->templateName = $templateName;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('datagrid_renderer', [$this, 'render'], ['is_safe' => ['html', 'javascript']])
        ];
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

    public function getName()
    {
        return 'datagrid_renderer';
    }
}