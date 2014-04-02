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

namespace WellCommerce\Core\Component\Model;

/**
 * Interface TranslatableModelInterface
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TranslatableModelInterface
{

    /**
     * Relation with _translation table
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function translation();
}