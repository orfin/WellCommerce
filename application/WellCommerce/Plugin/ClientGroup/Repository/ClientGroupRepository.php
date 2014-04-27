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
 * Class ClientGroupAbstractRepository
 *
 * @package WellCommerce\Plugin\ClientGroup\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupRepository extends AbstractRepository implements RepositoryInterface
{
    public function all()
    {
        return ClientGroup::with('translation')->get();
    }

    public function find($id)
    {
        return ClientGroup::with('translation')->findOrFail($id);
    }

    public function delete($id)
    {
        $this->dispatchEvent('client_group.repository.pre_delete', [], $id);

        $this->transaction(function () use ($id) {
            return ClientGroup::destroy($id);
        });

        $this->dispatchEvent('client_group.repository.post_delete', [], $id);
    }

    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent('client_group.repository.pre_save', $data, $id);

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

        $this->dispatchEvent('client_group.repository.post_save', $data, $id);
    }
}