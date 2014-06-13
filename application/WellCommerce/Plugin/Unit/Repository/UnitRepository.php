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
namespace WellCommerce\Plugin\Unit\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Unit\Model\Unit;
use WellCommerce\Plugin\Unit\Model\UnitTranslation;

/**
 * Class UnitRepository
 *
 * @package WellCommerce\Plugin\Unit\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitRepository extends AbstractRepository implements UnitRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Unit::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Unit::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $unit = $this->find($id);
        $unit->delete();
        $this->dispatchEvent(UnitRepositoryInterface::POST_DELETE_EVENT, $unit);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $unit = Unit::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(UnitRepositoryInterface::PRE_SAVE_EVENT, $unit, $data);

            $unit->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = UnitTranslation::firstOrCreate([
                    'unit_id'      => $unit->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(UnitRepositoryInterface::POST_SAVE_EVENT, $unit, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllUnitToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}