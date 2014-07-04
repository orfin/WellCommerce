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

namespace WellCommerce\Core\Helper;

/**
 * Class TableInfo
 *
 * This helper class was auto-generated. Please do not remove it.
 *
 * @package WellCommerce\Core\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TableInfo
{
    private static $columns  = [
        'admin_menu' => ['id','name','icon','route','controller','sort_order','parent_id'],
        'attribute' => ['id','created_at','updated_at'],
        'attribute_attribute_value' => ['id','attribute_id','attribute_value_id','created_at','updated_at'],
        'attribute_group' => ['id','created_at','updated_at'],
        'attribute_group_attribute' => ['id','attribute_id','attribute_group_id','created_at','updated_at'],
        'attribute_group_translation' => ['id','name','attribute_group_id','language_id','created_at','updated_at'],
        'attribute_translation' => ['id','name','attribute_id','language_id','created_at','updated_at'],
        'attribute_value' => ['id','created_at','updated_at'],
        'attribute_value_translation' => ['id','name','attribute_value_id','language_id','created_at','updated_at'],
        'availability' => ['id','created_at','updated_at'],
        'availability_translation' => ['id','name','description','availability_id','language_id','created_at','updated_at'],
        'category' => ['id','hierarchy','enabled','parent_id','file_id','created_at','updated_at'],
        'category_shop' => ['id','category_id','shop_id','created_at','updated_at'],
        'category_translation' => ['id','name','slug','short_description','description','meta_keywords','meta_title','meta_description','category_id','language_id','created_at','updated_at'],
        'client' => ['id','first_name','last_name','phone','email','password','client_group_id','shop_id','discount','active','created_at','updated_at'],
        'client_address' => ['id','client_id','type','first_name','last_name','phone','street','street_no','flat_no','post_code','city','company_name','vat_id','country','created_at','updated_at'],
        'client_group' => ['id','discount','created_at','updated_at'],
        'client_group_translation' => ['id','name','client_group_id','language_id','created_at','updated_at'],
        'company' => ['id','name','short_name','street','streetno','flatno','postcode','province','city','country','created_at','updated_at'],
        'contact' => ['id','enabled','created_at','updated_at'],
        'contact_translation' => ['id','name','email','phone','street','streetno','flatno','postcode','province','city','country','contact_id','language_id','created_at','updated_at'],
        'currency' => ['id','name','symbol','decimal_separator','thousand_separator','positive_prefix','positive_suffix','negative_prefix','negative_suffix','decimal_count','created_at','updated_at'],
        'deliverer' => ['id','created_at','updated_at'],
        'deliverer_translation' => ['id','name','deliverer_id','language_id','created_at','updated_at'],
        'file' => ['id','name','extension','type','width','height','size','created_at','updated_at'],
        'language' => ['id','created_at','updated_at','name','translation','currency_id','locale'],
        'layout_box' => ['id','type','settings','visibility','show_header','created_at','updated_at'],
        'layout_box_translation' => ['id','name','content','layout_box_id','language_id','created_at','updated_at'],
        'layout_page' => ['id','name','created_at','updated_at'],
        'layout_page_column' => ['id','layout_theme_id','layout_page_id','hierarchy','width','created_at','updated_at'],
        'layout_page_column_box' => ['id','layout_page_column_id','layout_box_id','hierarchy','span','created_at','updated_at'],
        'layout_theme' => ['id','name','folder','created_at','updated_at'],
        'layout_theme_css' => ['id','class','selector','attribute','layout_theme_id','created_at','updated_at'],
        'migration' => ['id','name','created_at','updated_at'],
        'payment_method' => ['id','hierarchy','enabled','service','file_id','created_at','updated_at'],
        'payment_method_shop' => ['id','payment_method_id','shop_id','created_at','updated_at'],
        'payment_method_translation' => ['id','name','payment_method_id','language_id','created_at','updated_at'],
        'producer' => ['id','created_at','updated_at'],
        'producer_deliverer' => ['id','producer_id','deliverer_id','created_at','updated_at'],
        'producer_shop' => ['id','producer_id','shop_id','created_at','updated_at'],
        'producer_translation' => ['id','name','slug','short_description','description','meta_keywords','meta_title','meta_description','producer_id','language_id','created_at','updated_at'],
        'product' => ['id','sku','ean','hierarchy','enabled','buy_price','buy_currency_id','sell_price','sell_currency_id','producer_id','tax_id','unit_id','photo_id','stock','track_stock','weight','width','height','depth','package_size','created_at','updated_at'],
        'product_category' => ['id','product_id','category_id','created_at','updated_at'],
        'product_deliverer' => ['id','product_id','deliverer_id','created_at','updated_at'],
        'product_photo' => ['id','product_id','file_id','created_at','updated_at'],
        'product_shop' => ['id','product_id','shop_id','created_at','updated_at'],
        'product_translation' => ['id','name','slug','short_description','description','long_description','meta_keywords','meta_title','meta_description','product_id','language_id','created_at','updated_at'],
        'session' => ['sess_id','sess_data','sess_time'],
        'shipping_method' => ['id','hierarchy','enabled','type','file_id','created_at','updated_at'],
        'shipping_method_cost' => ['id','shipping_method_id','from','to','cost','tax_id','created_at','updated_at'],
        'shipping_method_payment_method' => ['id','payment_method_id','shipping_method_id','created_at','updated_at'],
        'shipping_method_shop' => ['id','shipping_method_id','shop_id','created_at','updated_at'],
        'shipping_method_translation' => ['id','name','shipping_method_id','language_id','created_at','updated_at'],
        'shop' => ['id','url','offline','company_id','layout_theme_id','created_at','updated_at'],
        'shop_translation' => ['id','name','meta_keywords','meta_title','meta_description','shop_id','language_id','created_at','updated_at'],
        'tax' => ['id','value','created_at','updated_at'],
        'tax_translation' => ['id','name','tax_id','language_id','created_at','updated_at'],
        'unit' => ['id','created_at','updated_at'],
        'unit_translation' => ['id','name','unit_id','language_id','created_at','updated_at'],
        'user' => ['id','first_name','last_name','email','password','active','global','created_at','updated_at'],
    ];

    public static function getColumns($table)
    {
        if(!isset(self::$columns[$table])){
            throw new \InvalidArgumentException(sprintf('Table %s does not exists in schema information', $table));
        }

        return self::$columns[$table];
    }

}
