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
namespace WellCommerce\Client\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Helper\Password;

/**
 * Class Client
 *
 * @package WellCommerce\Client\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Client extends AbstractModel implements ModelInterface
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'client';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    protected $hidden = ['password'];

    /**
     * Relation with ClientAddress model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function addresses()
    {
        return $this->hasMany(__NAMESPACE__ . '\ClientAddress');
    }

    /**
     * Mutator for active attribute
     *
     * @param $value
     */
    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = (int)$value;
    }

    /**
     * Accessor for active attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getActiveAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Mutator for password attribute
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Password::hash($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}
