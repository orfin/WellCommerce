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

use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Validator\ValidatorHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\OrderBundle\Context\Admin\OrderContextInterface;
use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Interface ManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ManagerInterface
{
    /**
     * Returns the helper for validation
     *
     * @return ValidatorHelperInterface
     */
    public function getValidatorHelper() : ValidatorHelperInterface;

    /**
     * Returns the helper for management of flash session messages
     *
     * @return FlashHelperInterface
     */
    public function getFlashHelper() : FlashHelperInterface;

    /**
     * Returns the helper for management of images
     *
     * @return ImageHelperInterface
     */
    public function getImageHelper() : ImageHelperInterface;

    /**
     * Returns the helper for Doctrine calls
     *
     * @return DoctrineHelperInterface
     */
    public function getDoctrineHelper() : DoctrineHelperInterface;

    /**
     * Returns the helper for Request management
     *
     * @return RequestHelperInterface
     */
    public function getRequestHelper() : RequestHelperInterface;

    /**
     * Returns the helper for translations management
     *
     * @return TranslatorHelperInterface
     */
    public function getTranslatorHelper() : TranslatorHelperInterface;

    /**
     * Returns the repository
     *
     * @return RepositoryInterface
     */
    public function getRepository() : RepositoryInterface;

    /**
     * Returns the event-dispatcher helper
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher() : EventDispatcherInterface;

    /**
     * Returns the factory
     *
     * @return EntityFactoryInterface
     */
    public function getFactory() : EntityFactoryInterface;

    /**
     * Returns the form builder
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder() : FormBuilderInterface;

    /**
     * Initializes the form
     *
     * @param object $resource
     * @param array  $config
     *
     * @return FormInterface
     */
    public function getForm($resource, array $config = []) : FormInterface;

    /**
     * Initializes new resource object
     *
     * @return object
     */
    public function initResource();

    /**
     * Persists new resource
     *
     * @param object $resource
     */
    public function createResource($resource);

    /**
     * Updates existing resource
     *
     * @param object $resource
     */
    public function updateResource($resource);

    /**
     * Removes a resource
     *
     * @param object $resource
     */
    public function removeResource($resource);

    /**
     * @return ShopContextInterface
     */
    public function getShopContext() : ShopContextInterface;

    /**
     * @return null|object
     */
    public function getUser();
}
