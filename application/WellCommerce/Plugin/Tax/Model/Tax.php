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
namespace WellCommerce\Plugin\Tax\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;

/**
 * Class Tax
 *
 * @package WellCommerce\Plugin\Tax\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tax extends AbstractModel implements TranslatableModelInterface
{

    protected $table = 'tax';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id', 'value'];

    public function translation()
    {
        return $this->hasMany('WellCommerce\Plugin\Tax\\Model\TaxTranslation');
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