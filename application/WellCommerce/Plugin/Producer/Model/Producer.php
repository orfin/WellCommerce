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
    /**
     * @var string
     */
    protected $table = 'producer';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array
     */
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
        return $this->belongsToMany('WellCommerce\Plugin\Shop\Model\Shop', 'producer_shop', 'producer_id', 'shop_id');
    }

    /**
     * Relation with Deliverer model through pivot table producer_deliverer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliverer()
    {
        return $this->belongsToMany('WellCommerce\Plugin\Deliverer\Model\Deliverer', 'producer_deliverer', 'producer_id', 'deliverer_id');
    }

    /**
     * Fetch shop ids from model
     *
     * @return array
     */
    public function getShops()
    {
        $shops = [];
        foreach ($this->shop as $shop) {
            $shops[] = $shop->id;
        }

        return $shops;
    }

    /**
     * Fetch deliverer ids from model
     *
     * @return array
     */
    public function getDeliverers()
    {
        $deliverers = [];
        foreach ($this->deliverer as $deliverer) {
            $deliverers[] = $deliverer->id;
        }

        return $deliverers;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}