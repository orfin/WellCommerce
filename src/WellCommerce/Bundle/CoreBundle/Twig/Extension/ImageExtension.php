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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;

/**
 * Class ImageExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ImageExtension extends \Twig_Extension
{
    /**
     * @var ImageHelperInterface
     */
    private $helper;

    /**
     * ImageExtension constructor.
     *
     * @param ImageHelperInterface $helper
     */
    public function __construct(ImageHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('image', [$this, 'getImagePath'], ['is_safe' => ['html']]),
        ];
    }

    public function getName()
    {
        return 'image';
    }

    public function getImagePath(string $path, string $filter) : string
    {
        return $this->helper->getImage($path, $filter);
    }
}
