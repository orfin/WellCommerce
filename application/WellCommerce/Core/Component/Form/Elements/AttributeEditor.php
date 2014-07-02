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
namespace WellCommerce\Core\Component\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Plugin\Attribute\Repository\AttributeRepositoryInterface;

/**
 * Class AttributeEditor
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeEditor extends Field implements ElementInterface
{
    /**
     * @var AttributeRepositoryInterface Repository
     */
    private $repository;

    public function __construct($attributes, AttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;

        $attributes['attributes'] = App::getModel('attributeproduct/attributeproduct')->getAttributeProductFull();
        parent::__construct($attributes);
        App::getRegistry()->xajaxInterface->registerFunction(array(
            'DeleteAttribute',
            $this,
            'deleteAttribute'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            'RenameAttribute',
            $this,
            'renameAttribute'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            'RenameValue',
            $this,
            'renameValue'
        ));
        $this->attributes['deleteAttributeFunction'] = 'xajax_DeleteAttribute';
        $this->attributes['renameAttributeFunction'] = 'xajax_RenameAttribute';
        $this->attributes['renameValueFunction']     = 'xajax_RenameValue';
    }

    public function renameAttribute($request)
    {
        $status  = true;
        $message = '';
        try {
            App::getModel('attributegroup')->RenameAttribute($request['id'], $request['name']);
        } catch (Exception $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return Array(
            'status'  => $status,
            'message' => $message
        );
    }

    public function renameValue($request)
    {
        $status  = true;
        $message = '';
        try {
            App::getModel('attributegroup')->RenameValue($request['id'], $request['name']);
        } catch (Exception $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return Array(
            'status'  => $status,
            'message' => $message
        );
    }

    public function deleteAttribute($request)
    {
        $status  = true;
        $message = '';
        try {
            App::getModel('attributegroup')->RemoveAttributeFromGroup($request['id'], $request['set_id']);
            App::getModel('attributegroup')->DeleteAttribute($request['id']);
        } catch (Exception $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return Array(
            'status'  => $status,
            'message' => $message
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
            'set',
            'attributes',
            'onAfterDelete',
            'deleteAttributeFunction',
            'renameAttributeFunction',
            'renameValueFunction',
        ]);

        $resolver->setOptional([
            'error',
            'comment',
        ]);

        $resolver->setDefaults([
            'attributes',
            'comment',
        ]);

        $resolver->setAllowedTypes([
            'name'                    => ['int', 'string'],
            'label'                   => 'string',
            'set'                     => ['int', 'string'],
            'attributes'              => 'array',
            'onAfterDelete'           => 'string',
            'deleteAttributeFunction' => 'string',
            'renameAttributeFunction' => 'string',
            'renameValueFunction'     => 'string'
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
            $this->formatAttributeJs('set', 'sSetId'),
            $this->formatAttributeJs('attributes', 'aoAttributes', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('onAfterDelete', 'fOnAfterDelete', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('deleteAttributeFunction', 'fDeleteAttribute', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('renameAttributeFunction', 'fRenameAttribute', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('renameValueFunction', 'fRenameValue', ElementInterface::TYPE_FUNCTION),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }
}
