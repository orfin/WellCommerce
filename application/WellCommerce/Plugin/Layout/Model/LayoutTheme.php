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
namespace WellCommerce\Plugin\Layout\Model;

use WellCommerce\Core\Model;

/**
 * Class LayoutTheme
 *
 * @package WellCommerce\Plugin\LayoutTheme\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutTheme extends Model
{

    protected $table = 'layout_theme';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];
}