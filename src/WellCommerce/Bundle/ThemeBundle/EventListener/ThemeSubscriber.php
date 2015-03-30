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
namespace WellCommerce\Bundle\ThemeBundle\EventListener;

use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\FormBundle\Event\FormEvent;
use WellCommerce\Bundle\ThemeBundle\Form\ThemeFormBuilder;
use WellCommerce\Bundle\ThemeBundle\Manager\ThemeManagerInterface;

/**
 * Class ThemeSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeSubscriber extends AbstractEventSubscriber
{
    /**
     * @var ThemeManagerInterface
     */
    protected $themeManager;

    /**
     * Constructor
     *
     * @param ThemeManagerInterface $themeManager
     */
    public function __construct(ThemeManagerInterface $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents() + [
            ThemeFormBuilder::FORM_INIT_EVENT => 'onThemeFormInit',
        ];
    }

    /**
     * Adds theme configuration fields to main theme edit form
     *
     * @param FormEvent $event
     */
    public function onThemeFormInit(FormEvent $event)
    {
        $builder        = $event->getFormBuilder();
        $form           = $builder->getForm();
        $resource       = $builder->getData();
        $fieldGenerator = $this->container->get('theme.fields_generator');

        $fieldGenerator->loadThemeFieldsConfiguration($resource);
        $fieldGenerator->addFormFields($builder, $form);
    }
}
