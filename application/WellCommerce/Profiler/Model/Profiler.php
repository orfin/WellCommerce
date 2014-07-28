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
namespace WellCommerce\Profiler\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Helper\Helper;

/**
 * Class Profiler
 *
 * @package WellCommerce\Profiler\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Profiler extends AbstractModel implements ModelInterface
{
    protected $table = 'profiler_data';
    protected $fillable = ['id', 'token'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}