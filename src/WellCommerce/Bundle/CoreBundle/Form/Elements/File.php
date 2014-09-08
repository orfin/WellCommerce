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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class File
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class File extends AbstractField implements ElementInterface
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
            'datagrid'
        ]);

        $resolver->setOptional([
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setDefaults([
            'session_name'  => session_name(),
            'session_id'    => session_id(),
            'filters'       => [],
            'rules'         => [],
            'property_path' => null,
            'transformer'   => null
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'label'         => 'string',
            'dependencies'  => 'array',
            'filters'       => 'array',
            'rules'         => 'array',
            'property_path' => ['null', 'object'],
            'transformer'   => ['null', 'object'],
            'datagrid'      => ['object'],
            'session_name'  => 'string',
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
            $this->formatAttributeJs('delete_handler', 'fDeleteHandler', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('load_handler', 'fLoadFiles', ElementInterface::TYPE_FUNCTION),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }

}
