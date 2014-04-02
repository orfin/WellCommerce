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
namespace WellCommerce\Plugin\Tax\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Tax\Model\Tax;
use WellCommerce\Plugin\Tax\Model\TaxTranslation;

/**
 * Class TaxAbstractRepository
 *
 * @package WellCommerce\Plugin\Tax\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxRepository extends AbstractRepository
{
    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Tax::all();
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
        return Tax::with('translation')->findOrFail($id);
    }

    /**
     * Deletes tax rate by ID
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Tax::destroy($id);
        });
    }

    /**
     * Saves tax rate
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {

            $tax = Tax::firstOrNew([
                'id' => $id
            ]);

            $tax->value = $Data['value'];
            $tax->save();

            foreach ($Data['name'] as $languageId => $name) {

                $translation = TaxTranslation::firstOrNew([
                    'tax_id'      => $tax->id,
                    'language_id' => $languageId
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
        $taxData = $this->find($id);

        return [
            'required_data' => [
                'value'         => $taxData->value,
                'language_data' => $taxData->getLanguageData()
            ]
        ];
    }

    /**
     * Returns Collection as ke-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllTaxToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}