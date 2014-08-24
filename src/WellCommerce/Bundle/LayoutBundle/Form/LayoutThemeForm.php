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

use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class LayoutThemeForm
 *
 * @package WellCommerce\LayoutTheme\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutThemeForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Theme name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Theme name is required')
                ]),
            ]
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'    => 'folder',
            'label'   => $this->trans('Theme folder'),
            'comment' => $this->trans('Select theme folder from list'),
            'options' => $this->getFolderDirectories()
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Lists all themes available in app/Resources/themes directory
     *
     * @return array
     */
    private function getFolderDirectories()
    {
        $finder       = new Finder();
        $kernelDir    = $this->get('kernel')->getRootDir();
        $searchDir    = $kernelDir . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'themes';
        $directories  = $finder->directories()->in($searchDir)->sortByName()->depth('== 1');
        $themeFolders = [];

        foreach ($directories as $directory) {
            $name                = $directory->getRelativePath();
            $themeFolders[$name] = $name;
        }

        return $themeFolders;
    }
}
