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
namespace WellCommerce\Layout\Model;

use WellCommerce\Core\Component\Model\AbstractModel;

/**
 * Class LayoutTheme
 *
 * @package WellCommerce\LayoutTheme\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutTheme extends AbstractModel
{
    protected $table = 'layout_theme';
    protected $fillable = ['id'];
}