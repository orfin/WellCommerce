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
namespace WellCommerce\Plugin\Contact\Model;

use WellCommerce\Core\Model;

/**
 * Class ContactTranslation
 *
 * @package WellCommerce\Plugin\Contact\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTranslation extends Model
{

    protected $table = 'contact_translation';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['contact_id', 'language_id'];

    protected $translatable = ['name', 'email', 'phone', 'street', 'streetno', 'flatno', 'province', 'city', 'country'];
}