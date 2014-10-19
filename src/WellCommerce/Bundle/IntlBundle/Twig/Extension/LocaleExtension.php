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
namespace WellCommerce\Bundle\IntlBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use WellCommerce\Bundle\IntlBundle\Repository\LocaleRepositoryInterface;

/**
 * Class LocaleExtension
 *
 * @package WellCommerce\Bundle\IntlBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleExtension extends \Twig_Extension
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var LocaleRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session, LocaleRepositoryInterface $repository)
    {
        $this->session    = $session;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'locales' => $this->repository->getAvailableLocales()
        ];
    }

    private function getLocales()
    {
        $collection = $this->repository->getAvailableLocales();
        $locales    = [];
        foreach ($collection as $item) {
            $locales[$item['id']] = [
                'code' => $item['code'],
            ];
        }

        return $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'locale';
    }
}
