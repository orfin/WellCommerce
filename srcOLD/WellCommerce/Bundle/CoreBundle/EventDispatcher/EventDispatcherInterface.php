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

use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Interface EventDispatcherInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EventDispatcherInterface
{
    const POST_RESOURCE_INIT_EVENT   = 'post_init';
    const PRE_RESOURCE_UPDATE_EVENT  = 'pre_update';
    const POST_RESOURCE_UPDATE_EVENT = 'post_update';
    const PRE_RESOURCE_CREATE_EVENT  = 'pre_create';
    const POST_RESOURCE_CREATE_EVENT = 'post_create';
    const PRE_RESOURCE_REMOVE_EVENT  = 'pre_remove';
    const POST_RESOURCE_REMOVE_EVENT = 'post_remove';
    const FORM_INIT_EVENT            = 'form_init';
    const DATASET_INIT_EVENT         = 'dataset_init';
    const DATAGRID_INIT_EVENT        = 'datagrid_init';

    /**
     * Dispatches the events after new resource is initialized
     *
     * @param $resource
     */
    public function dispatchOnPostInitResource($resource);

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
     * @param object               $defaultData
     */
    public function dispatchOnFormInitEvent(FormBuilderInterface $builder, FormInterface $form, $defaultData);

    /**
     * Dispatches the events after dataset initialization
     *
     * @param DataSetInterface $dataset
     */
    public function dispatchOnDataSetInitEvent(DataSetInterface $dataset);
}
