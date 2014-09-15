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

namespace WellCommerce\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * Interface TranslatableEntityInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TranslatableEntityInterface
{
    /**
     * Returns collection of translations.
     *
     * @return ArrayCollection
     */
    public function getTranslations();

    /**
     * Returns collection of new translations.
     *
     * @return ArrayCollection
     */
    public function getNewTranslations();

    /**
     * Adds new translation.
     *
     * @param Translation $translation The translation
     */
    public function addTranslation(Translation $translation);

    /**
     * Removes specific translation.
     *
     * @param Translation $translation The translation
     */
    public function removeTranslation(Translation $translation);

    /**
     * Returns translation for specific locale (creates new one if doesn't exists).
     * If requested translation doesn't exist, it will first try to fallback default locale
     * If any translation doesn't exist, it will be added to newTranslations collection.
     * In order to persist new translations, call mergeNewTranslations method, before flush
     *
     * @param string $locale The locale (en, ru, fr) | null If null, will try with current locale
     *
     * @return Translation
     */
    public function translate($locale = null);

    /**
     * Merges newly created translations into persisted translations.
     */
    public function mergeNewTranslations();

    /**
     * Sets current locale
     *
     * @param string $locale the current locale
     */
    public function setCurrentLocale($locale);

    /**
     * Returns current locale
     *
     * @return string
     */
    public function getCurrentLocale();

    /**
     * Returns default locale
     *
     * @return string
     */
    public function getDefaultLocale();
}