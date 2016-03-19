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
use WellCommerce\Bundle\AdminBundle\Provider\AdminMenuProvider;

/**
 * Class AdminExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var AdminMenuProvider
     */
    protected $adminMenuProvider;
    
    /**
     * Constructor
     *
     * @param AdminMenuProvider $adminMenuProvider
     */
    public function __construct(AdminMenuProvider $adminMenuProvider)
    {
        $this->adminMenuProvider = $adminMenuProvider;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('adminMenu', [$this, 'getAdminMenu'], ['is_safe' => ['html']]),
        ];
    }
    
    public function getAdminMenu()
    {
        return $this->adminMenuProvider->getMenu();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin';
    }
}
