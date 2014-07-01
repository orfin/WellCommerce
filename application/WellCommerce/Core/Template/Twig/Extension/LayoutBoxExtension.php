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
use Symfony\Component\HttpKernel\HttpKernelInterface;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;
use WellCommerce\Core\Layout\Box\LayoutBox;

/**
 * Class LayoutBoxExtension
 *
 * @package WellCommerce\Core\Template\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('layout_box', [$this, 'getLayoutBoxContent'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Renders layout box forwarding request to related controller service
     *
     * @param LayoutBox $layoutBox
     *
     * @return mixed
     */
    public function getLayoutBoxContent($controller, $settings = [])
    {
        $currentRequest           = $this->container->get('request_stack')->getCurrentRequest();
        $request                  = $currentRequest->attributes->all();
        $request['_controller']   = $controller;
        $request['_box_settings'] = $settings;
        $subRequest               = $currentRequest->duplicate($currentRequest->query->all(), null, $request);

        $content = $this->container->get('kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

        return $content->getContent();
    }

    public function getName()
    {
        return 'layout_box';
    }
}
