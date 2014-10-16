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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BaseSubjectInterface;
use WellCommerce\Bundle\MediaBundle\Entity\Media;
use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;
use WellCommerce\Bundle\MediaBundle\Repository\MediaRepositoryInterface;

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

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
