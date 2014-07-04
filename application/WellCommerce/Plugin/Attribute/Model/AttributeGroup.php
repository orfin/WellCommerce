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
namespace WellCommerce\Plugin\Attribute\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Class Attribute
 *
 * @package WellCommerce\Plugin\Attribute\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroup extends AbstractModel implements ModelInterface
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'attribute_group';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translations()
    {
        return $this->hasMany(__NAMESPACE__ . '\AttributeGroupTranslation');
    }

    public function attributes()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\Attribute', 'attribute_group_attribute', 'attribute_id', 'attribute_id');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}
