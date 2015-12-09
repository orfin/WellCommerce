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

namespace WellCommerce\Component\Form\Elements\Input;

use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class FontStyle
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FontStyle extends TextField implements ElementInterface
{
    /**
     * Formats font styles to use them in layout editor
     *
     * @return string
     */
    public function formatStylesJs()
    {
        $options = [];

        $options[] = $this->formatStyle('Arial,Arial,Helvetica,sans-serif', 'Arial');
        $options[] = $this->formatStyle('Arial Black,Arial Black,Gadget,sans-serif', 'Arial Black');
        $options[] = $this->formatStyle('Comic Sans MS,Comic Sans MS,cursive', 'Comic Sans MS');
        $options[] = $this->formatStyle('Courier New,Courier New,Courier,monospace', 'Courier New');
        $options[] = $this->formatStyle('Georgia,Georgia,serif', 'Georgia');
        $options[] = $this->formatStyle('Impact,Charcoal,sans-serif', 'Impact');
        $options[] = $this->formatStyle('Lucida Console,Monaco,monospace', 'Lucida Console');
        $options[] = $this->formatStyle('Lucida Sans Unicode,Lucida Grande,sans-serif', 'Lucida Sans');
        $options[] = $this->formatStyle('Palatino Linotype,Book Antiqua,Palatino,serif', 'Palatino Linotype');
        $options[] = $this->formatStyle('Tahoma,Geneva,sans-serif', 'Tahoma');
        $options[] = $this->formatStyle('Times New Roman,Times,serif', 'Times New Roman');
        $options[] = $this->formatStyle('Trebuchet MS,Helvetica,sans-serif', 'Trebuchet');
        $options[] = $this->formatStyle('Verdana,Geneva,sans-serif', 'Verdana');

        return 'aoTypes: ['.implode(', ', $options).']';
    }

    /**
     * Formats the font style as json value
     *
     * @param $style
     * @param $label
     *
     * @return string
     */
    private function formatStyle($style, $label)
    {
        return sprintf("{sValue: '%s', sLabel: '%s'}", $style, $label);
    }
}
