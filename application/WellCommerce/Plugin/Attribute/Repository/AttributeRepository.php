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
namespace WellCommerce\Plugin\Attribute\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Attribute\Model\Attribute;
use WellCommerce\Plugin\Attribute\Model\AttributeTranslation;

/**
 * Class AttributeAbstractRepository
 *
 * @package WellCommerce\Plugin\Attribute\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends AbstractRepository implements AttributeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Attribute::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Attribute::with('translation')->find($id);
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
                    'language_id'     => $language
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
}
