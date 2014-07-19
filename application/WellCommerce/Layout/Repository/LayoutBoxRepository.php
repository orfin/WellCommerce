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
namespace WellCommerce\Layout\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Layout\Model\LayoutBox;
use WellCommerce\Layout\Model\LayoutBoxTranslation;

/**
 * Class LayoutBoxAbstractRepository
 *
 * @package WellCommerce\LayoutBox\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRepository extends AbstractRepository implements LayoutBoxRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return LayoutBox::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return LayoutBox::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $layoutBox = $this->find($id);
        $layoutBox->delete();
        $this->dispatchEvent(LayoutBoxRepositoryInterface::POST_DELETE_EVENT, $layoutBox);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->filterValues($data);

        $this->transaction(function () use ($data, $id) {

            $layoutBox = LayoutBox::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(LayoutBoxRepositoryInterface::PRE_SAVE_EVENT, $layoutBox, $data);
            $layoutBox->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = LayoutBoxTranslation::firstOrCreate([
                    'layout_box_id' => $layoutBox->id,
                    'language_id'   => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(LayoutBoxRepositoryInterface::POST_SAVE_EVENT, $layoutBox, $data);
        });
    }

    /**
     * Filters passed values to avoid collisions with multiple form nodes
     *
     * @param array $data
     *
     * @return array
     */
    private function filterValues(array $data)
    {
        $filteredData             = $data['required_data'];
        $languageData             = $data['required_data']['language_data'];
        $type                     = $data['required_data']['type'];
        $filteredData['settings'] = $data[$type];

        foreach ($languageData as $attribute => $values) {
            $filteredData[$attribute] = $values;
        }

        return $filteredData;
    }


    public function getAllLayoutBoxToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name');
    }
}