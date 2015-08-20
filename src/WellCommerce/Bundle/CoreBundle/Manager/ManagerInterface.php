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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface ManagerInterface
 *
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
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    public function getValidator();

    /**
     * Returns the RedirectHelper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface
     */
    public function getRedirectHelper();

    /**
     * Returns the FlashHelper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface
     */
    public function getFlashHelper();

    /**
     * Returns the ImageHelper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface
     */
    public function getImageHelper();

    /**
     * Returns the EventDispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * Returns the DoctrineHelper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface
     */
    public function getDoctrineHelper();

    /**
     * Returns the RequestHelper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface
     */
    public function getRequestHelper();

    /**
     * Returns the Translator
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface
     */
    public function getTranslatorHelper();

    /**
     * Sets the repository
     *
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * Returns the current repository
     *
     * @return RepositoryInterface
     */
    public function getRepository();

    /**
     * Initializes new resource object
     *
     * @return object
     */
    public function initResource();

    /**
     * Persists new resource
     *
     * @param object  $resource
     * @param Request $request
     */
    public function createResource($resource, Request $request);

    /**
     * Updates existing resource
     *
     * @param object  $resource
     * @param Request $request
     */
    public function updateResource($resource, Request $request);

    /**
     * Removes a resource
     *
     * @param object $resource
     */
    public function removeResource($resource);
}
