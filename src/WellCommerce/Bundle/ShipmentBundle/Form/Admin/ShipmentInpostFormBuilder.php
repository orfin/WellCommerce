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
namespace WellCommerce\Bundle\ShipmentBundle\Form\Admin;

use ElektronicznyNadawca;
use getUrzedyNadania;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ShipmentInpostFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentInpostFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        /** @var OrderInterface $order */
        $order         = $this->get('order.provider.admin')->getCurrentOrder();
        $orderStatuses = $this->get('order_status.dataset.admin')->getResult('select');
        
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general'),
        ]));
        
        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'paczkomat',
            'label'   => 'Paczkomat',
        ]))->setValue($order->getShippingMethodOption());
        
        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'insurance',
            'label' => 'Ubezpieczenie paczki',
        ]));
        
        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'insuranceAmount',
            'label' => 'Kwota ubezpieczenia',
        ]));
        
        $requiredData->addChild($this->getElement('text_area', [
            'name'  => 'comment',
            'label' => 'Komentarz',
            'rows'  => 2,
        ]));
        
        $requiredData->addChild($this->getElement('select', [
            'name'        => 'orderStatus',
            'label'       => $this->trans('order_status_history.label.order_status'),
            'options'     => $orderStatuses,
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository')),
        ]))->setValue(12);
        
        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'notify',
            'label' => $this->trans('order_status_history.label.nofity'),
        ]))->setValue(1);
        
        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'receiptFiscal',
            'label' => 'Wystaw paragon',
        ]))->setValue(1);
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
    
    protected function createApiClient() : ElektronicznyNadawca
    {
        $wsdlPath = $this->get('kernel')->getRootDir().'/../src/ElektronicznyNadawca/en.wsdl';
        $user     = $this->container->getParameter('elektroniczny_nadawca_user');
        $pass     = $this->container->getParameter('elektroniczny_nadawca_pass');
        
        return new ElektronicznyNadawca($wsdlPath, [
            'login'      => $user,
            'password'   => $pass,
            'exceptions' => false,
        ]);
    }
    
    protected function getUrzadNadania() : array
    {
        $urzedy   = [];
        $response = $this->createApiClient()->getUrzedyNadania(new getUrzedyNadania());
        
        foreach ($response->urzedyNadania as $urzad) {
            $urzedy[$urzad->urzadNadania] = $urzad->nazwaWydruk;
        }
        
        return $urzedy;
    }
}
