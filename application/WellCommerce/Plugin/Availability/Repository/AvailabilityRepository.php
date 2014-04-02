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
namespace WellCommerce\Plugin\Availability\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Availability\Model\Availability;
use WellCommerce\Plugin\Availability\Model\AvailabilityTranslation;

/**
 * Class AvailabilityAbstractRepository
 *
 * @package WellCommerce\Plugin\Availability\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityRepository extends AbstractRepository
{

    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Availability::all();
    }

    /**
     * Returns a single tax rate
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return Availability::with('translation')->findOrFail($id);
    }

    /**
     * Deletes availability record by ID
     *
     * @param int $id availability ID to delete
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Availability::destroy($id);
        });
    }

    /**
     * Saves availability
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {

            $availability = Availability::firstOrNew([
                'id' => $id
            ]);

            $availability->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = AvailabilityTranslation::firstOrNew([
                    'availability_id' => $availability->id,
                    'language_id'     => $language
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
        $availabilityData = $this->find($id);
        $populateData     = [];
        $accessor         = $this->getPropertyAccessor();
        $languageData     = $availabilityData->getTranslationData();

        $accessor->setValue($populateData, '[required_data]', [
            'language_data' => $languageData,
        ]);

        return $populateData;
    }
}
