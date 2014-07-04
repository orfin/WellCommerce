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
 * Class AttributeGroupTranslation
 *
 * @package WellCommerce\Plugin\Attribute\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupTranslation extends AbstractModel implements ModelInterface
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'attribute_group_translation';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['attribute_group_id', 'language_id'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}
