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
namespace WellCommerce\ShippingMethod\Repository;

use WellCommerce\Core\Repository\AbstractRepository;

/**
 * Class ShippingMethodAbstractRepository
 *
 * @package WellCommerce\ShippingMethod\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodRepository extends AbstractRepository implements ShippingMethodRepositoryInterface
{
    /**
     * Returns shipping_method collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return ShippingMethod::all();
    }

    /**
     * Returns single shipping_method model with all shop and deliverer data
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return ShippingMethod::with('translation', 'shop', 'deliverer')->findOrFail($id);
    }

    /**
     * Deletes shipping_method by key or multiple shipping_methods if array of ids is passed
     *
     * @param array|int $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return ShippingMethod::destroy($id);
        });
    }

    /**
     * Saves shipping_method model
     *
     * @param array    $Data Submitted form data
     * @param int|null $id   ShippingMethod ID or null if new shipping_method
     */
    public function save(array $Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {
            $shipping_method = ShippingMethod::firstOrNew([
                'id' => $id
            ]);

            $shipping_method->enabled          = $Data['enabled'];
            $shipping_method->ean              = $Data['ean'];
            $shipping_method->sku              = $Data['sku'];
            $shipping_method->producer_id      = $Data['producer_id'];
            $shipping_method->stock            = $Data['stock'];
            $shipping_method->track_stock      = $Data['track_stock'];
            $shipping_method->tax_id           = $Data['tax_id'];
            $shipping_method->sell_currency_id = $Data['sell_currency_id'];
            $shipping_method->buy_currency_id  = $Data['buy_currency_id'];
            $shipping_method->buy_price        = $Data['buy_price'];
            $shipping_method->sell_price       = $Data['sell_price'];
            $shipping_method->weight           = $Data['weight'];
            $shipping_method->width            = $Data['width'];
            $shipping_method->height           = $Data['height'];
            $shipping_method->depth            = $Data['depth'];
            $shipping_method->package_size     = $Data['package_size'];
            $shipping_method->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = ShippingMethodTranslation::firstOrNew([
                    'shipping_method_id' => $shipping_method->id,
                    'language_id'        => $language
                ]);

                $translation->setTranslationData($Data, $language);
                $translation->save();
            }

            $shipping_method->sync($shipping_method->deliverer(), $Data['deliverers']);
            $shipping_method->sync($shipping_method->category(), $Data['category']);
            $shipping_method->sync($shipping_method->shop(), $Data['shops']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllShippingMethodToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}