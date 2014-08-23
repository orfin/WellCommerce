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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\MediaBundle\DataGrid\MediaDataGrid;

/**
 * Class Image
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Image extends File implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
            'property_path',
            'load_route',
        ]);

        $resolver->setOptional([
            'comment',
            'repeat_min',
            'repeat_max',
            'limit',
            'error',
            'rules',
            'filters',
            'dependencies',
            'main_id',
            'visibility_change',
            'upload_url',
            'session_name',
            'session_id',
            'file_types',
            'file_types_description',
            'dependencies',
            'filters',
            'rules',
            'transformer',
            'photos'
        ]);

        $resolver->setDefaults([
            'repeat_min'             => 0,
            'repeat_max'             => ElementInterface::INFINITE,
            'limit'                  => 1000,
            'session_name'           => session_name(),
            'session_id'             => session_id(),
            'file_types_description' => 'file_types_description',
            'file_types'             => ['jpg', 'jpeg', 'png', 'gif'],
            'property_path'          => null,
            'transformer'            => null,
            'dependencies'           => [],
            'filters'                => [],
            'rules'                  => [],
            'photos'                 => [],
        ]);

        $resolver->setAllowedTypes([
            'name'                   => 'string',
            'label'                  => 'string',
            'dependencies'           => 'array',
            'filters'                => 'array',
            'rules'                  => 'array',
            'property_path'          => ['null', 'object'],
            'transformer'            => ['null', 'object'],
            'session_name'           => 'string',
            'file_types_description' => 'string',
            'file_types'             => 'array',
            'photos'                 => 'array'
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
            $this->formatAttributeJs('file_types', 'asFileTypes'),
            $this->formatAttributeJs('file_types_description', 'sFileTypesDescription'),
            $this->formatAttributeJs('load_route', 'sLoadRoute'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
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
