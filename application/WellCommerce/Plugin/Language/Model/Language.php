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
namespace WellCommerce\Plugin\Language\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Class Language
 *
 * @package WellCommerce\Plugin\Language\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Language extends AbstractModel implements ModelInterface
{
    protected $table = 'language';
    protected $fillable = ['id'];

    public function currency()
    {
        return $this->belongsTo('WellCommerce\Plugin\Currency\Model\Currency');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}