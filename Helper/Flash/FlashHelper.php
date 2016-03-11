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

namespace WellCommerce\Bundle\CoreBundle\Helper\Flash;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;

/**
 * Class FlashHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FlashHelper implements FlashHelperInterface
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var TranslatorHelperInterface
     */
    protected $translatorHelper;

    /**
     * Constructor
     *
     * @param SessionInterface          $session
     * @param TranslatorHelperInterface $translatorHelper
     */
    public function __construct(SessionInterface $session, TranslatorHelperInterface $translatorHelper)
    {
        $this->session          = $session;
        $this->translatorHelper = $translatorHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function addSuccess(string $message, array $params = [])
    {
        $this->addMessage(FlashHelperInterface::FLASH_TYPE_SUCCESS, $message, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function addNotice(string $message, array $params = [])
    {
        $this->addMessage(FlashHelperInterface::FLASH_TYPE_NOTICE, $message, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function addError(string $message, array $params = [])
    {
        $this->addMessage(FlashHelperInterface::FLASH_TYPE_ERROR, $message, $params);
    }

    /**
     * Shortcut to add new flash message to bag
     *
     * @param string $type
     * @param string $message
     * @param array  $params
     */
    private function addMessage(string $type, string $message, array $params)
    {
        $message = $this->translate($message, $params);

        $this->getFlashBag()->add($type, $message);
    }

    /**
     * Returns the translated message
     *
     * @param string $message
     * @param array  $params
     *
     * @return string
     */
    private function translate(string $message, array $params) : string
    {
        return $this->translatorHelper->trans($message, $params, 'wellcommerce');
    }

    /**
     * Returns the flash bag
     *
     * @return FlashBag
     */
    private function getFlashBag() : FlashBag
    {
        return $this->session->getBag(FlashHelperInterface::FLASHES_NAME);
    }
}
