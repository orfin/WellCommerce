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
namespace WellCommerce\ClientGroup\Model;

use WellCommerce\Core\Component\Model\AbstractModel;

/**
 * Class ClientGroupTranslation
 *
 * @package WellCommerce\ClientGroup\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupTranslation extends AbstractModel
{

    /**
     * @var string
     */
    protected $table = 'client_group_translation';

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
    protected $fillable = ['client_group_id', 'language_id'];

    /**
     * @var array
     */
    protected $translatable = ['name'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}