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
namespace WellCommerce\PaymentMethod\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;

/**
 * Class PaymentMethodAbstractRepository
 *
 * @package WellCommerce\PaymentMethod\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodRepository extends AbstractRepository implements PaymentMethodRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->get('payment_method.model')->with('translation', 'shop')->all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->get('payment_method.model')->with('translation', 'shop')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $paymentMethod = $this->find($id);
        $paymentMethod->delete();
        $this->dispatchEvent(PaymentMethodRepositoryInterface::POST_DELETE_EVENT, $paymentMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {
            $payment_method = PaymentMethod::firstOrNew([
                'id' => $id
            ]);

            $payment_method->enabled          = $Data['enabled'];
            $payment_method->ean              = $Data['ean'];
            $payment_method->sku              = $Data['sku'];
            $payment_method->producer_id      = $Data['producer_id'];
            $payment_method->stock            = $Data['stock'];
            $payment_method->track_stock      = $Data['track_stock'];
            $payment_method->tax_id           = $Data['tax_id'];
            $payment_method->sell_currency_id = $Data['sell_currency_id'];
            $payment_method->buy_currency_id  = $Data['buy_currency_id'];
            $payment_method->buy_price        = $Data['buy_price'];
            $payment_method->sell_price       = $Data['sell_price'];
            $payment_method->weight           = $Data['weight'];
            $payment_method->width            = $Data['width'];
            $payment_method->height           = $Data['height'];
            $payment_method->depth            = $Data['depth'];
            $payment_method->package_size     = $Data['package_size'];
            $payment_method->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = PaymentMethodTranslation::firstOrNew([
                    'payment_method_id'  => $payment_method->id,
                    'language_id' => $language
                ]);

                $translation->setTranslationData($Data, $language);
                $translation->save();
            }

            $payment_method->sync($payment_method->deliverer(), $Data['deliverers']);
            $payment_method->sync($payment_method->category(), $Data['category']);
            $payment_method->sync($payment_method->shop(), $Data['shops']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllPaymentMethodToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}