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
namespace WellCommerce\Shop\Repository;

use WellCommerce\Core\Repository\AbstractRepository;
use WellCommerce\Core\Repository\RepositoryInterface;
use WellCommerce\Shop\Model\Shop;
use WellCommerce\Shop\Model\ShopTranslation;

/**
 * Class ShopAbstractRepository
 *
 * @package WellCommerce\Shop\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopRepository extends AbstractRepository implements ShopRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Shop::with('translation', 'company')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Shop::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $shop = $this->find($id);
        $shop->delete();
        $this->dispatchEvent(ShopRepositoryInterface::POST_DELETE_EVENT, $shop);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $shop = Shop::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(ShopRepositoryInterface::PRE_SAVE_EVENT, $shop, $data);

            $shop->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = ShopTranslation::firstOrNew([
                    'shop_id'     => $shop->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(ShopRepositoryInterface::POST_SAVE_EVENT, $shop, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function updateDataGridRow(array $request)
    {
        $id   = $request['id'];
        $data = $request['data'];

        $this->transaction(function () use ($id, $data) {
            $shop = $this->find($id);
            $data = $this->dispatchEvent(ShopRepositoryInterface::PRE_UPDATE_DATAGRID_EVENT, $shop, $data);
            $shop->update($data);
            $this->dispatchEvent(ShopRepositoryInterface::POST_UPDATE_DATAGRID_EVENT, $shop, $data);
        });

        return [
            'updated' => true
        ];
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
        $shopData     = $this->find($id);
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $shopData->getTranslationData();

        $accessor->setValue($populateData, '[required_data]', [
            'url'             => $shopData->url,
            'offline'         => $shopData->offline,
            'company_id'      => $shopData->company_id,
            'layout_theme_id' => $shopData->layout_theme_id,
            'language_data'   => $languageData
        ]);

        $accessor->setValue($populateData, '[meta_data]', [
            'language_data' => $languageData
        ]);

        return $populateData;
    }

    /**
     * Returns Collection as key-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllShopToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }

    /**
     * Returns current shop by host name
     *
     * @return mixed
     */
    public function getShopByHost()
    {
        $host = $this->getRequest()->getHttpHost();
        $shop = $this->getDb()
            ->table('shop')
            ->join('shop_translation', 'shop_translation.shop_id', '=', 'shop.id')
            ->where('shop.url', '=', $host)
            ->groupBy('shop.id')->first();

        return $shop;
    }
}