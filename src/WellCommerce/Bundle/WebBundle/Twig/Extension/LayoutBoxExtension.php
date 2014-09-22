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
namespace WellCommerce\Bundle\WebBundle\Twig\Extension;

use WellCommerce\Bundle\LayoutBundle\Theme\ShopTheme;

/**
 * Class LayoutBoxExtension
 *
 * @package WellCommerce\Bundle\WebBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxExtension extends \Twig_Extension
{
    /**
     * @var ShopTheme
     */
    private $theme;

    /**
     * Constructor
     *
     * @param ShopTheme $theme
     */
    public function __construct(ShopTheme $theme)
    {
        $this->theme = $theme;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('box', [$this, 'render'], ['is_safe' => ['html']])
        ];
    }

    public function render($box, $params = [])
    {
//        $currentRequest                   = $this->container->get('request_stack')->getCurrentRequest();
//        $request                          = $currentRequest->attributes->all();
//        $request['_controller']           = $layoutBox->controller;
//        $request['_box_id']               = $layoutBox->id;
//        $request['_box_settings']         = $layoutBox->settings;
//        $request['_template_vars']['box'] = $this->getBoxTemplateVars($layoutBox);
//        $subRequest                       = $currentRequest->duplicate($currentRequest->query->all(), null, $request);
//
//        $content = $this->container->get('http_kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
//
//        return $content->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'layout_box';
    }
}
