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

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;

/**
 * Class LayoutPageColumn
 *
 * @package WellCommerce\Layout\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutPageColumn extends AbstractModel implements ModelInterface
{
    protected $table = 'layout_page_column';
    protected $fillable = ['id', 'layout_page_id', 'layout_theme_id', 'width'];

    public function boxes()
    {
        return $this->hasMany(__NAMESPACE__ . '\LayoutPageColumnBox');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}