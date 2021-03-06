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
namespace WellCommerce\Plugin\Producer\Repository;

use WellCommerce\Core\Repository;
use WellCommerce\Plugin\Producer\Model\Producer;
use WellCommerce\Plugin\Producer\Model\ProducerTranslation;

/**
 * Class ProducerRepository
 *
 * @package WellCommerce\Plugin\Producer\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerRepository extends Repository
{
    /**
     * Returns producer collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Producer::all();
    }

    /**
     * Returns single producer model with all shop and deliverer data
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return Producer::with('translation', 'shop', 'deliverer')->findOrFail($id);
    }

    /**
     * Deletes producer by key or multiple producers if array of ids is passed
     *
     * @param array|int $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Producer::destroy($id);
        });
    }

    /**
     * Saves producer model
     *
     * @param array    $Data Submitted form data
     * @param int|null $id   Producer ID or null if new producer
     */
    public function save(array $Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {
            $producer = Producer::firstOrNew([
                'id' => $id
            ]);

            $producer->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = ProducerTranslation::firstOrNew([
                    'producer_id' => $producer->id,
                    'language_id' => $language
                ]);

                $translation->setTranslationData($Data, $language);
                $translation->save();
            }

            $producer->sync($producer->deliverer(), $Data['deliverers']);
            $producer->sync($producer->shop(), $Data['shops']);
        });
    }

    /**
     * Returns array containing values needed to populate the form
     *
     * @param int $id Producer ID
     *
     * @return array Populate data
     */
    public function getPopulateData($id)
    {
        $producerData = $this->find($id);
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $producerData->getTranslationData();

        $accessor->setValue($populateData, '[required_data]', [
            'language_data' => $languageData,
            'deliverers'    => $producerData->getDeliverers(),
        ]);

        $accessor->setValue($populateData, '[description_data][language_data]', $languageData);

        $accessor->setValue($populateData, '[meta_data][language_data]', $languageData);

        $accessor->setValue($populateData, '[shop_data][shops]', $producerData->getShops());

        return $populateData;
    }

    /**
     * Returns Collection as ke-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllProducerToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}