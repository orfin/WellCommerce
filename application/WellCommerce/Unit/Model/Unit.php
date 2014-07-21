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
use WellCommerce\Core\Model\TranslatableModelInterface;

/**
 * Class Unit
 *
 * @package WellCommerce\Unit\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Unit extends AbstractModel implements ModelInterface, TranslatableModelInterface
{
    protected $table = 'unit';
    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translation()
    {
        return $this->hasMany('WellCommerce\Unit\Model\UnitTranslation');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}