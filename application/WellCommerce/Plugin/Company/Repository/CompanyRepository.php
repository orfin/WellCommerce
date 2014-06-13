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
namespace WellCommerce\Plugin\Company\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Company\Model\Company;

/**
 * Class CompanyAbstractRepository
 *
 * @package WellCommerce\Plugin\Company\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyRepository extends AbstractRepository implements CompanyRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Company::with('shop', 'shop.translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Company::findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $company = $this->find($id);
        $company->delete();
        $this->dispatchEvent(CompanyRepositoryInterface::POST_DELETE_EVENT, $company);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $company = Company::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(CompanyRepositoryInterface::PRE_SAVE_EVENT, $company, $data);

            $company->update($data);

            $this->dispatchEvent(CompanyRepositoryInterface::POST_SAVE_EVENT, $company, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCompanyToSelect()
    {
        return $this->all()->toSelect('id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function getShopsTree()
    {
        $tree      = [];
        $companies = $this->all();

        foreach ($companies as $company) {
            $shops = $company->shop;

            // add only companies having related shops
            if (!$shops->isEmpty()) {
                $tree[$company->id] = [
                    'id'       => $company->id,
                    'name'     => $company->name,
                    'parent'   => null,
                    'children' => []
                ];

                foreach ($shops as $shop) {

                    // fetch translations
                    $translation = $shop->translation()->hasLanguageId($this->getCurrentLanguage());

                    $tree[$company->id]['children'][$shop->id] = [
                        'id'   => $shop->id,
                        'name' => $translation->name,
                    ];
                }
            }

        }

        return $tree;
    }
}