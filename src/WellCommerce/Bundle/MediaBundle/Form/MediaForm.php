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
namespace WellCommerce\Bundle\MediaBundle\Form;

use WellCommerce\Bundle\CoreBundle\Entity\BaseSubjectInterface;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class MediaForm
 *
 * @package WellCommerce\Media\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($builder->getElement('image', [
            'name'     => 'required_data',
            'label'    => $this->trans('form.required_data.label'),
            'datagrid' => $this->get('media.datagrid')
        ]));

        $form->addFilter($builder->getFilter('no_code'));
        $form->addFilter($builder->getFilter('trim'));
        $form->addFilter($builder->getFilter('secure'));

        return $form;
    }
}
