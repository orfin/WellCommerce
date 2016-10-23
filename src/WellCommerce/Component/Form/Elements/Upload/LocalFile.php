<?php

namespace WellCommerce\Component\Form\Elements\Upload;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;

/**
 * Class LocalFile
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocalFile extends File
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setRequired([
            'file_source',
        ]);
        
        $resolver->setDefaults([
            'file_types' => ['jpg', 'jpeg', 'png', 'gif', 'csv', 'xml', 'txt', 'pdf'],
        ]);
        
        $resolver->setAllowedTypes('file_source', 'string');
    }
    
    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('oTypeIcons', $this->getTypeIcons(), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('sFilePath', $this->getOption('file_source')));
    }
    
    private function getTypeIcons() : array
    {
        return [
            'cdup'      => '_images_panel/icons/filetypes/cdup.png',
            'unknown'   => '_images_panel/icons/filetypes/unknown.png',
            'directory' => '_images_panel/icons/filetypes/directory.png',
            'gif'       => '_images_panel/icons/filetypes/image.png',
            'png'       => '_images_panel/icons/filetypes/image.png',
            'jpg'       => '_images_panel/icons/filetypes/image.png',
            'bmp'       => '_images_panel/icons/filetypes/image.png',
            'txt'       => '_images_panel/icons/filetypes/text.png',
            'doc'       => '_images_panel/icons/filetypes/text.png',
            'rtf'       => '_images_panel/icons/filetypes/text.png',
            'odt'       => '_images_panel/icons/filetypes/text.png',
            'htm'       => '_images_panel/icons/filetypes/document.png',
            'html'      => '_images_panel/icons/filetypes/document.png',
            'php'       => '_images_panel/icons/filetypes/document.png'
        ];
    }
}