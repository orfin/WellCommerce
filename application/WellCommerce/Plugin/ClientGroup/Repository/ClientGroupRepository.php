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
class ClientGroupRepository extends AbstractRepository implements ClientGroupRepositoryInterface
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
        $this->dispatchEvent(ClientGroupRepositoryInterface::PRE_DELETE_EVENT, [], $id);

        $this->transaction(function () use ($id) {
            return ClientGroup::destroy($id);
        });

        $this->dispatchEvent(ClientGroupRepositoryInterface::POST_DELETE_EVENT, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(ClientGroupRepositoryInterface::PRE_SAVE_EVENT, $data, $id);

        $this->transaction(function () use ($data, $id) {

            $clientGroup = ClientGroup::firstOrCreate([
                'id' => $id
            ]);

            $clientGroup->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = ClientGroupTranslation::firstOrCreate([
                    'client_group_id' => $clientGroup->id,
                    'language_id'     => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }
        });

        $this->dispatchEvent(ClientGroupRepositoryInterface::POST_SAVE_EVENT, $data, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllClientGroupToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}