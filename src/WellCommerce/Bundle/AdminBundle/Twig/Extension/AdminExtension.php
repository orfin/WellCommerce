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

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class AdminExtension
 *
 * @package WellCommerce\Bundle\AdminBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminExtension extends \Twig_Extension
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'user'     => $this->session->get('admin/user'),
            'menu'     => $this->session->get('admin/menu'),
            'flashbag' => $this->session->getFlashBag(),
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
