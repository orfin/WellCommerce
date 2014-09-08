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
 * Class LayoutThemeSubscriber
 *
 * @package WellCommerce\Bundle\LayoutBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutThemeSubscriber extends AbstractEventSubscriber
{
    /**
     * Adds theme configuration fields to main theme edit form
     *
     * @param FormEvent $event
     */
    public function onLayoutThemeFormInit(FormEvent $event)
    {
        $builder        = $event->getFormBuilder();
        $form           = $builder->getForm();
        $resource       = $builder->getData();
        $fieldGenerator = $this->container->get('theme_fields_generator');

        $fieldGenerator->loadThemeFieldsConfiguration($resource);
        $fieldGenerator->addFormFields($builder, $form);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'layout_theme.form.init' => 'onLayoutThemeFormInit',
        ];
    }
}