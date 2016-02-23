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
namespace WellCommerce\Component\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\AbstractField;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class ClientSelect
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientSelect extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'load_clients_route',
            'get_client_details_route'
        ]);

        $resolver->setAllowedTypes('load_clients_route', 'string');
        $resolver->setAllowedTypes('get_client_details_route', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sLoadClientsRoute', $this->getOption('load_clients_route'), Attribute::TYPE_STRING));
        $collection->add(new Attribute('sGetClientDetailsRoute', $this->getOption('get_client_details_route'), Attribute::TYPE_STRING));
    }
}
