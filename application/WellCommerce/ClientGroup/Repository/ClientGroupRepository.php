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
namespace WellCommerce\ClientGroup\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\ClientGroup\Model\ClientGroup;
use WellCommerce\ClientGroup\Model\ClientGroupTranslation;

/**
 * Class ClientGroupRepository
 *
 * @package WellCommerce\ClientGroup\Repository
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
        $clientGroup = $this->find($id);
        $clientGroup->delete();
        $this->dispatchEvent(ClientGroupRepositoryInterface::POST_DELETE_EVENT, $clientGroup);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $clientGroup = ClientGroup::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(ClientGroupRepositoryInterface::PRE_SAVE_EVENT, $clientGroup, $data);

            $clientGroup->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = ClientGroupTranslation::firstOrCreate([
                    'client_group_id' => $clientGroup->id,
                    'language_id'     => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(ClientGroupRepositoryInterface::POST_SAVE_EVENT, $clientGroup, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function updateDataGridRow(array $request)
    {
        $id = $request['id'];
        $data = $request['data'];

        $this->transaction(function () use ($id, $data) {
            $clientGroup = $this->find($id);
            $data
                         = $this->dispatchEvent(ClientGroupRepositoryInterface::PRE_UPDATE_DATAGRID_EVENT, $clientGroup, $data);
            $clientGroup->update($data);
            $this->dispatchEvent(ClientGroupRepositoryInterface::POST_UPDATE_DATAGRID_EVENT, $clientGroup, $data);
        });

        return [
            'updated' => true
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAllClientGroupToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllClientGroupToFilter()
    {
        return $this->all()->toDataGridFilter('id', 'translation.name', $this->getCurrentLanguage());
    }
}