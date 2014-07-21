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
namespace WellCommerce\ShippingMethod\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;

/**
 * Class ShippingMethod
 *
 * @package WellCommerce\ShippingMethod\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethod extends AbstractModel implements ModelInterface
{
    protected $table = 'shipping_method';

    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translation()
    {
        return $this->hasMany(__NAMESPACE__ . '\ShippingMethodTranslation');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }

}