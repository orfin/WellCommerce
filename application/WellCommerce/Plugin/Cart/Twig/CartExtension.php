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
namespace WellCommerce\Plugin\CartExtension\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;

/**
 * Class CartExtension
 *
 * @package WellCommerce\Plugin\CartExtension\Twig
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartExtension extends Twig_Extension
{
    /**
     * Container object
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
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

    /**
     * Register extension functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cart_preview', [$this, 'renderCartPreview'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Outputs rendered cart preview using passed template
     *
     * @param $template
     *
     * @return mixed
     */
    public function renderCartPreview($template)
    {
        return $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cart';
    }
}
