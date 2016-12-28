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
namespace WellCommerce\Bundle\ClientBundle\Twig\Extension;

use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class QuickLoginExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class QuickLoginExtension extends \Twig_Extension
{
    /**
     * @var FormBuilderInterface
     */
    private $builder;

    /**
     * @var RouterHelperInterface
     */
    private $routerHelper;

    /**
     * QuickLoginExtension constructor.
     *
     * @param FormBuilderInterface  $builder
     * @param RouterHelperInterface $routerHelper
     */
    public function __construct(FormBuilderInterface $builder, RouterHelperInterface $routerHelper)
    {
        $this->builder      = $builder;
        $this->routerHelper = $routerHelper;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('quick_login_form', [$this, 'createQuickLoginForm'], ['is_safe' => ['html']]),
        ];
    }

    public function getName()
    {
        return 'quick_login_form';
    }

    public function createQuickLoginForm()
    {
        return $this->builder->createForm([
            'name'         => 'login',
            'ajax_enabled' => false,
            'action'       => $this->routerHelper->generateUrl('front.client.login_check')
        ], null);
    }
}
