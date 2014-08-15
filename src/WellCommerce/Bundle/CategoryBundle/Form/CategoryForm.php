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
namespace WellCommerce\Bundle\CategoryBundle\Form;

use WellCommerce\Bundle\CompanyBundle\Form\DataTransformer\CompanyToNumberTransformer;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class CategoryForm
 *
 * @package WellCommerce\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryForm extends AbstractForm implements FormInterface
{
    /**
     * @var CategoryRepositoryInterface
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

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('category.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ])
            ]
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('category.company'),
            'options'     => $this->get('company.repository')->allToSelect(),
            'transformer' => new CompanyToNumberTransformer($this->getEntityManager())
        ]));



        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Prepares form data using retrieved entity
     *
     * @param Category $category Model
     *
     * @return array
     */
    public function getDefaultData(Category $category)
    {
        $formData    = [];
        $accessor    = $this->getPropertyAccessor();
        $translations = $category->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
//            'name'    => $translations->getName()
        ]);

        return $formData;
    }

    /**
     * Sets repository object
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function setRepository(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
