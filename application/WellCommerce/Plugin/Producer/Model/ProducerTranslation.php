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
namespace WellCommerce\Plugin\Producer\Model;

use WellCommerce\Core\Component\Model\AbstractModel;

/**
 * Class ProducerTranslation
 *
 * @package WellCommerce\Plugin\Producer\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerTranslation extends AbstractModel
{
    protected $table = 'producer_translation';
    protected $fillable = ['producer_id','language_id'];

    /**
     * Relation with producer table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producer()
    {
        return $this->belongsTo('WellCommerce\Plugin\Producer\Model\Producer');
    }

    /**
     * Relation with language table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('WellCommerce\Plugin\Language\Model\Language');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}