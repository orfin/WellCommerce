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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
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
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

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
     * @param DoctrineHelperInterface  $doctrineHelper
     * @param TranslatorInterface      $translator
     */
    public function __construct(
        FlashHelperInterface $flashHelper,
        RedirectHelperInterface $redirectHelper,
        ImageHelperInterface $imageHelper,
        EventDispatcherInterface $eventDispatcher,
        DoctrineHelperInterface $doctrineHelper,
        TranslatorInterface $translator
    ) {
        $this->flashHelper     = $flashHelper;
        $this->redirectHelper  = $redirectHelper;
        $this->imageHelper     = $imageHelper;
        $this->eventDispatcher = $eventDispatcher;
        $this->doctrineHelper  = $doctrineHelper;
        $this->translator      = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectHelper()
    {
        return $this->redirectHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlashHelper()
    {
        return $this->flashHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getImageHelper()
    {
        return $this->imageHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getDoctrineHelper()
    {
        return $this->doctrineHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }
}