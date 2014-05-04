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
namespace WellCommerce\Plugin\ClientGroup\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\ClientGroup\Model\ClientGroup;
use WellCommerce\Plugin\ClientGroup\Model\ClientGroupTranslation;

/**
 * Class ClientGroupRepository
 *
 * @package WellCommerce\Plugin\ClientGroup\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return ClientGroup::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return ClientGroup::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(ClientGroupRepositoryEvents::PRE_DELETE, [], $id);

        $this->transaction(function () use ($id) {
            return ClientGroup::destroy($id);
        });

        $this->dispatchEvent(ClientGroupRepositoryEvents::POST_DELETE, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(ClientGroupRepositoryEvents::PRE_SAVE, $data, $id);

        $this->transaction(function () use ($data, $id) {

            $accessor = $this->getPropertyAccessor();

            $clientGroup = ClientGroup::firstOrNew([
                'id' => $id
            ]);

            $clientGroup->discount = $accessor->getValue($data, '[required_data][discount]');
            $clientGroup->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = ClientGroupTranslation::firstOrNew([
                    'client_group_id' => $clientGroup->id,
                    'language_id'     => $language
                ]);

                $languageData = $accessor->getValue($data, sprintf('[required_data][language_data][%s]', $language));

                $translation->setTranslationData($languageData);
                $translation->save();
            }
        });

        $this->dispatchEvent(ClientGroupRepositoryEvents::POST_SAVE, $data, $id);
    }
}