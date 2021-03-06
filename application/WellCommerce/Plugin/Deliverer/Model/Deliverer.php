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
namespace WellCommerce\Plugin\Deliverer\Model;

use WellCommerce\Core\Model;

/**
 * Class Deliverer
 *
 * @package WellCommerce\Plugin\Deliverer\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Deliverer extends Model implements Model\TranslatableModelInterface
{

    /**
     * @var string
     */
    protected $table = 'deliverer';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    /**
     * Relation with deliverer_translation table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translation()
    {
        return $this->hasMany('WellCommerce\Plugin\Deliverer\Model\DelivererTranslation');
    }

    /**
     * Get translations for deliverer
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