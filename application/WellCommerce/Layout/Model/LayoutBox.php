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
namespace WellCommerce\Layout\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Model\TranslatableModelInterface;

/**
 * Class LayoutBox
 *
 * @package WellCommerce\LayoutBox\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutBox extends AbstractModel implements ModelInterface, TranslatableModelInterface
{
    protected $table = 'layout_box';

    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translation()
    {
        return $this->hasMany(__NAMESPACE__ . '\LayoutBoxTranslation');
    }

    /**
     * Mutator for visibility attribute
     *
     * @param $value
     */
    public function setVisibilityAttribute($value)
    {
        $this->attributes['visibility'] = (int)$value;
    }

    /**
     * Accessor for visibility attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getVisibilityAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Mutator for visibility attribute
     *
     * @param $value
     */
    public function setShowHeaderAttribute($value)
    {
        $this->attributes['show_header'] = (int)$value;
    }

    /**
     * Accessor for visibility attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getShowHeaderAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Mutator for settings attribute
     *
     * @param $value
     */
    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = serialize($value);
    }

    /**
     * Accessor for settings attribute
     *
     * @param $value
     *
     * @return mixed
     */
    public function getSettingsAttribute($value)
    {
        return unserialize($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }

}