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

namespace WellCommerce\Bundle\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractManager
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManager implements ManagerInterface
{
    /**
     * @var FlashHelperInterface
     */
    protected $flashHelper;

    /**
     * @var RedirectHelperInterface
     */
    protected $redirectHelper;

    /**
     * @var ImageHelperInterface
     */
    protected $imageHelper;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param FlashHelperInterface     $flashHelper
     * @param RedirectHelperInterface  $redirectHelper
     * @param ImageHelperInterface     $imageHelper
     * @param EventDispatcherInterface $eventDispatcher
     * @param ObjectManager            $objectManager
     * @param TranslatorInterface      $translator
     */
    public function __construct(
        FlashHelperInterface $flashHelper,
        RedirectHelperInterface $redirectHelper,
        ImageHelperInterface $imageHelper,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $objectManager,
        TranslatorInterface $translator
    ) {
        $this->flashHelper     = $flashHelper;
        $this->redirectHelper  = $redirectHelper;
        $this->imageHelper     = $imageHelper;
        $this->eventDispatcher = $eventDispatcher;
        $this->objectManager   = $objectManager;
        $this->translator      = $translator;
    }

    /**
     * @return RedirectHelperInterface
     */
    public function getRedirectHelper()
    {
        return $this->redirectHelper;
    }

    /**
     * @return FlashHelperInterface
     */
    public function getFlashHelper()
    {
        return $this->flashHelper;
    }

    /**
     * @return ImageHelperInterface
     */
    public function getImageHelper()
    {
        return $this->imageHelper;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }
}