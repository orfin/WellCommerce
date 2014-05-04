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
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\Company\Model\Company;

/**
 * Class CompanyAbstractRepository
 *
 * @package WellCommerce\Plugin\Company\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyRepository extends AbstractRepository implements RepositoryInterface
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
        $this->dispatchEvent(CompanyRepositoryEvents::PRE_DELETE, [], $id);

        $this->transaction(function () use ($id) {
            return Company::destroy($id);
        });

        $this->dispatchEvent(CompanyRepositoryEvents::POST_DELETE, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(CompanyRepositoryEvents::PRE_SAVE, $data, $id);

        $this->transaction(function () use ($data, $id) {

            $accessor = $this->getPropertyAccessor();

            $company = Company::firstOrNew([
                'id' => $id
            ]);

            $company->name       = $accessor->getValue($data, '[required_data][name]');
            $company->short_name = $accessor->getValue($data, '[required_data][short_name]');
            $company->street     = $accessor->getValue($data, '[address_data][street]');
            $company->streetno   = $accessor->getValue($data, '[address_data][streetno]');
            $company->flatno     = $accessor->getValue($data, '[address_data][flatno]');
            $company->province   = $accessor->getValue($data, '[address_data][province]');
            $company->postcode   = $accessor->getValue($data, '[address_data][postcode]');
            $company->city       = $accessor->getValue($data, '[address_data][city]');
            $company->country    = $accessor->getValue($data, '[address_data][country]');
            $company->save();
        });

        $this->dispatchEvent(CompanyRepositoryEvents::POST_SAVE, $data, $id);
    }

    /**
     * Gets all companies and returns them as key-value pairs
     *
     * @return array
     */
    public function getAllCompanyToSelect()
    {
        $companies = $this->all();
        $Data      = Array();
        foreach ($companies as $company) {
            $Data[$company->id] = $company->name;
        }

        return $Data;
    }

    /**
     * Returns a tree containing all companies and related shops
     *
     * @return array
     */
    public function getShopsTree()
    {
        $tree      = [];
        $companies = $this->all();

        foreach ($companies as $company) {
            $tree[$company->id] = [
                'id'       => $company->id,
                'name'     => $company->name,
                'parent'   => null,
                'children' => []
            ];

            foreach ($company->shop as $shop) {

                $translation = $shop->translation()->hasLanguageId($this->getCurrentLanguage());

                $tree[$company->id]['children'][$shop->id] = [
                    'id'   => $shop->id,
                    'name' => $translation->name,
                ];
            }
        }

        return $tree;
    }
}