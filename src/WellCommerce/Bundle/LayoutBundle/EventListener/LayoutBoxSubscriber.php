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
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class LayoutBoxSubscriber
 *
 * @package WellCommerce\Bundle\LayoutBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxSubscriber extends AbstractEventSubscriber
{
    /**
     * Adds configurator fields to main layout box edit form
     *
     * @param FormEvent $event
     */
    public function onLayoutBoxFormInit(FormEvent $event)
    {
        $builder    = $event->getFormBuilder();
        $form       = $builder->getForm();
        $resource   = $builder->getData();
        $collection = $this->container->get('layout_box.configurator.collection');


//        $fieldGenerator->loadThemeFieldsConfiguration($resource);
//        $fieldGenerator->addFormFields($builder, $form);
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'layout_box.form.init' => 'onLayoutBoxFormInit',
        ];
    }
}