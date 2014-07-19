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

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Attribute\Model\Attribute;
use WellCommerce\Attribute\Model\AttributeGroup;
use WellCommerce\Attribute\Model\AttributeGroupTranslation;
use WellCommerce\Attribute\Model\AttributeTranslation;

/**
 * Class AttributeRepository
 *
 * @package WellCommerce\Attribute\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends AbstractRepository implements AttributeGroupRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return AttributeGroup::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return AttributeGroup::with('translation')->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $attributeGroup = $this->find($id);
        $attributeGroup->delete();
        $this->dispatchEvent(AttributeGroupRepositoryInterface::POST_DELETE_EVENT, $attributeGroup);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $attributeGroup = AttributeGroup::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(AttributeGroupRepositoryInterface::PRE_SAVE_EVENT, $attributeGroup, $data);

            $attributeGroup->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = AttributeTranslation::firstOrCreate([
                    'attribute_id' => $attributeGroup->id,
                    'language_id'  => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(AttributeGroupRepositoryInterface::POST_SAVE_EVENT, $attributeGroup, $data);
        });
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
