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
namespace WellCommerce\Bundle\SmugglerBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class ChannelFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ChannelFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $unitForm)
    {
        $channelRequiredData = $unitForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $channelRequiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('channel.name.label'),
        ]));

        $channelRequiredData->addChild($this->getElement('text_field', [
            'name'  => 'url',
            'label' => $this->trans('channel.url.label'),
        ]));

        $unitForm->addFilter($this->getFilter('no_code'));
        $unitForm->addFilter($this->getFilter('trim'));
        $unitForm->addFilter($this->getFilter('secure'));
    }
}
