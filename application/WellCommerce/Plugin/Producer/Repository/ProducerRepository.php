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
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\Producer\Model\Producer;
use WellCommerce\Plugin\Producer\Model\ProducerTranslation;

/**
 * Class ProducerAbstractRepository
 *
 * @package WellCommerce\Plugin\Producer\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerRepository extends AbstractRepository implements RepositoryInterface
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
        $this->dispatchEvent(ProducerRepositoryEvents::PRE_DELETE, [], $id);

        $this->transaction(function () use ($id) {
            return Producer::destroy($id);
        });

        $this->dispatchEvent(ProducerRepositoryEvents::POST_DELETE, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(ProducerRepositoryEvents::PRE_SAVE, $data, $id);

        $this->transaction(function () use ($data, $id) {

            $accessor = $this->getPropertyAccessor();

            $producer = Producer::firstOrNew([
                'id' => $id
            ]);

            $producer->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = ProducerTranslation::firstOrNew([
                    'producer_id' => $producer->id,
                    'language_id' => $language
                ]);

                // set translations from required_data pane
                $languageData = $accessor->getValue($data, sprintf('[required_data][language_data][%s]', $language));
                $translation->setTranslationData($languageData);

                // set translations from description_data pane
                $descData = $accessor->getValue($data, sprintf('[description_data][language_data][%s]', $language));
                $translation->setTranslationData($descData);

                // set translations from meta_data pane
                $metaData = $accessor->getValue($data, sprintf('[meta_data][language_data][%s]', $language));
                $translation->setTranslationData($metaData);


                $translation->save();
            }

            $producer->sync($producer->deliverer(), $accessor->getValue($data, '[required_data][deliverers]'));
            $producer->sync($producer->shop(), $accessor->getValue($data, '[shop_data][shops]'));
        });

        $this->dispatchEvent(ProducerRepositoryEvents::POST_SAVE, $data, $id);
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