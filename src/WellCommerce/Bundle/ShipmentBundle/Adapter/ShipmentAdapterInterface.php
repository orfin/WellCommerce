<?php


namespace WellCommerce\Bundle\ShipmentBundle\Adapter;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\ShipmentBundle\Entity\ShipmentInterface;
use WellCommerce\Component\Form\Elements\Fieldset\FieldsetInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Interface ShipmentAdapterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShipmentAdapterInterface
{
    public function addShipment(ShipmentInterface $shipment, array $formValues) : Response;
    
    public function generateLabel(ShipmentInterface $shipment);
    
    public function getLabel(ShipmentInterface $shipment);
    
    public function getLabels(string $date);
    
    public function addFormFields(FieldsetInterface $fieldset, FormBuilderInterface $builder, ShipmentInterface $shipment);
}