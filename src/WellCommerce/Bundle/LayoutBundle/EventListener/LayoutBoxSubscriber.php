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
namespace WellCommerce\Bundle\LayoutBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorInterface;
use WellCommerce\Bundle\LayoutBundle\Form\LayoutBoxForm;

/**
 * Class LayoutBoxSubscriber
 *
 * @package WellCommerce\Bundle\LayoutBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents() + [
            LayoutBoxForm::FORM_INIT_EVENT => 'onLayoutBoxFormInit',
            'layout_box.pre_update'        => 'onLayoutBoxResourceSave',
        ];
    }

    /**
     * Adds configurator fields to main layout box edit form
     *
     * @param FormEvent $event
     */
    public function onLayoutBoxFormInit(FormEvent $event)
    {
        $builder       = $event->getFormBuilder();
        $resource      = $builder->getData();
        $configurators = $this->container->get('layout_box.configurator.collection')->all();
        $boxSettings   = $resource->getSettings();

        // Loop through all configurators, render fieldset and set default data
        foreach ($configurators as $configurator) {
            if ($configurator instanceof LayoutBoxConfiguratorInterface) {
                $defaults = [];
                if ($resource->getBoxType() == $configurator->getType()) {
                    $defaults = $boxSettings;
                }

                $configurator->addFormFields($builder, $defaults);
            }
        }
    }

    /**
     * Sets resource settings fetched from fieldset corresponding to selected box type
     *
     * @param ResourceEvent $event
     */
    public function onLayoutBoxResourceSave(ResourceEvent $event)
    {
        $request      = $event->getRequest()->request->all();
        $resource     = $event->getResource();
        $accessor     = $this->getPropertyAccessor();
        $propertyPath = sprintf('[%s]', $request['required_data']['boxType']);
        $settings     = $accessor->getValue($request, $propertyPath);
        $resource->setSettings($settings);
    }
}