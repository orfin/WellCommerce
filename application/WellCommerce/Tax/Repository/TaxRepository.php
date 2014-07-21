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
namespace WellCommerce\Tax\Repository;

use WellCommerce\Core\Repository\AbstractRepository;
use WellCommerce\Tax\Model\Tax;
use WellCommerce\Tax\Model\TaxTranslation;

/**
 * Class TaxRepository
 *
 * @package WellCommerce\Tax\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxRepository extends AbstractRepository implements TaxRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Tax::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Tax::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $tax = $this->find($id);
        $tax->delete();
        $this->dispatchEvent(TaxRepositoryInterface::POST_DELETE_EVENT, $tax);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $tax = Tax::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(TaxRepositoryInterface::PRE_SAVE_EVENT, $tax, $data);

            $tax->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = TaxTranslation::firstOrCreate([
                    'tax_id'      => $tax->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(TaxRepositoryInterface::POST_SAVE_EVENT, $tax, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllTaxToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}