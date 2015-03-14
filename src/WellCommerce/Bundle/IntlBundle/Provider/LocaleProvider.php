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

namespace WellCommerce\Bundle\IntlBundle\Provider;

use WellCommerce\Bundle\IntlBundle\Repository\LocaleRepositoryInterface;

/**
 * Class LocaleProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleProvider implements LocaleProviderInterface
{
    /**
     * @var LocaleRepositoryInterface
     */
    protected $repository;

    /**
     * @var array
     */
    protected $locales = [];

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * Constructor
     *
     * @param LocaleRepositoryInterface $repository
     */
    public function __construct(LocaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableLocale($locale)
    {
        return in_array($locale, $this->getAvailableLocales());
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableLocales()
    {
        if (!$this->loaded) {
            $this->locales = $this->repository->getAvailableLocales();
            $this->loaded  = true;
        }

        return $this->locales;
    }
}
