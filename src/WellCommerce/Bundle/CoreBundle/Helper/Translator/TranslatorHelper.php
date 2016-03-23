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

use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TranslatorHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TranslatorHelper implements TranslatorHelperInterface
{
    /**
     * @var TranslatorInterface|\Symfony\Component\Translation\TranslatorBagInterface
     */
    protected $translator;

    /**
     * Constructor
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function trans(string $message, array $params = [], string $domain = self::DEFAULT_TRANSLATION_DOMAIN) : string
    {
        return $this->translator->trans($message, $params, $domain);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages(string $locale, string $domain = self::DEFAULT_TRANSLATION_DOMAIN) : array
    {
        $catalogue = $this->getCatalogue($locale);

        return $catalogue->all($domain);
    }

    /**
     * Returns the message catalogue
     *
     * @param string $locale
     *
     * @return MessageCatalogueInterface
     */
    protected function getCatalogue(string $locale) : MessageCatalogueInterface
    {
        return $this->translator->getCatalogue($locale);
    }
}
