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
 * Class ProducerDeliverer
 *
 * @package WellCommerce\Plugin\Producer\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDeliverer extends AbstractModel
{

    protected $table = 'producer_deliverer';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['producer_id', 'deliverer_id'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}