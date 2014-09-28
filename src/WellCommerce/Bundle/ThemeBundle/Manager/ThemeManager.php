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

namespace WellCommerce\Bundle\ThemeBundle\Manager;

use WellCommerce\Bundle\ThemeBundle\Entity\Theme;
use WellCommerce\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;

/**
 * Class ThemeManager
 *
 * @package WellCommerce\Bundle\ThemeBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeManager implements ThemeManagerInterface
{
    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var ThemeRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param ThemeRepositoryInterface $repository
     */
    public function __construct(ThemeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentTheme(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTheme()
    {
        if (null === $this->theme) {
            throw new \LogicException('Cannot return current Theme object. You forgot to set it before using "setCurrentTheme" method.');
        }

        return $this->theme;
    }

    /**
     * {@inheritdoc}
     */
    public function getThemePathPatterns()
    {
        /*
         * 'bundle_resource'     => [
                '%bundle_path%/Resources/themes/%current_theme%/templates/%template%',
                '%web_path%/themes/%current_theme%/templates/%template%',
            ],
            'bundle_resource_dir' => [
                '%dir%/themes/%current_theme%/templates/%bundle_name%/%template%',
                '%web_path%/themes/%current_theme%/templates/%bundle_name%/%template%',
                '%dir%/%bundle_name%/%override_path%',
            ],
         */
        return [
            '%web_path%/themes/%current_theme%/templates/%bundle_name%/%template%'
        ];
    }
} 