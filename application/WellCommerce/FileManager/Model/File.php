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
namespace WellCommerce\FileManager\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;

/**
 * Class File
 *
 * @package WellCommerce\File\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class File extends AbstractModel implements ModelInterface
{
    public $timestamps = true;
    protected $table = 'file';
    protected $softDelete = false;
    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}