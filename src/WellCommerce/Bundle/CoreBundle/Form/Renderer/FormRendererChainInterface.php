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

namespace WellCommerce\Bundle\CoreBundle\Form\Renderer;

/**
 * Class FormRendererChainInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormRendererChainInterface
{
    /**
     * Guesses renderer by type
     *
     * @param $type
     *
     * @return FormRendererInterface
     *
     * @throws \RuntimeException If renderer for such type was not found
     */
    public function guessRenderer($type);
} 