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
namespace WellCommerce\Deliverer\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Deliverer\Model\Deliverer;
use WellCommerce\Deliverer\Model\DelivererTranslation;

/**
 * Class DelivererAbstractRepository
 *
 * @package WellCommerce\Deliverer\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererRepository extends AbstractRepository implements DelivererRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Deliverer::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Deliverer::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $deliverer = $this->find($id);
        $deliverer->delete();
        $this->dispatchEvent(DelivererRepositoryInterface::POST_DELETE_EVENT, $deliverer);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {
            $deliverer = Deliverer::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(DelivererRepositoryInterface::PRE_SAVE_EVENT, $deliverer, $data);

            $deliverer->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = DelivererTranslation::firstOrCreate([
                    'deliverer_id' => $deliverer->id,
                    'language_id'  => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(DelivererRepositoryInterface::POST_SAVE_EVENT, $deliverer, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDelivererToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}