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
namespace WellCommerce\Plugin\Cart\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Cart\Model\Cart;
use WellCommerce\Plugin\Cart\Model\CartTranslation;

/**
 * Class CartAbstractRepository
 *
 * @package WellCommerce\Plugin\Cart\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartRepository extends AbstractRepository implements CartRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Cart::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Cart::with('item')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $contact = $this->find($id);
        $contact->delete();
        $this->dispatchEvent(CartRepositoryInterface::POST_DELETE_EVENT, $contact);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $contact = Cart::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(CartRepositoryInterface::PRE_SAVE_EVENT, $contact, $data);

            $contact->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = CartTranslation::firstOrCreate([
                    'contact_id'  => $contact->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(CartRepositoryInterface::POST_SAVE_EVENT, $contact, $data);
        });
    }
}