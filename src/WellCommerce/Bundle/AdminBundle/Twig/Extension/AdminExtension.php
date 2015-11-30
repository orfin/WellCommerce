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
namespace WellCommerce\Bundle\AppBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WellCommerce\Bundle\AppBundle\Provider\AdminMenuProvider;

/**
 * Class AdminExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminExtension extends \Twig_Extension
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var AdminMenuProvider
     */
    protected $adminMenuProvider;

    /**
     * Constructor
     *
     * @param SessionInterface  $session
     * @param AdminMenuProvider $adminMenuProvider
     */
    public function __construct(SessionInterface $session, AdminMenuProvider $adminMenuProvider)
    {
        $this->session           = $session;
        $this->adminMenuProvider = $adminMenuProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        $scope = $this->session->get('admin/shop');

        return [
            'user'            => $this->session->get('admin/user'),
            'menu'            => $this->adminMenuProvider->getMenu(),
            'shops'           => $this->session->get('admin/shops'),
            'activeContextId' => $scope['id'],
            'flashbag'        => $this->session->getFlashBag(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin';
    }
}
