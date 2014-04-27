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
namespace WellCommerce\Plugin\User\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;

/**
 * Class UserExtension
 *
 * @package WellCommerce\Plugin\User\Twig
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserExtension extends Twig_Extension
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

    public function getGlobals()
    {
        return [
            'user' => $this->container->get('session')->get('user')
        ];
    }

    /**
     * Register extension functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('logout_url', [$this, 'getLogoutUrl'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns logout url
     *
     * @return mixed
     */
    public function getLogoutUrl()
    {
        return $this->container->get('router')->generate('admin.user.logout');
    }

    public function getName()
    {
        return 'user';
    }
}
