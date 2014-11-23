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
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface ManagerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ManagerInterface
{
    const PRE_UPDATE_EVENT  = 'pre_update';
    const POST_UPDATE_EVENT = 'post_update';
    const PRE_CREATE_EVENT  = 'pre_create';
    const POST_CREATE_EVENT = 'post_create';
    const PRE_REMOVE_EVENT  = 'pre_remove';
    const POST_REMOVE_EVENT = 'post_remove';

    /**
     * Returns redirect helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface
     */
    public function getRedirectHelper();

    /**
     * Returns redirect helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface
     */
    public function getFlashHelper();

    /**
     * Returns image helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface
     */
    public function getImageHelper();

    /**
     * Returns event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * Returns doctrine object manager
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getObjectManager();

    /**
     * Returns translator service
     *
     * @return \Symfony\Component\Translation\TranslatorInterface
     */
    public function getTranslator();

    /**
     * Sets repository
     *
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * Returns current repository
     *
     * @return RepositoryInterface
     */
    public function getRepository();
} 