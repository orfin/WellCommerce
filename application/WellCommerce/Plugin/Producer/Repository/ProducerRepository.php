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

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Producer\Model\Producer;
use WellCommerce\Plugin\Producer\Model\ProducerTranslation;

/**
 * Class ProducerAbstractRepository
 *
 * @package WellCommerce\Plugin\Producer\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerRepository extends AbstractRepository implements ProducerRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Producer::with('translation', 'shop', 'deliverer')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Producer::with('translation', 'shop', 'deliverer')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(ProducerRepositoryInterface::PRE_DELETE_EVENT, [], $id);

        $this->transaction(function () use ($id) {
            return Producer::destroy($id);
        });

        $this->dispatchEvent(ProducerRepositoryInterface::POST_DELETE_EVENT, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(ProducerRepositoryInterface::PRE_SAVE_EVENT, $data, $id);

        $this->transaction(function () use ($data, $id) {

            $producer = Producer::firstOrCreate([
                'id' => $id
            ]);

            $producer->update();

            foreach ($this->getLanguageIds() as $language) {

                $translation = ProducerTranslation::firstOrCreate([
                    'producer_id' => $producer->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $producer->sync($producer->deliverer(), $data['deliverers']);
            $producer->sync($producer->shop(), $data['shops']);
        });

        $this->dispatchEvent(ProducerRepositoryInterface::POST_SAVE_EVENT, $data, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProducerToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}