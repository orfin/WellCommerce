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

namespace WellCommerce\Bundle\LayoutBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;

/**
 * Class LayoutPageTree
 *
 * @package WellCommerce\Bundle\LayoutBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageTree extends AbstractForm implements FormInterface
{
    /**
     * Fetches all registered layout pages
     *
     * @return array
     */
    private function getTreeItems()
    {
        $themes = $this->get('layout_theme.repository')->findAll();
        $items  = [];

        /**
         * @var \WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme $theme
         */
        foreach ($themes as $theme) {
            $items[$theme->getId()] = [
                'name'        => $theme->getName() . ' <small>(' . $theme->getFolder() . ')</small>',
                'parent'      => null,
                'weight'      => 0,
                'hasChildren' => false
            ];
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $form->addChild($builder->getElement('tree', [
            'name'               => 'layout_page',
            'label'              => $this->trans('Choose site theme to edit'),
            'sortable'           => false,
            'selectable'         => false,
            'clickable'          => true,
            'deletable'          => false,
            'addable'            => false,
            'prevent_duplicates' => false,
            'items'              => $this->getTreeItems(),
            'onClick'            => 'openLayoutPageEditor',
            'active'             => (int)$this->getParam('id'),
            'clickable_root'     => false
        ]));

        return $form;
    }
} 