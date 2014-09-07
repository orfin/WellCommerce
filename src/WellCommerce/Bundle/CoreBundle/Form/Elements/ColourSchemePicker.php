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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ColourSchemePicker
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColourSchemePicker extends TextField implements ElementInterface
{

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
            'file_source',
            'file_types',
            'gradient_height',
            'type_colour',
            'type_gradient',
            'type_image',
        ]);

        $resolver->setOptional([
            'comment',
            'selector',
            'session_name',
            'session_id',
            'error',
            'filters',
            'dependencies',
            'rules',
            'filters',
            'default',
            'property_path',
            'transformer',
            'type_icons'
        ]);

        $resolver->setDefaults([
            'file_types'    => $this->getTypes(),
            'type_icons'    => $this->getIcons(),
            'session_name'  => $this->container->get('session')->getName(),
            'session_id'    => $this->container->get('session')->getId(),
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'property_path' => null,
            'transformer'   => null
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'label'         => 'string',
            'comment'       => 'string',
            'selector'      => 'string',
            'error'         => 'string',
            'filters'       => 'array',
            'rules'         => 'array',
            'dependencies'  => 'array',
            'default'       => ['string', 'integer']
        ]);
    }

    private function getTypes()
    {
        return [
            'jpg',
            'png',
            'gif',
            'swf'
        ];
    }

    private function getIcons()
    {
        return [
            'cdup'      => 'images/icons/filetypes/cdup.png',
            'unknown'   => 'images/icons/filetypes/unknown.png',
            'directory' => 'images/icons/filetypes/directory.png',
            'gif'       => 'images/icons/filetypes/image.png',
            'png'       => 'images/icons/filetypes/image.png',
            'jpg'       => 'images/icons/filetypes/image.png',
            'bmp'       => 'images/icons/filetypes/image.png',
            'txt'       => 'images/icons/filetypes/text.png',
            'doc'       => 'images/icons/filetypes/text.png',
            'rtf'       => 'images/icons/filetypes/text.png',
            'odt'       => 'images/icons/filetypes/text.png',
            'htm'       => 'images/icons/filetypes/document.png',
            'html'      => 'images/icons/filetypes/document.png',
            'php'       => 'images/icons/filetypes/document.png'
        ];
    }

    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('selector', 'sSelector'),
            $this->formatAttributeJs('gradient_height', 'iGradientHeight'),
            $this->formatAttributeJs('type_colour', 'bAllowColour', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('type_gradient', 'bAllowGradient', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('type_image', 'bAllowImage', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('file_source', 'sFilePath'),
            $this->formatAttributeJs('upload_url', 'sUploadUrl'),
            $this->formatAttributeJs('session_name', 'sSessionName'),
            $this->formatAttributeJs('session_id', 'sSessionId'),
            $this->formatAttributeJs('file_types', 'asFileTypes'),
            $this->formatAttributeJs('type_icons', 'oTypeIcons', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('file_types_description', 'sFileTypesDescription'),
            $this->formatAttributeJs('delete_handler', 'fDeleteFile', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('load_handler', 'fLoadFiles', ElementInterface::TYPE_FUNCTION),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }

    public function deleteFile($request)
    {

    }

    public function LoadFiles($request)
    {

    }
}
