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
 * Class DelivererTranslation
 *
 * @package WellCommerce\Plugin\Deliverer\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererTranslation extends Model
{

    public $timestamps = true;

    protected $table = 'deliverer_translation';

    protected $softDelete = false;

    protected $fillable = ['deliverer_id', 'language_id', 'name'];

    protected $translatable = ['name'];
}