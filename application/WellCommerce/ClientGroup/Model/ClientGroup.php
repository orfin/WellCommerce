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
namespace WellCommerce\ClientGroup\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Model\TranslatableModelInterface;
use WellCommerce\Core\Helper\Helper;

/**
 * Class ClientGroup
 *
 * @package WellCommerce\ClientGroup\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroup extends AbstractModel implements ModelInterface, TranslatableModelInterface
{

    protected $table = 'client_group';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translation()
    {
        return $this->hasMany(__NAMESPACE__ . '\ClientGroupTranslation');
    }

    /**
     * Mutator for discount attribute
     *
     * @param $value
     */
    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = Helper::changeCommaToDot($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}