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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Upload;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractField;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Attribute;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AttributeCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class File
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class File extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'load_route',
            'upload_url',
            'session_name',
            'session_id',
        ]);

        $resolver->setDefaults([
            'repeat_min'             => 0,
            'repeat_max'             => ElementInterface::INFINITE,
            'limit'                  => 1000,
            'file_types_description' => 'file_types_description',
            'file_types'             => ['jpg', 'jpeg', 'png', 'gif'],
        ]);

        $resolver->setAllowedTypes([
            'session_id'             => 'string',
            'session_name'           => 'string',
            'file_types_description' => 'string',
            'file_types'             => 'array',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sUploadUrl', $this->getOption('upload_url')));
        $collection->add(new Attribute('sSessionName', $this->getOption('session_name')));
        $collection->add(new Attribute('sSessionId', $this->getOption('session_id')));
        $collection->add(new Attribute('iLimit', $this->getOption('limit'), Attribute::TYPE_INTEGER));
        $collection->add(new Attribute('asFileTypes', $this->getOption('file_types'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('sFileTypesDescription', $this->getOption('file_types_description')));
        $collection->add(new Attribute('sLoadRoute', $this->getOption('load_route')));
        $collection->add(new Attribute('oRepeat', $this->prepareRepetitions(), Attribute::TYPE_ARRAY));
    }
}
