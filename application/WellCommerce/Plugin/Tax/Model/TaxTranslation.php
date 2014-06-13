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
namespace WellCommerce\Plugin\Tax\Model;

use WellCommerce\Core\Component\Model\AbstractModel;

/**
 * Class TaxTranslation
 *
 * @package WellCommerce\Plugin\Tax\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxTranslation extends AbstractModel
{
    protected $table = 'tax_translation';
    protected $fillable = ['tax_id', 'language_id', 'name'];

    public function tax()
    {
        return $this->belongsTo('WellCommerce\Plugin\Tax\Model\Tax');
    }

    public function language()
    {
        return $this->belongsTo('WellCommerce\Plugin\Tax\Model\Language');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}