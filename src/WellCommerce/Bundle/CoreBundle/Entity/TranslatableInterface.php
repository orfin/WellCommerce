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

/**
 * Interface TranslatableInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TranslatableInterface
{
    public function getTranslations();
    
    public function getNewTranslations();
    
    public function addTranslation($translation);
    
    public function removeTranslation($translation);
    
    /**
     * Translates an entity
     *
     * @param null      $locale
     * @param bool|true $fallbackToDefault
     *
     * @return object
     */
    public function translate($locale = null, $fallbackToDefault = true);
    
    public function mergeNewTranslations();
    
    public function setCurrentLocale($locale);
    
    public function getCurrentLocale();
    
    public function setDefaultLocale($locale);
    
    public function getDefaultLocale();
}
