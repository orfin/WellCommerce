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
namespace WellCommerce\Attribute\Repository;

use WellCommerce\Core\Repository\AbstractRepository;
use WellCommerce\Attribute\Model\Attribute;
use WellCommerce\Attribute\Model\AttributeGroup;
use WellCommerce\Attribute\Model\AttributeGroupTranslation;
use WellCommerce\Attribute\Model\AttributeTranslation;

/**
 * Class AttributeAbstractRepository
 *
 * @package WellCommerce\Attribute\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends AbstractRepository implements AttributeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return AttributeGroup::with(['translations', 'attributes'])->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return AttributeGroup::with(['translations', 'attributes'])->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $attribute = $this->find($id);
        $attribute->delete();
        $this->dispatchEvent(AttributeRepositoryInterface::POST_DELETE_EVENT, $attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $attribute = Attribute::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(AttributeRepositoryInterface::PRE_SAVE_EVENT, $attribute, $data);

            $attribute->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = AttributeTranslation::firstOrCreate([
                    'attribute_id' => $attribute->id,
                    'language_id'  => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(AttributeRepositoryInterface::POST_SAVE_EVENT, $attribute, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllAttributeToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }

    public function getAllAttributeGroups()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeProductFull()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeGroup(array $request)
    {
        $id = $this->transaction(function () use ($request) {

            $attributeGroup = new AttributeGroup();
            $attributeGroup->save();

            $translation = AttributeGroupTranslation::firstOrCreate([
                'attribute_group_id' => $attributeGroup->id,
                'language_id'        => $this->getCurrentLanguage(),
            ]);

            $translation->name = $request['name'];
            $translation->save();

            return $attributeGroup->id;
        });

        return [
            'id' => $id
        ];
    }
}
