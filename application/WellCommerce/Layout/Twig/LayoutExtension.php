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
namespace WellCommerce\Layout\Twig;

;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use WellCommerce\Core\Layout\Box\LayoutBox;
use WellCommerce\Core\Layout\Column\LayoutColumn;
use WellCommerce\Core\Layout\Column\LayoutColumnCollection;

/**
 * Class LayoutExtension
 *
 * @package WellCommerce\Layout\Twig
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('layout_box', [$this, 'getLayoutBoxContent'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Renders layout box forwarding request to related controller service
     *
     * @param LayoutBox $layoutBox
     *
     * @return mixed
     */
    public function getLayoutBoxContent(LayoutBox $layoutBox)
    {
        $currentRequest                   = $this->container->get('request_stack')->getCurrentRequest();
        $request                          = $currentRequest->attributes->all();
        $request['_controller']           = $layoutBox->controller;
        $request['_box_id']               = $layoutBox->id;
        $request['_box_settings']         = $layoutBox->settings;
        $request['_template_vars']['box'] = $this->getBoxTemplateVars($layoutBox);
        $subRequest                       = $currentRequest->duplicate($currentRequest->query->all(), null, $request);

        $content = $this->container->get('http_kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

        return $content->getContent();
    }

    /**
     * Returns additional template variables for box
     *
     * @param LayoutBox $layoutBox
     *
     * @return array
     */
    private function getBoxTemplateVars(LayoutBox $layoutBox)
    {
        return [
            'id'       => $layoutBox->id,
            'settings' => $layoutBox->settings
        ];
    }

    public function getName()
    {
        return 'layout';
    }
}
