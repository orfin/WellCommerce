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
use WellCommerce\Plugin\Layout\Model\LayoutBox;
use WellCommerce\Plugin\Layout\Model\LayoutBoxSettings;

/**
 * Class LayoutBoxRepository
 *
 * @package WellCommerce\Plugin\LayoutBox\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRepository extends Repository
{

    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LayoutBox::with('settings')->get();
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
        return LayoutBox::with('settings')->findOrFail($id);
    }

    /**
     * Deletes layout_theme record by ID
     *
     * @param int $id layout_theme ID to delete
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return LayoutBox::destroy($id);
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

            $layoutBox = LayoutBox::firstOrNew([
                'id' => $id
            ]);

            $layoutBox->identifier = $Data['required_data']['identifier'];
            $layoutBox->alias      = $Data['required_data']['alias'];
            $layoutBox->save();

            $accessor = $this->getPropertyAccessor();
            $settings = $accessor->getValue($Data, $this->getFormNodeName($layoutBox->alias));

            LayoutBoxSettings::where('layout_box_id', '=', $id)->delete();

            if (!empty($settings)) {
                foreach ($settings as $param => $value) {
                    $layoutBoxSettings = LayoutBoxSettings::firstOrNew([
                        'layout_box_id' => $layoutBox->id,
                        'param'         => $param
                    ]);

                    $layoutBoxSettings->layout_box_id = $layoutBox->id;
                    $layoutBoxSettings->value         = $value;
                    $layoutBoxSettings->save();
                }
            }
        });
    }

    /**
     * Replaces dots with dashes in node name
     *
     * @param $alias
     *
     * @return string
     */
    private function getFormNodeName($alias)
    {
        return '[' . strtr($alias, '.', '_') . ']';
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
        $layoutBoxData = $this->find($id);
        $populateData  = [];
        $accessor      = $this->getPropertyAccessor();

        $accessor->setValue($populateData, '[required_data]', [
            'identifier' => $layoutBoxData->identifier,
            'alias'      => $layoutBoxData->alias,
        ]);

        foreach ($layoutBoxData->settings as $setting) {
            $accessor->setValue($populateData, $this->getFormNodeName($layoutBoxData->alias), [
                $setting->param => $setting->value
            ]);
        }

        return $populateData;
    }

    public function getAllLayoutBoxToSelect()
    {
        return $this->all()->toSelect('id', 'name');
    }
}