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
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class Image
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Image extends File implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'load_route',
        ]);

        $resolver->setDefined([
            'repeat_min',
            'repeat_max',
            'limit',
            'main_id',
            'visibility_change',
            'upload_url',
            'session_name',
            'session_id',
            'file_types',
            'file_types_description',
            'photos',
        ]);

        $resolver->setDefaults([
            'repeat_min'             => 0,
            'repeat_max'             => ElementInterface::INFINITE,
            'limit'                  => 1000,
            'file_types_description' => 'file_types_description',
            'file_types'             => ['jpg', 'jpeg', 'png', 'gif'],
            'photos'                 => [],
        ]);

        $resolver->setAllowedTypes([
            'session_id'             => 'string',
            'session_name'           => 'string',
            'file_types_description' => 'string',
            'file_types'             => 'array',
            'photos'                 => 'array',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('main_id', 'sMainId'),
            $this->formatAttributeJs('visibility_change', 'bVisibilityChangeable'),
            $this->formatAttributeJs('upload_url', 'sUploadUrl'),
            $this->formatAttributeJs('session_name', 'sSessionName'),
            $this->formatAttributeJs('session_id', 'sSessionId'),
            $this->formatAttributeJs('limit', 'iLimit'),
            $this->formatAttributeJs('file_types', 'asFileTypes'),
            $this->formatAttributeJs('file_types_description', 'sFileTypesDescription'),
            $this->formatAttributeJs('load_route', 'sLoadRoute'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest($data)
    {
        $accessor = $this->getPropertyAccessor();

        if (null !== $this->getPropertyPath() && $accessor->isReadable($data, $this->getPropertyPath())) {
            $value = $this->getValue();
            if ($this->hasTransformer()) {
                $value = $this->getTransformer()->reverseTransform($value);
            }
            $accessor->setValue($data, $this->getName(), $value);
        }
    }
}
