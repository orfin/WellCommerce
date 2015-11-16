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

/**
 * Interface ManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ManagerInterface
{
    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface
     */
    public function getValidatorHelper();

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
     * @return \WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface
     */
    public function getRepository();

    /**
     * @return \WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface
     */
    public function getFactory();

    /**
     * Returns form object
     *
     * @return \WellCommerce\Bundle\FormBundle\FormBuilderInterface
     */
    public function getFormBuilder();

    /**
     * Returns form instance from builder
     *
     * @param null|object $resource
     * @param array  $config
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    public function getForm($resource, array $config = []);

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
     * @return \WellCommerce\Bundle\CommonBundle\Context\ShopContextInterface
     */
    public function getShopContext();

    /**
     * @return null|object
     */
    public function getUser();
}
