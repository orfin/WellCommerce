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

use WellCommerce\Core\Repository;
use WellCommerce\Plugin\Unit\Model\Unit;
use WellCommerce\Plugin\Unit\Model\UnitTranslation;

/**
 * Class UnitRepository
 *
 * @package WellCommerce\Plugin\Unit\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitRepository extends Repository
{

    /**
     * Returns Unit Collection
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Unit::all();
    }

    /**
     * Returns a Unit Model
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return Unit::with('translation')->findOrFail($id);
    }

    /**
     * Deletes Unit Model
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Unit::destroy($id);
        });

    }

    /**
     * Saves Unit
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {

            $unit = Unit::firstOrNew([
                'id' => $id
            ]);

            $unit->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = UnitTranslation::firstOrNew([
                    'unit_id'     => $unit->id,
                    'language_id' => $language
                ]);

                $translation->setTranslationData($Data, $language);
                $translation->save();
            }
        });
    }

    /**
     * Returns array containing values needed to populate the form
     *
     * @param $id
     *
     * @return array
     */
    public function getPopulateData($id)
    {
        $unitData = $this->find($id);
        $populateData     = [];
        $accessor         = $this->getPropertyAccessor();
        $languageData     = $unitData->getTranslationData();

        $accessor->setValue($populateData, '[required_data]', [
            'language_data' => $languageData,
        ]);

        return $populateData;
    }
}