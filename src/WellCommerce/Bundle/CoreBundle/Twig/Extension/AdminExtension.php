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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use WellCommerce\Bundle\TaxBundle\Repository\TaxRepositoryInterface;

/**
 * Class AdminExtension
 *
 * @package WellCommerce\Bundle\CoreBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminExtension extends \Twig_Extension
{

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session|\Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Returns all global assignable admin template variables
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            'user'     => $this->session->get('admin/user'),
            'menu'     => $this->session->get('admin/menu'),
            'flashbag' => $this->session->getFlashBag()
        ];
    }

    /**
     * Returns unique extensions name
     *
     * @return string
     */
    public function getName()
    {
        return 'admin';
    }
}
