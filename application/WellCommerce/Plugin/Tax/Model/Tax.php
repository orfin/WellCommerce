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
namespace WellCommerce\Core\Model;

use WellCommerce\Core\Model;

/**
 * Class Tax
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tax extends Model
{

    protected $table = 'tax';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id', 'value'];

    public function translation()
    {
        return $this->hasMany('WellCommerce\Core\Model\TaxTranslation');
    }

    /**
     * Get translations for tax rate
     *
     * @return array
     */
    public function getLanguageData()
    {
        $languageData = [];
        foreach ($this->translation as $translation) {
            $languageData[$translation->language_id] = [
                'name' => $translation->name,
            ];
        }

        return $languageData;
    }
}