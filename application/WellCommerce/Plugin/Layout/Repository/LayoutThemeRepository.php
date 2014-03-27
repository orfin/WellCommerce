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
namespace WellCommerce\Plugin\Layout\Repository;

use WellCommerce\Core\Repository;
use WellCommerce\Plugin\Layout\Model\LayoutTheme;

/**
 * Class LayoutThemeRepository
 *
 * @package WellCommerce\Plugin\LayoutTheme\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutThemeRepository extends Repository
{

    /**
     * Deletes layout_theme record by ID
     *
     * @param int $id layout_theme ID to delete
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return LayoutTheme::destroy($id);
        });
    }

    /**
     * Saves layout_theme
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {

            $layout_theme = LayoutTheme::firstOrNew([
                'id' => $id
            ]);

            $layout_theme->discount = $Data['discount'];
            $layout_theme->save();
        });
    }

    /**
     * Returns array containing values needed to populate the form
     *
     * @param $id
     *
     * @return array
     */
    public function getPopulateData($id)
    {
        $layout_themeData = $this->find($id);
        $populateData     = [];
        $accessor         = $this->getPropertyAccessor();
        $languageData     = $layout_themeData->getTranslationData();

        $accessor->setValue($populateData, '[required_data]', [
            'discount'      => $layout_themeData->discount,
            'language_data' => $languageData,
        ]);

        return $populateData;
    }

    /**
     * Returns a single tax rate
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return LayoutTheme::with('translation')->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function getAllLayoutThemeToSelect()
    {
        return $this->all()->toSelect('id', 'name');
    }

    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LayoutTheme::all();
    }
}