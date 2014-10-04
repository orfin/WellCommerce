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
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\LayoutBundle\Form\LayoutBoxForm;

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
        $builder       = $event->getFormBuilder();
        $form          = $builder->getForm();
        $resource      = $builder->getData();
        $collection    = $this->container->get('layout_box.configurator.collection');
        $configurators = $collection->all();
    }

    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents() + [
            LayoutBoxForm::FORM_INIT_EVENT => 'onLayoutBoxFormInit',
        ];
    }
}