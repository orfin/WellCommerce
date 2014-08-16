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
namespace WellCommerce\Bundle\LocaleBundle\Form;

use WellCommerce\Bundle\LocaleBundle\Entity\Locale;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class LocaleForm
 *
 * @package WellCommerce\Locale\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleForm extends AbstractForm implements FormInterface
{
    /**
     * @var LocaleRepositoryInterface
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'    => 'code',
            'label'   => $this->trans('locale.code'),
            'options' => $this->repository->getLocaleNames()
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Sets locale repository
     *
     * @param LocaleRepositoryInterface $repository
     */
    public function setRepository(LocaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
