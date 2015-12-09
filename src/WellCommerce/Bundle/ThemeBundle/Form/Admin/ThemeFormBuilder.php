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
namespace WellCommerce\Bundle\ThemeBundle\Form\Admin;

use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ThemeFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeFormBuilder extends AbstractFormBuilder
{
    const FORM_INIT_EVENT = 'theme.form.init';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'folder',
            'label'   => $this->trans('theme.label.folder'),
            'comment' => $this->trans('theme.comment.folder'),
            'options' => $this->getFolderDirectories()
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    /**
     * Lists all themes available in app/Resources/themes directory
     *
     * @return array
     */
    private function getFolderDirectories()
    {
        $finder       = new Finder();
        $directories  = $finder->directories()->in($this->getThemeDir())->sortByName()->depth('== 1');
        $themeFolders = [];

        foreach ($directories as $directory) {
            $name                = $directory->getRelativePath();
            $themeFolders[$name] = $name;
        }

        return $themeFolders;
    }
}
