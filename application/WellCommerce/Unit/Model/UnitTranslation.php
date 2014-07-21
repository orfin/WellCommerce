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
namespace WellCommerce\Unit\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Model;

/**
 * Class UnitTranslation
 *
 * @package WellCommerce\Unit\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitTranslation extends AbstractModel implements ModelInterface
{
    protected $table = 'unit_translation';
    protected $fillable = ['unit_id', 'language_id'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}