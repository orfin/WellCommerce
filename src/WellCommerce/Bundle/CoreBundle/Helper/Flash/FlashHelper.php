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
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class FlashHelper
 *
 * @package WellCommerce\Bundle\CoreBundle\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FlashHelper implements FlashHelperInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $flashesName = 'flashes';

    /**
     * Constructor
     *
     * @param SessionInterface    $session
     * @param TranslatorInterface $translator
     */
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session    = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function addSuccess($message, array $params = [])
    {
        return $this->addMessage(FlashHelperInterface::FLASH_TYPE_SUCCESS, $message, $params);
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
        return $this->translator->trans($message, $params, $this->flashesName);
    }

    /**
     * Returns flash bag
     *
     * @return \Symfony\Component\HttpFoundation\Session\SessionBagInterface
     */
    private function getFlashBag()
    {
        return $this->session->getBag($this->flashesName);
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
} 