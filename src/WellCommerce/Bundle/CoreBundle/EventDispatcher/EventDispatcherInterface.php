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

namespace WellCommerce\Bundle\CoreBundle\EventDispatcher;

use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;

/**
 * Interface EventDispatcherInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EventDispatcherInterface
{
    /**
     * Dispatches the events before new resource is created
     *
     * @param $resource
     */
    public function dispatchOnPreCreateResource($resource);

    /**
     * Dispatches the events after new resource was created
     *
     * @param $resource
     */
    public function dispatchOnPostCreateResource($resource);

    /**
     * Dispatches the events before existing resource is updated
     *
     * @param $resource
     */
    public function dispatchOnPreUpdateResource($resource);

    /**
     * Dispatches the events after existing resource was updated
     *
     * @param $resource
     */
    public function dispatchOnPostUpdateResource($resource);

    /**
     * Dispatches the events before existing resource is removed
     *
     * @param $resource
     */
    public function dispatchOnPreRemoveResource($resource);

    /**
     * Dispatches the events after existing resource was removed
     *
     * @param $resource
     */
    public function dispatchOnPostRemoveResource($resource);

    /**
     * Dispatches the events after form initialization
     *
     * @param FormBuilderInterface $builder
     * @param FormInterface        $form
     */
    public function dispatchOnFormInitEvent(FormBuilderInterface $builder, FormInterface $form);
}
