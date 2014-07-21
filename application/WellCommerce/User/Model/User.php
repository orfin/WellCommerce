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
namespace WellCommerce\User\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Helper\Password;

/**
 * Class User
 *
 * @package WellCommerce\User\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class User extends AbstractModel implements ModelInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Indicates if the model should soft delete.
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

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
     * Mutator for global attribute
     *
     * @param $value
     */
    public function setGlobalAttribute($value)
    {
        $this->attributes['global'] = (int)$value;
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
     * Accessor for global attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getGlobalAttribute($value)
    {
        return (int)$value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}
