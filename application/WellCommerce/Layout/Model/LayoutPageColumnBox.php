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
use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Class LayoutPageColumnBox
 *
 * @package WellCommerce\Layout\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutPageColumnBox extends AbstractModel implements ModelInterface
{
    protected $table = 'layout_page_column_box';
    protected $fillable = ['id', 'layout_page_column_id', 'layout_box_id', 'span'];

    public function box()
    {
        return $this->hasOne(__NAMESPACE__ . '\LayoutBox', 'id', 'layout_box_id');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}