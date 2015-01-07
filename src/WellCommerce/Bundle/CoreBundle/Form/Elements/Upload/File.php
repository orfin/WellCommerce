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

        $resolver->setDefined([
            'repeat_min',
            'repeat_max',
            'limit',
            'file_types',
            'file_types_description'
        ]);

        $resolver->setDefaults([
            'repeat_min'             => 0,
            'repeat_max'             => ElementInterface::INFINITE,
            'limit'                  => 1000,
            'file_types_description' => 'file_types_description',
            'file_types'             => ['jpg', 'jpeg', 'png', 'gif']
        ]);

        $resolver->setAllowedTypes([
            'session_id'             => 'string',
            'session_name'           => 'string',
            'file_types_description' => 'string',
            'file_types'             => 'array'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'sUploadUrl'            => $this->getOption('upload_url'),
            'sSessionName'          => $this->getOption('session_name'),
            'sSessionId'            => $this->getOption('session_id'),
            'iLimit'                => $this->getOption('limit'),
            'asFileTypes'           => $this->getOption('file_types'),
            'sFileTypesDescription' => $this->getOption('file_types_description'),
            'sLoadRoute'            => $this->getOption('load_route'),
        ];
    }
}
