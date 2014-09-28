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

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\ThemeBundle\Manager\ThemeManagerInterface;

/**
 * Class ThemeSubscriber
 *
 * @package WellCommerce\Bundle\ThemeBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeSubscriber extends AbstractEventSubscriber
{
    /**
     * @var ThemeManagerInterface
     */
    private $themeManager;

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

    public function onKernelRequest(GetResponseEvent $event)
    {
        $host  = $event->getRequest()->server->get('SERVER_NAME');
        $theme = $this->layoutThemeRepository->find(6);
        $this->shopTheme->setCurrentTheme($theme);
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $host  = $event->getRequest()->server->get('SERVER_NAME');
        $theme = $this->layoutThemeRepository->find(6);
        $this->shopTheme->setCurrentTheme($theme);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuEvent::INIT_EVENT => 'onAdminMenuInitEvent',
            KernelEvents::CONTROLLER   => ['onKernelController', -250],
            KernelEvents::REQUEST      => ['onKernelRequest', -250],
            'theme.form.init'          => 'onThemeFormInit',
        ];
    }
}