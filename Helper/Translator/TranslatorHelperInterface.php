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

namespace WellCommerce\Bundle\CoreBundle\Helper\Translator;

/**
 * Interface TranslatorHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TranslatorHelperInterface
{
    const DEFAULT_TRANSLATION_DOMAIN = 'wellcommerce';

    /**
     * Translates the given string using translator service
     *
     * @param string $message
     * @param array  $parameters
     * @param string $domain
     *
     * @return string
     */
    public function trans(string $message, array $parameters = [], string $domain = self::DEFAULT_TRANSLATION_DOMAIN) : string;

    /**
     * Returns all messages for given locale and domain
     *
     * @param string $locale
     * @param string $domain
     *
     * @return array
     */
    public function getMessages(string $locale, string $domain = self::DEFAULT_TRANSLATION_DOMAIN) : array;
}
