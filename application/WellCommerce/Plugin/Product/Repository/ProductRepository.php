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
namespace WellCommerce\Plugin\Product\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Product\Model\Product;
use WellCommerce\Plugin\Product\Model\ProductTranslation;

/**
 * Class ProductAbstractRepository
 *
 * @package WellCommerce\Plugin\Product\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Product::with('translation', 'shop', 'deliverer', 'photos', 'category')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Product::with('translation', 'shop', 'deliverer', 'photos', 'category')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(ProductRepositoryInterface::PRE_DELETE_EVENT, [], $id);

        $this->transaction(function () use ($id) {
            return Product::destroy($id);
        });

        $this->dispatchEvent(ProductRepositoryInterface::POST_DELETE_EVENT, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(ProductRepositoryInterface::PRE_SAVE_EVENT, $data, $id);

        $this->transaction(function () use ($data, $id) {
            $product = Product::firstOrCreate([
                'id' => $id
            ]);

            // handle photos
            $data['photo_id'] = $this->checkMainPhoto($data['photo'], $product);
            $photos           = $this->checkPhotos($data['photo'], $product);
            $product->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = ProductTranslation::firstOrNew([
                    'product_id'  => $product->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $product->sync($product->deliverer(), $data['deliverers']);
            $product->sync($product->category(), $data['category']);
            $product->sync($product->shop(), $data['shops']);
            $product->sync($product->photos(), $photos);
        });

        $this->dispatchEvent(ProductRepositoryInterface::POST_SAVE_EVENT, $data, $id);
    }

    /**
     * Checks whether product photo has been updated
     * If there was no modification previous value is used
     *
     * @param array   $data
     * @param Product $product
     *
     * @return mixed|null
     */
    private function checkMainPhoto(array $photos, Product $product)
    {
        if (0 == $photos['unmodified']) {
            if (isset($photos['main'])) {
                return $photos['main'];
            } else {
                return null;
            }
        } else {
            return $product->photo_id;
        }
    }

    private function checkPhotos(array $photos, Product $product)
    {
        if (0 == $photos['unmodified']) {
            $photos = array_filter(array_map(function ($key, $value) {
                if (!is_array($key) && is_int($key) && ($value > 0)) {
                    return $value;
                }
            }, array_keys($photos), array_values($photos)));
        } else {
            return $product->photos->getPrimaryKeys();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateDataGridRow(array $request)
    {
        $id   = $request['id'];
        $data = $request['data'];

        $data = $this->dispatchEvent(ProductRepositoryInterface::PRE_UPDATE_DATAGRID_EVENT, $data, $id);

        $this->transaction(function () use ($id, $data) {
            $product = $this->find($id);
            $product->update($data);
        });

        $this->dispatchEvent(ProductRepositoryInterface::POST_UPDATE_DATAGRID_EVENT, $data, $id);

        return [
            'updated' => true
        ];
    }
}