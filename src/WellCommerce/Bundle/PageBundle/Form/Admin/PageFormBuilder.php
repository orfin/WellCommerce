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
namespace WellCommerce\Bundle\PageBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Conditions\Equals;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class PageFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $this->addMainFieldset($form);
        $this->addContentFieldset($form);
        $this->addRedirectFieldset($form);
        $this->addShopFieldset($form);

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    /**
     * Adds main settings fieldset to form
     *
     * @param FormInterface $form
     */
    private function addMainFieldset(FormInterface $form)
    {
        $mainData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $mainData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('page.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('common.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getRequestHelper()->getAttributesBagParam('id'),
            'rules'           => [
                $this->getRule('required')
            ],
        ]));

        $mainData->addChild($this->getElement('checkbox', [
            'name'    => 'publish',
            'label'   => $this->trans('common.label.publish'),
            'comment' => $this->trans('page.comment.publish'),
            'default' => 1
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('common.label.hierarchy'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'section',
            'label' => $this->trans('page.label.section'),
        ]));

        $mainData->addChild($this->getElement('tree', [
            'name'        => 'parent',
            'label'       => $this->trans('page.label.parent'),
            'choosable'   => true,
            'selectable'  => false,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('page.dataset.admin')->getResult('flat_tree'),
            'restrict'    => $this->getRequestHelper()->getAttributesBagParam('id'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('page.repository'))
        ]));

        $mainData->addChild($this->getElement('tip', [
            'tip' => $this->trans('page.tip.client_groups')
        ]));

        $mainData->addChild($this->getElement('multi_select', [
            'name'        => 'clientGroups',
            'label'       => $this->trans('page.label.client_groups'),
            'options'     => $this->get('client_group.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('client_group.repository'))
        ]));
    }

    /**
     * Adds content editing fieldset to form
     *
     * @param FormInterface $form
     */
    private function addContentFieldset(FormInterface $form)
    {
        $contentData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'content_data',
            'label' => $this->trans('common.fieldset.description')
        ]));

        $languageData = $contentData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('page.repository'))
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'content',
            'label' => $this->trans('common.label.description'),
        ]));

        $this->addMetadataFieldset($form, $this->get('page.repository'));
    }

    private function addRedirectFieldset(FormInterface $form)
    {
        $redirectSettings = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'redirect_settings',
            'label' => $this->trans('page.fieldset.redirect_settings')
        ]));

        $redirectType = $redirectSettings->addChild($this->getElement('select', [
            'name'    => 'redirectType',
            'label'   => $this->trans('page.label.redirect.type'),
            'options' => [
                0 => $this->trans('page.label.redirect.none'),
                1 => $this->trans('page.label.redirect.url'),
                2 => $this->trans('page.label.redirect.route'),
            ]
        ]));

        $redirectSettings->addChild($this->getElement('text_field', [
            'name'         => 'redirectUrl',
            'label'        => $this->trans('page.label.redirect.url'),
            'dependencies' => [
                $this->getDependency('show', [
                    'form'      => $form,
                    'field'     => $redirectType,
                    'condition' => new Equals(1)
                ])
            ]
        ]));

        $redirectSettings->addChild($this->getElement('select', [
            'name'         => 'redirectRoute',
            'label'        => $this->trans('page.label.redirect.route'),
            'options'      => $this->getRedirectRoutes(),
            'dependencies' => [
                $this->getDependency('show', [
                    'form'      => $form,
                    'field'     => $redirectType,
                    'condition' => new Equals(2)
                ])
            ]
        ]));
    }

    /**
     * Adds shop selector fieldset to form
     *
     * @param FormInterface $form
     */
    private function addShopFieldset(FormInterface $form)
    {
        $shopsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shops_data',
            'label' => $this->trans('common.fieldset.shops')
        ]));

        $shopsData->addChild($this->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('common.label.shops'),
            'options'     => $this->get('shop.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('shop.repository'))
        ]));
    }

    /**
     * Returns all available routes which have allow_page_redirect option
     *
     * @return array
     */
    private function getRedirectRoutes()
    {
        $availableRoutes = [];

        /**
         * @var $route \Symfony\Component\Routing\Route
         */
        foreach ($this->get('router')->getRouteCollection()->all() as $name => $route) {
            if ($route->hasOption('allow_page_redirect')) {
                $availableRoutes[$name] = $route->getPath();
            }
        }

        return $availableRoutes;
    }
}
