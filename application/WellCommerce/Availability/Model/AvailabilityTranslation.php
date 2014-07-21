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
namespace WellCommerce\Availability\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;

/**
 * Class AvailabilityTranslation
 *
 * @package WellCommerce\Availability\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityTranslation extends AbstractModel implements ModelInterface
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'availability_translation';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['availability_id', 'language_id'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}
