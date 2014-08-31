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
namespace WellCommerce\Bundle\ShopBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use WellCommerce\Bundle\ShopBundle\Repository\ShopRepositoryInterface;

/**
 * Class ShopExtension
 *
 * @package WellCommerce\Bundle\ShopBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopExtension extends \Twig_Extension
{
    /**
     * @var \WellCommerce\Bundle\ShopBundle\Repository\ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'shops' => $this->shopRepository->getCollectionToSelect()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'shop';
    }
}
