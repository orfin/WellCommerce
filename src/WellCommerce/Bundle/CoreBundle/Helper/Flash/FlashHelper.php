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
    public function addSuccess($message, array $params = [])
    {
        return $this->addMessage(FlashHelperInterface::FLASH_TYPE_SUCCESS, $message, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function addNotice($message, array $params = [])
    {
        return $this->addMessage(FlashHelperInterface::FLASH_TYPE_NOTICE, $message, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function addError($message, array $params = [])
    {
        return $this->addMessage(FlashHelperInterface::FLASH_TYPE_ERROR, $message, $params);
    }

    /**
     * Shortcut to add new flash message to bag
     *
     * @param $type
     * @param $message
     * @param $params
     *
     * @return mixed
     */
    private function addMessage($type, $message, $params)
    {
        $message = $this->translate($message, $params);

        return $this->getFlashBag()->add($type, $message);
    }

    /**
     * Translates given message using translator service
     *
     * @param $message
     * @param $params
     *
     * @return string
     */
    private function translate($message, $params)
    {
        return $this->translatorHelper->trans($message, $params, 'wellcommerce');
    }

    /**
     * Returns flash bag
     *
     * @return \Symfony\Component\HttpFoundation\Session\Flash\FlashBag
     */
    private function getFlashBag()
    {
        return $this->session->getBag(FlashHelperInterface::FLASHES_NAME);
    }
}
