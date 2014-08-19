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

/**
 * Class File
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class File extends Field implements ElementInterface
{
    public $datagrid;

    protected $jsFunction;

    public function __construct($attributes, ContainerInterface $container)
    {
        parent::__construct($attributes);

        $this->container                  = $container;
        $datagridBuilder                  = $container->get('datagrid_builder');
        $this->datagrid                   = $datagridBuilder->create($container->get('file.datagrid'));
        $this->jsFunction                 = 'LoadFiles_' . $this->_id;
        $this->attributes['load_handler'] = 'xajax_' . $this->jsFunction;

        $this->container->get('xajax_manager')->registerFunction([
            $this->jsFunction,
            $this,
            'doLoadFilesForDatagrid_' . $this->_id
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'session_name' => session_name(),
            'session_id'   => session_id(),
        ]);

        $resolver->setAllowedTypes([
            'session_name' => 'string',
        ]);
    }

    public function __call($function, $arguments)
    {
        if (substr($function, 0, strlen('doLoadFilesForDatagrid_')) == 'doLoadFilesForDatagrid_') {
            return call_user_func_array([
                $this,
                'doLoadFilesForDatagrid'
            ], $arguments);
        }
    }

    public function doLoadFilesForDatagrid($request)
    {
        if (isset($this->attributes['file_types']) && is_array($this->attributes['file_types']) && count($this->attributes['file_types'])) {
            if (!isset($request['where']) || !is_array($request['where'])) {
                $request['where'] = [];
            }
            $request['where'][] = [
                'operator' => 'IN',
                'column'   => 'extension',
                'value'    => $this->attributes['file_types']
            ];
            $request['limit']   = !empty($this->attributes['limit']) ? $this->attributes['limit'] : 10;
        }

        return $this->datagrid->load($request);
    }

    public function prepareAttributesJs()
    {
        $attributes = [
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

        return $attributes;
    }

}
