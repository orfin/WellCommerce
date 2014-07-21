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
namespace WellCommerce\Shop\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;

/**
 * Class ShopTranslation
 *
 * @package WellCommerce\Shop\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class ShopTranslation extends AbstractModel implements ModelInterface
{
    protected $table = 'shop_translation';
    protected $fillable = ['shop_id', 'language_id'];

    public function scopeHasLanguageId($query, $language)
    {
        return $query->whereLanguageId($language)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}