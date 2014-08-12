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

namespace WellCommerce\Bundle\LocaleBundle\LocaleProvider;

use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class LocaleProviderInterface
 *
 * @package WellCommerce\Bundle\LocaleBundle\LocaleProvider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleProvider implements LocaleProviderInterface
{
    /**
     * @var LocaleRepositoryInterface
     */
    protected $repository;
    protected $locales;

    public function __construct(LocaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableLocales()
    {
        if (null === $this->locales) {
            $this->locales = $this->repository->getAvailableLocales();
        }

        return $this->locales;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableLocale($locale)
    {
        return in_array($locale, $this->getAvailableLocales());
    }
} 