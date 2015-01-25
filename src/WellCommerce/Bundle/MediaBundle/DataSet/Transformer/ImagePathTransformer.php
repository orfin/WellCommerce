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

namespace WellCommerce\Bundle\MediaBundle\DataSet\Transformer;

use WellCommerce\Bundle\DataSetBundle\Transformer\TransformerInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;

class ImagePathTransformer implements TransformerInterface
{
    /**
     * @var ImageHelperInterface
     */
    protected $imageHelper;

    /**
     * @var string
     */
    protected $filter;

    /**
     * Constructor
     *
     * @param ImageHelperInterface $imageHelper
     * @param                      $filter
     */
    public function __construct(ImageHelperInterface $imageHelper, $filter)
    {
        $this->imageHelper = $imageHelper;
        $this->filter      = $filter;
    }

    /**
     * Transforms image name to full browser path
     *
     * @param $value
     *
     * @return string
     */
    public function transform($value)
    {
        return $this->imageHelper->getImage($value, $this->filter);
    }
}
