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
namespace WellCommerce\Bundle\PaymentBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\AdminMenuBundle\Builder\AdminMenuItem;
use WellCommerce\Bundle\AdminMenuBundle\Event\AdminMenuInitEvent;
use WellCommerce\Bundle\CoreBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\CoreBundle\Form\Conditions\Equals;
use WellCommerce\Bundle\CoreBundle\Form\Dependencies\Dependency;
use WellCommerce\Bundle\CoreBundle\Form\Dependencies\DependencyInterface;
use WellCommerce\Bundle\CoreBundle\Form\Option;

/**
 * Class PaymentMethodSubscriber
 *
 * @package WellCommerce\Bundle\PaymentBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodSubscriber extends AbstractEventSubscriber
{
    /**
     * Adds new admin menu items to collection
     *
     * @param AdminMenuEvent $event
     */
    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'payment_method',
            'name'       => $this->translator->trans('menu.configuration.payment_method'),
            'link'       => $this->router->generate('admin.payment_method.index'),
            'path'       => '[menu][configuration][payment_method]',
            'sort_order' => 20
        ]));
    }

    /**
     * Adds processor settings to payment method form
     *
     * @param FormEvent $event
     */
    public function onPaymentMethodFormInit(FormEvent $event)
    {
        $builder         = $event->getFormBuilder();
        $form            = $builder->getForm();
        $resource        = $builder->getData();
        $processors      = $this->container->get('payment_method.processor.collection')->all();
        $processorSelect = $form->getChild('required_data')->getChild('processor');

        /**
         * @var $processor \WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface
         */
        foreach ($processors as $processor) {
            $processorSelect->addOption($processor->getAlias(), $processor->getName());
            $fieldset = $processor->addConfigurationFieldset($builder, $form, $resource);
            $fieldset->addDependency('show', [
                'field'     => $processorSelect,
                'form'      => $form,
                'condition' => new Equals($processor->getAlias())
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent',
            'payment_method.form.init'                => 'onPaymentMethodFormInit',
        ];
    }
}