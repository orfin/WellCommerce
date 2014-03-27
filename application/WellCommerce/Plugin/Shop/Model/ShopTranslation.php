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
 * Class ShopTranslation
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopTranslation extends Model
{

    protected $table = 'shop_translation';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['shop_id', 'language_id'];

    protected $translatable
        = [
            'name',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ];

    public function scopeHasLanguageId($query, $language)
    {
        return $query->whereLanguageId($language)->first();
    }
}