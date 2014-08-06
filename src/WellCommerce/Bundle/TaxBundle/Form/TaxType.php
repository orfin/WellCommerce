<?php

namespace WellCommerce\Bundle\TaxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaxType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value');
        $builder->add('created_at','date');
        $builder->add('updated_at','date');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WellCommerce\Bundle\TaxBundle\Entity\Tax'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wellcommerce_bundle_taxbundle_tax';
    }
}
