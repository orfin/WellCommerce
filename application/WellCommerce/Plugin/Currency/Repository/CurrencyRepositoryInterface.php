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

namespace WellCommerce\Plugin\Currency\Repository;

/**
 * Interface CurrencyRepositoryInterface
 *
 * @package WellCommerce\Plugin\Currency\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyRepositoryInterface
{
    const POST_DELETE_EVENT = 'currency.repository.post_delete';
    const PRE_SAVE_EVENT    = 'currency.repository.pre_save';
    const POST_SAVE_EVENT   = 'currency.repository.post_save';

    /**
     * Returns all currencies as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a currency model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Currency\Model\Currency
     */
    public function find($id);

    /**
     * Adds or updates a currency
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a currency
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Returns Collection as ke-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllCurrencyToSelect();

    /**
     * Returns all currency symbols
     *
     * @return mixed
     */
    public function getCurrencySymbols();
}