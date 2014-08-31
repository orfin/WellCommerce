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
namespace WellCommerce\Bundle\TaxBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use WellCommerce\Bundle\TaxBundle\Repository\TaxRepositoryInterface;

/**
 * Class TaxExtension
 *
 * @package WellCommerce\Bundle\TaxBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxExtension extends \Twig_Extension
{
    /**
     * @var \WellCommerce\Bundle\TaxBundle\Repository\TaxRepositoryInterface
     */
    protected $taxRepository;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'taxes' => $this->taxRepository->getCollectionToSelect('value')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tax';
    }
}
