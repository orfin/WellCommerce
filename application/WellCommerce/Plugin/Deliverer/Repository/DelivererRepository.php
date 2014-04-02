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
namespace WellCommerce\Plugin\Deliverer\Repository;

use WellCommerce\Core\Model\DelivererTranslation;
use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Deliverer\Model\Deliverer;

/**
 * Class DelivererAbstractRepository
 *
 * @package WellCommerce\Plugin\Deliverer\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererRepository extends AbstractRepository
{

    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Deliverer::with('translation')->get();
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
        return Deliverer::with('translation')->findOrFail($id);
    }

    /**
     * Deletes tax rate by ID
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Deliverer::destroy($id);
        });
    }

    /**
     * Saves deliverer
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {
            $deliverer = Deliverer::firstOrNew([
                'id' => $id
            ]);

            $deliverer->save();

            foreach ($Data['name'] as $languageId => $name) {

                $translation = DelivererTranslation::firstOrNew([
                    'deliverer_id' => $deliverer->id,
                    'language_id'  => $languageId
                ]);

                $translation->name = $name;

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
        $delivererData = $this->find($id);

        return [
            'required_data' => [
                'language_data' => $delivererData->getLanguageData()
            ]
        ];
    }

    /**
     * Returns Collection as key-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllDelivererToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}