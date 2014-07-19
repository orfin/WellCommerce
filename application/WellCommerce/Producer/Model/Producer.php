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
namespace WellCommerce\Producer\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;

/**
 * Class Producer
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Producer extends AbstractModel implements ModelInterface, TranslatableModelInterface
{
    protected $table = 'producer';
    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translation()
    {
        return $this->hasMany(__NAMESPACE__ . '\ProducerTranslation');
    }

    /**
     * Relation with Shop model through pivot table producer_shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shop()
    {
        return $this->belongsToMany('WellCommerce\Shop\Model\Shop', 'producer_shop', 'producer_id', 'shop_id');
    }

    /**
     * Relation with Deliverer model through pivot table producer_deliverer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliverer()
    {
        return $this->belongsToMany('WellCommerce\Deliverer\Model\Deliverer', 'producer_deliverer', 'producer_id', 'deliverer_id');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}