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
namespace WellCommerce\Core\Component\Model\Collection;

use Illuminate\Database\Eloquent\Collection;
use WellCommerce\Core\Helper\TableInfo;

/**
 * Class CustomCollection
 *
 * @package WellCommerce\Core\Component\Model\Collection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CustomCollection extends Collection
{
    /**
     * Returns current translation from translation Collection
     *
     * @param Collection $collection
     */
    public function getCurrentTranslation($language)
    {
        foreach ($this as $item) {
            if ($item->language_id == $language) {
                return $item;
            }
        }
    }

    /**
     * Returns translation data from collection
     *
     * @return array
     */
    public function getTranslations()
    {
        foreach ($this as $item) {
            $attributes = TableInfo::getColumns($item->getTable());
            foreach ($attributes as $attribute) {
                if (isset($item->$attribute) && $value = $item->$attribute) {
                    $languageData[$item->language_id][$attribute] = $value;
                }
            }
        }

        return $languageData;
    }

    /**
     * Flatten Collection to key-value pairs used in forms
     *
     * @param            $idKey
     * @param            $translationPath
     * @param            $language
     *
     * @return array
     */
    public function toSelect($idKey, $translationPath, $language = null)
    {
        $items           = $this;
        $select          = [];
        $translationPath = explode('.', $translationPath);

        // check if we need to use relation
        if (count($translationPath) == 2) {
            $translationNode = $translationPath[0];
            $translationKey  = $translationPath[1];
        } else {
            $translationNode = null;
            $translationKey  = $translationPath[0];
        }

        $items->each(function ($item) use (&$select, $idKey, $translationNode, $translationKey, $items, $language) {

            if (null === $translationNode) {
                $select[$item->$idKey] = $item->$translationKey;
            } else {
                foreach ($item->$translationNode as $translation) {
                    if ($translation->language_id === $language) {
                        $select[$item->$idKey] = $translation->$translationKey;
                    }
                }
            }
        });

        return $select;
    }

    /**
     * Returns an array containing only primary keys for all items in collection
     *
     * @return array
     */
    public function getPrimaryKeys()
    {
        $data = [];
        foreach ($this->items as $item) {
            $data[] = $item->id;
        }

        return $data;
    }
}
