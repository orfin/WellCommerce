<?php

/**
 * Gekosale, Open Source E-Commerce Solution
 * http://www.gekosale.pl
 *
 * Copyright (c) 2008-2012 Gekosale sp. z o.o.. Zabronione jest usuwanie informacji o licencji i autorach.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 *
 * $Revision: 627 $
 * $Author: gekosale $
 * $Date: 2012-01-20 23:05:57 +0100 (Pt, 20 sty 2012) $
 * $Id: product.php 627 2012-01-20 22:05:57Z gekosale $
 */
namespace Bellemaison;

use Gekosale\App as App;
use Gekosale\Core as Core;
use Gekosale\Db as Db;
use Gekosale\Helper as Helper;
use Gekosale\Session as Session;
use xajaxResponse;

class productModel extends \Gekosale\productModel
{

    public function initDataset($dataset)
    {
        $clientGroupId = Session::getActiveClientGroupid();

        if (!empty($clientGroupId)) {

            $dataset->setTableData([

                    'id'                 => [

                        'source' => 'P.idproduct'
                    ]
                    ,
                    'adddate'            => [

                        'source' => 'P.adddate'
                    ]
                    ,
                    'name'               => [

                        'source' => 'PT.name'
                    ]
                    ,
                    'ean'                => [

                        'source' => 'P.ean'
                    ]
                    ,
                    'delivelercode'      => [

                        'source' => 'P.delivelercode'
                    ]
                    ,
                    'shortdescription'   => [

                        'source' => 'PT.shortdescription'
                    ]
                    ,
                    'seo'                => [

                        'source' => 'PT.seo'
                    ]
                    ,
                    'producername'       => [

                        'source' => 'PRT.name'
                    ]
                    ,
                    'producerseo'        => [

                        'source' => 'PRT.seo'
                    ]
                    ,
                    'categoryname'       => [

                        'source' => 'CT.name'
                    ]
                    ,
                    'categoryseo'        => [

                        'source' => 'CT.seo'
                    ]
                    ,
                    'onstock'            => [

                        'source' => 'IF(P.trackstock = 1, IF(P.stock > 0, 1, 0), 1)'
                    ]
                    ,
                    'pricenetto'         => [

                        'source' => 'IF(PGP.groupprice = 1,

								 	PGP.sellprice,

								 	P.sellprice

								 ) * CR.exchangerate'
                    ]
                    ,
                    'price'              => [

                        'source' => 'IF(PGP.groupprice = 1,

									PGP.sellprice,

									P.sellprice

								 ) * (1 + (V.value / 100)) * CR.exchangerate'
                    ]
                    ,
                    'buypricenetto'      => [

                        'source' => 'P.buyprice * CR.exchangerate'
                    ]
                    ,
                    'buyprice'           => [

                        'source' => 'P.buyprice * (1 + (V.value / 100)) * CR.exchangerate'
                    ]
                    ,
                    'discountpricenetto' => [

                        'source' => 'IF(PGP.promotion = 1 AND IF(PGP.promotionstart IS NOT NULL, PGP.promotionstart <= CURDATE(), 1) AND IF(PGP.promotionend IS NOT NULL, PGP.promotionend >= CURDATE(), 1),

								 	PGP.discountprice,

								 	IF(PGP.groupprice IS NULL AND P.promotion = 1 AND IF(P.promotionstart IS NOT NULL, P.promotionstart <= CURDATE(), 1) AND IF(P.promotionend IS NOT NULL, P.promotionend >= CURDATE(), 1), P.discountprice, NULL)

								 ) * CR.exchangerate'
                    ]
                    ,
                    'discountprice'      => [

                        'source' => 'IF(PGP.promotion = 1 AND IF(PGP.promotionstart IS NOT NULL, PGP.promotionstart <= CURDATE(), 1) AND IF(PGP.promotionend IS NOT NULL, PGP.promotionend >= CURDATE(), 1),

								 	PGP.discountprice,

								 	IF(PGP.groupprice IS NULL AND P.promotion = 1 AND IF(P.promotionstart IS NOT NULL, P.promotionstart <= CURDATE(), 1) AND IF(P.promotionend IS NOT NULL, P.promotionend >= CURDATE(), 1), P.discountprice, NULL)

								 ) * (1 + (V.value / 100)) * CR.exchangerate'
                    ]
                    ,
                    'finalprice'         => [

                        'source' => 'IF(PGP.promotion = 1 AND IF(PGP.promotionstart IS NOT NULL, PGP.promotionstart <= CURDATE(), 1) AND IF(PGP.promotionend IS NOT NULL, PGP.promotionend >= CURDATE(), 1),

								 	PGP.discountprice,

								 	IF(PGP.groupprice IS NULL AND P.promotion = 1 AND IF(P.promotionstart IS NOT NULL, P.promotionstart <= CURDATE(), 1) AND IF(P.promotionend IS NOT NULL, P.promotionend >= CURDATE(), 1), P.discountprice, IF(PGP.groupprice = 1, PGP.sellprice, P.sellprice))

								 ) * (1 + (V.value / 100)) * CR.exchangerate'
                    ]
                    ,
                    'photo'              => [

                        'source'          => 'Photo.photoid',
                        'processFunction' => [

                            App::getModel('product'),
                            'getImagePath'
                        ]

                    ]
                    ,
                    'opinions'           => [

                        'source' => 'COUNT(DISTINCT PREV.idproductreview)'
                    ]
                    ,
                    'rating'             => [

                        'source' => 'IF(CEILING(AVG(PRANGE.value)) IS NULL, 0, CEILING(AVG(PRANGE.value)))'
                    ]
                    ,
                    'new'                => [

                        'source' => 'IF(PN.active = 1 AND (PN.startdate IS NULL OR PN.startdate <= CURDATE()) AND (PN.enddate IS NULL OR PN.enddate >= CURDATE()), 1, 0)'
                    ]
                    ,
                    'dateto'             => [

                        'source' => 'IF(PGP.promotionend IS NOT NULL, PGP.promotionend, IF(P.promotionend IS NOT NULL, P.promotionend, NULL))'
                    ]
                    ,
                    'statuses'           => [

                        'source'          => 'P.idproduct',
                        'processFunction' => [

                            $this,
                            'getProductStatuses'
                        ]

                    ]

                ]
            );

            $dataset->setFrom('

                                productcategory PC

                                LEFT JOIN viewcategory VC ON PC.categoryid = VC.categoryid AND VC.viewid = :viewid

                                LEFT JOIN categorytranslation CT ON PC.categoryid = CT.categoryid AND CT.languageid = :languageid

                                LEFT JOIN product P ON PC.productid = P.idproduct

                                LEFT JOIN productgroupprice PGP ON PGP.productid = P.idproduct AND PGP.clientgroupid = :clientgroupid

                                LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid

                                LEFT JOIN producertranslation PRT ON P.producerid = PRT.producerid AND PT.languageid = :languageid

                                LEFT JOIN productphoto Photo ON P.idproduct= Photo.productid AND Photo.mainphoto = 1

                                LEFT JOIN productnew PN ON P.idproduct = PN.productid

                                LEFT JOIN vat V ON P.vatid= V.idvat

                                LEFT JOIN productreview PREV ON PREV.productid = P.idproduct AND PREV.enable = 1

                                LEFT JOIN productrange PRANGE ON PRANGE.productid = P.idproduct

                                LEFT JOIN currencyrates CR ON CR.currencyfrom = P.sellcurrencyid AND CR.currencyto = :currencyto

                            ');
        } else {

            $dataset->setTableData([

                    'id'                 => [

                        'source' => 'P.idproduct'
                    ]
                    ,
                    'adddate'            => [

                        'source' => 'P.adddate'
                    ]
                    ,
                    'name'               => [

                        'source' => 'PT.name'
                    ]
                    ,
                    'ean'                => [

                        'source' => 'P.ean'
                    ]
                    ,
                    'delivelercode'      => [

                        'source' => 'P.delivelercode'
                    ]
                    ,
                    'shortdescription'   => [

                        'source' => 'PT.shortdescription'
                    ]
                    ,
                    'seo'                => [

                        'source' => 'PT.seo'
                    ]
                    ,
                    'producername'       => [

                        'source' => 'PRT.name'
                    ]
                    ,
                    'producerseo'        => [

                        'source' => 'PRT.seo'
                    ]
                    ,
                    'categoryname'       => [

                        'source' => 'CT.name'
                    ]
                    ,
                    'categoryseo'        => [

                        'source' => 'CT.seo'
                    ]
                    ,
                    'onstock'            => [

                        'source' => 'IF(P.trackstock = 1, IF(P.stock > 0, 1, 0), 1)'
                    ]
                    ,
                    'pricenetto'         => [

                        'source' => 'P.sellprice * CR.exchangerate'
                    ]
                    ,
                    'price'              => [

                        'source' => 'P.sellprice * (1 + (V.value / 100)) * CR.exchangerate'
                    ]
                    ,
                    'buypricenetto'      => [

                        'source' => 'ROUND(P.buyprice * CR.exchangerate, 2)'
                    ]
                    ,
                    'buyprice'           => [

                        'source' => 'ROUND((P.buyprice + (P.buyprice * V.`value`)/100) * CR.exchangerate, 2)'
                    ]
                    ,
                    'discountpricenetto' => [

                        'source' => 'IF(P.promotion = 1 AND IF(P.promotionstart IS NOT NULL, P.promotionstart <= CURDATE(), 1) AND IF(P.promotionend IS NOT NULL, P.promotionend >= CURDATE(), 1), P.discountprice * CR.exchangerate, NULL)'
                    ]
                    ,
                    'discountprice'      => [

                        'source' => 'IF(P.promotion = 1 AND IF(P.promotionstart IS NOT NULL, P.promotionstart <= CURDATE(), 1) AND IF(P.promotionend IS NOT NULL, P.promotionend >= CURDATE(), 1), P.discountprice * (1 + (V.value / 100)) * CR.exchangerate, NULL)'
                    ]
                    ,
                    'finalprice'         => [

                        'source' => 'IF(P.promotion = 1 AND IF(P.promotionstart IS NOT NULL, P.promotionstart <= CURDATE(), 1) AND IF(P.promotionend IS NOT NULL, P.promotionend >= CURDATE(), 1), P.discountprice * (1 + (V.value / 100)) * CR.exchangerate, P.sellprice * (1 + (V.value / 100)) * CR.exchangerate)'
                    ]
                    ,
                    'photo'              => [

                        'source'          => 'Photo.photoid',
                        'processFunction' => [

                            App::getModel('product'),
                            'getImagePath'
                        ]

                    ]
                    ,
                    'opinions'           => [

                        'source' => 'COUNT(DISTINCT PREV.idproductreview)'
                    ]
                    ,
                    'rating'             => [

                        'source' => 'IF(CEILING(AVG(PRANGE.value)) IS NULL, 0, CEILING(AVG(PRANGE.value)))'
                    ]
                    ,
                    'new'                => [

                        'source' => 'IF(PN.active = 1 AND (PN.startdate IS NULL OR PN.startdate <= CURDATE()) AND (PN.enddate IS NULL OR PN.enddate >= CURDATE()), 1, 0)'
                    ]
                    ,
                    'dateto'             => [

                        'source' => 'IF(P.promotionend IS NOT NULL, P.promotionend, NULL)'
                    ]
                    ,
                    'statuses'           => [

                        'source'          => 'P.idproduct',
                        'processFunction' => [

                            $this,
                            'getProductStatuses'
                        ]

                    ]

                ]
            );

            $dataset->setFrom('

                                productcategory PC

                                LEFT JOIN viewcategory VC ON PC.categoryid = VC.categoryid AND VC.viewid = :viewid

                                LEFT JOIN categorytranslation CT ON PC.categoryid = CT.categoryid AND CT.languageid = :languageid

                                LEFT JOIN product P ON PC.productid= P.idproduct

                                LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid

                                LEFT JOIN producertranslation PRT ON P.producerid = PRT.producerid AND PT.languageid = :languageid

                                LEFT JOIN productphoto Photo ON P.idproduct= Photo.productid AND Photo.mainphoto = 1

                                LEFT JOIN productnew PN ON P.idproduct = PN.productid

                                LEFT JOIN vat V ON P.vatid= V.idvat

                                LEFT JOIN productreview PREV ON PREV.productid = P.idproduct AND PREV.enable = 1

                                LEFT JOIN productrange PRANGE ON PRANGE.productid = P.idproduct

                                LEFT JOIN currencyrates CR ON CR.currencyfrom = P.sellcurrencyid AND CR.currencyto = :currencyto

                            ');
        }

        $dataset->setAdditionalWhere('

                        PC.categoryid = :categoryid AND
						IF(:availability > 0, P.stock > 0, 1) AND

                        IF(:filterbyproducer > 0, FIND_IN_SET(CAST(P.producerid as CHAR), :producer), 1) AND

                        P.enable = 1 AND

                        IF(:enablelayer > 0, FIND_IN_SET(CAST(P.idproduct as CHAR), :products), 1)

                    ');

        $dataset->setGroupBy('

                        P.idproduct

                    ');

        $dataset->setHavingString('

                        finalprice BETWEEN IF(:pricefrom > 0, :pricefrom, 0) AND IF( :priceto > 0, :priceto, 999999)

                    ');

        $dataset->setSQLParams([

                'categoryid'       => (int)$this->registry->core->getParam(),
                'producer'         => 0,
                'pricefrom'        => 0,
                'priceto'          => 0,
                'filterbyproducer' => 0,
                'enablelayer'      => 0,
                'availability'     => 0,
                'products'         => []
            ]
        );
    }

    public function getMaxMinPrice($categoryId)
    {
        //return array();
        $sql
            = 'SELECT
						C.currencysymbol AS currencysymbol,
						V.value AS vatvalue,
						ROUND(P.sellprice * (1 + (V.value / 100)) * CR.exchangerate, 2) AS buyprice
				FROM productcategory PC
				LEFT JOIN viewcategory VC ON PC.categoryid = VC.categoryid AND VC.viewid = :viewid
				LEFT JOIN categorytranslation CT ON PC.categoryid = CT.categoryid AND CT.languageid = :languageid
				LEFT JOIN product P ON PC.productid = P.idproduct
				LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid
				LEFT JOIN producertranslation PRT ON P.producerid = PRT.producerid AND PT.languageid = :languageid
				LEFT JOIN productphoto Photo ON P.idproduct= Photo.productid AND Photo.mainphoto = 1
				LEFT JOIN productnew PN ON P.idproduct = PN.productid
				LEFT JOIN vat V ON P.vatid= V.idvat
				LEFT JOIN productreview PREV ON PREV.productid = P.idproduct AND PREV.enable = 1
				LEFT JOIN productrange PRANGE ON PRANGE.productid = P.idproduct
				LEFT JOIN currency C ON C.idcurrency = P.sellcurrencyid
				LEFT JOIN currencyrates CR ON CR.currencyfrom = P.sellcurrencyid AND CR.currencyto = :currencyto
				WHERE PC.categoryid = :categoryid AND P.enable = 1 ORDER BY buyprice ASC';

        $stmt = Db::getInstance()->prepare($sql);
        $stmt->bindValue('currencyto', Session::getActiveCurrencyId());
        $stmt->bindValue('categoryid', $categoryId);
        $stmt->bindValue('viewid', Helper::getViewId());
        $stmt->bindValue('languageid', Helper::getLanguageId());
        $Data = [];
        try {
            $stmt->execute();

            while ($rs = $stmt->fetch()) {
                if (!isset($Data['minprice']) && $rs['buyprice'] > 0) {
                    $Data['minprice'] = $rs['buyprice'];
                    $Data['currency'] = $rs['currencysymbol'];
                }

                $Data['maxprice'] = $rs['buyprice'];
            }

            if (!isset($Data['currency'])) {
                $Data['currency'] = 'PLN';
            }
        } catch (Exception $e) {
            throw new FrontendException($e->getMessage());
        }

        return $Data;
    }

    public function previousProduct($productid, $categoryid)
    {
        $sql
              = "SELECT
					PC.categoryid
				FROM productcategory PC
				LEFT JOIN product P ON PC.productid = P.idproduct
				LEFT JOIN category C ON PC.categoryid = C.idcategory
				LEFT JOIN categorypath CP ON CP.categoryid = PC.categoryid
				WHERE PC.productid = :productid AND C.enable = 1 AND P.enable = 1
				ORDER BY CP.order DESC
				LIMIT 1";
        $stmt = Db::getInstance()->prepare($sql);
        $stmt->bindValue('productid', $productid);
        $stmt->execute();
        $rs   = $stmt->fetch();
        $Data = [];
        if ($rs) {
            $sql
                  = 'SELECT
					PT.seo,
					PP.photoid
				FROM product P
				LEFT JOIN productphoto PP ON PP.productid = P.idproduct AND PP.mainphoto = 1
				LEFT JOIN productcategory PC ON PC.productid = P.idproduct AND PC.categoryid = :categoryid
				LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid
				LEFT JOIN category C ON PC.categoryid = C.idcategory
				LEFT JOIN viewcategory VC ON PC.categoryid = VC.categoryid
				WHERE P.idproduct > :productid AND PC.categoryid = :categoryid AND P.enable = 1 AND VC.viewid = :viewid
				LIMIT 1';
            $stmt = Db::getInstance()->prepare($sql);
            $stmt->bindValue('categoryid', $rs['categoryid']);
            $stmt->bindValue('productid', $productid);
            $stmt->bindValue('languageid', Helper::getLanguageId());
            $stmt->bindValue('viewid', Helper::getViewId());
            $Data = [];
            $stmt->execute();
            $rs = $stmt->fetch();
            if ($rs) {
                return [
                    'seo'   => $rs['seo'],
                    'photo' => App::getModel('gallery')->getImagePath(App::getModel('gallery')
                            ->getSmallImageById($rs['photoid']))
                ];
            } else {
                return null;
            }
        }
    }

    public function nextProduct($productid, $categoryid)
    {
        $sql
              = "SELECT
					PC.categoryid
				FROM productcategory PC
				LEFT JOIN product P ON PC.productid = P.idproduct
				LEFT JOIN category C ON PC.categoryid = C.idcategory
				LEFT JOIN categorypath CP ON CP.categoryid = PC.categoryid
				WHERE PC.productid = :productid AND C.enable = 1 AND P.enable = 1
				ORDER BY CP.order DESC
				LIMIT 1";
        $stmt = Db::getInstance()->prepare($sql);
        $stmt->bindValue('productid', $productid);
        $stmt->execute();
        $rs   = $stmt->fetch();
        $Data = [];
        if ($rs) {
            $sql
                  = 'SELECT
						PT.seo,
						PP.photoid
					FROM product P
					LEFT JOIN productphoto PP ON PP.productid = P.idproduct AND PP.mainphoto = 1
					LEFT JOIN productcategory PC ON PC.productid = P.idproduct AND PC.categoryid = :categoryid
					LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid
					LEFT JOIN category C ON PC.categoryid = C.idcategory
					LEFT JOIN viewcategory VC ON PC.categoryid = VC.categoryid
					WHERE P.idproduct < :productid AND PC.categoryid = :categoryid AND P.enable = 1 AND VC.viewid = :viewid
					ORDER BY P.idproduct DESC LIMIT 1';
            $stmt = Db::getInstance()->prepare($sql);
            $stmt->bindValue('categoryid', $rs['categoryid']);
            $stmt->bindValue('productid', $productid);
            $stmt->bindValue('languageid', Helper::getLanguageId());
            $stmt->bindValue('viewid', Helper::getViewId());
            $Data = [];
            $stmt->execute();
            $rs = $stmt->fetch();
            if ($rs) {
                return [
                    'seo'   => $rs['seo'],
                    'photo' => App::getModel('gallery')->getImagePath(App::getModel('gallery')
                            ->getSmallImageById($rs['photoid']))
                ];
            } else {
                return null;
            }
        }
    }

    public function getProductById($id, $isgiftwrap = 0)
    {
        $sql
              = "SELECT
					P.`status`,
					P.enable,
					P.ean,
					P.delivelercode,
					P.stock,
					IF(P.trackstock IS NULL, 0, P.trackstock) AS trackstock,
					PT.name as productname,
					PT.shortdescription,
					PT.description,
					PT.longdescription,
					PT.seo,
					PRODT.name AS producername,
					PRODT.seo AS producerurl,
					COLT.name AS collectionname,
					COLT.seo AS collectionseo,
					PROD.photoid AS producerphoto,
					IF(PHOTO.photoid IS NOT NULL, IF(PHOTO.mainphoto = 1, PHOTO.photoid, 0), 1) as mainphotoid,
					PT.keyword_title AS keyword_title,
					IF(PT.keyword = '', VT.keyword, PT.keyword) AS keyword,
					IF(PT.keyword_description = '',VT.keyword_description,PT.keyword_description) AS keyword_description,
					P.weight,
					P.packagesize,
					IF(PN.active = 1 AND (PN.enddate IS NULL OR PN.enddate >= CURDATE()), 1, 0) AS new,
					P.unit,
					COUNT(DISTINCT PREV.idproductreview) AS opinions,
					IF(CEILING(AVG(PRANGE.value)) IS NULL, 0, CEILING(AVG(PRANGE.value))) AS rating,
					UT.name AS unit,
					C.photoid AS categoryphoto,
					C.idcategory AS categoryid,
					CT.name AS categoryname,
					CT.seo AS categoryseo,
					AT.name AS availablityname,
				   	AT.description AS availablitydescription
				FROM product P
					LEFT JOIN producttranslation PT ON P.idproduct= PT.productid AND PT.languageid= :languageid
					LEFT JOIN productcategory PROCAT ON P.idproduct = PROCAT.productid
					LEFT JOIN categorytranslation CT ON PROCAT.categoryid = CT.categoryid AND CT.languageid = :languageid
					LEFT JOIN category C ON PROCAT.categoryid = C.idcategory
					LEFT JOIN viewcategory VC ON PROCAT.categoryid = VC.categoryid
					LEFT JOIN viewtranslation VT ON VT.viewid = VC.viewid
					LEFT JOIN producer AS PROD ON P.producerid= PROD.idproducer
					LEFT JOIN producertranslation PRODT ON PROD.idproducer= PRODT.producerid AND PRODT.languageid= :languageid
					LEFT JOIN collection COL ON COL.idcollection = P.collectionid
					LEFT JOIN collectiontranslation COLT ON COL.idcollection = COLT.collectionid AND COLT.languageid= :languageid
					LEFT JOIN productphoto PHOTO ON P.idproduct= PHOTO.productid AND PHOTO.mainphoto = 1
					LEFT JOIN productnew PN ON P.idproduct = PN.productid
					LEFT JOIN productreview PREV ON PREV.productid = P.idproduct AND PREV.enable = 1
					LEFT JOIN productrange PRANGE ON PRANGE.productid = P.idproduct
					LEFT JOIN unitmeasuretranslation UT ON P.unit = UT.unitmeasureid AND UT.languageid= :languageid
					LEFT JOIN availablity A ON A.idavailablity = P.availablityid
					LEFT JOIN availablitytranslation AT ON AT.availablityid = P.availablityid AND AT.languageid = :languageid
					WHERE P.idproduct= :productid AND VC.viewid = :viewid AND P.enable = 1
					GROUP BY P.idproduct";
        $stmt = Db::getInstance()->prepare($sql);
        //$stmt->bindValue('userid', (int) Session::getActiveUserid());
        $stmt->bindValue('viewid', Helper::getViewId());
        $stmt->bindValue('productid', $id);
        $stmt->bindValue('isgiftwrap', $isgiftwrap);
        $stmt->bindValue('languageid', Helper::getLanguageId());

        $Data = [];
        try {
            $stmt->execute();
            $rs = $stmt->fetch();

            if ($rs) {

                $price = $this->getProductPrices($id);

                $productNameStrlen = strlen($rs['productname']);
                $descLength        = 155 - $productNameStrlen;

                $meta_desc = $rs['productname'] . ' - ' . (strlen($rs['description']) > $descLength ?
                        mb_substr($rs['description'], 0, mb_strpos($rs['description'], ' ', $descLength)) . '...'
                        : $rs['description']);

                $meta_desc = strip_tags($meta_desc);
                $meta_desc = preg_replace('/\s+/', ' ', $meta_desc);
                $meta_desc = str_replace('&nbsp;', '', $meta_desc);
                $meta_desc = str_replace('&oacute;', 'ó', $meta_desc);

                $Data = [
                    'idproduct'              => $id,
                    'seo'                    => $rs['seo'],
                    'enable'                 => $rs['enable'],
                    'previous'               => $this->previousProduct($id, $rs['categoryid']),
                    'next'                   => $this->nextProduct($id, $rs['categoryid']),
                    'ean'                    => $rs['ean'],
                    'unit'                   => $rs['unit'],
                    'delivelercode'          => $rs['delivelercode'],
                    'producername'           => $rs['producername'],
                    'producerurl'            => urlencode($rs['producerurl']),
                    'collectionname'         => $rs['collectionname'],
                    'collectionseo'          => urlencode($rs['collectionseo']),
                    'producerphotoid'        => $rs['producerphoto'],
                    'producerphoto'          => App::getModel('gallery')->getImagePath(App::getModel('gallery')
                            ->getSmallImageById($rs['producerphoto'], 0)),
                    'stock'                  => $rs['stock'],
                    'trackstock'             => $rs['trackstock'],
                    'new'                    => $rs['new'],
                    'pricewithoutvat'        => $price['pricenetto'],
                    'pricenetto'             => $price['pricenetto'],
                    'price'                  => $price['price'],
                    'standardpricenetto'     => $price['standardpricenetto'],
                    'standardprice'          => $price['standardprice'],
                    'discountpricenetto'     => $price['discountpricenetto'],
                    'discountprice'          => $price['discountprice'],
                    'buypricenetto'          => $price['buypricenetto'],
                    'buyprice'               => $price['buyprice'],
                    'vatvalue'               => $price['vatvalue'],
                    'currencysymbol'         => $price['currencysymbol'],
                    'mainphotoid'            => $rs['mainphotoid'],
                    'description'            => $rs['description'],
                    'longdescription'        => $rs['longdescription'],
                    'productname'            => $rs['productname'],
                    'shortdescription'       => $rs['shortdescription'],
                    'keyword_title'          => ($rs['keyword_title'] == null || $rs['keyword_title'] == '')
                        ? $rs['productname'] : $rs['keyword_title'],
                    'keyword_description'    => $meta_desc,
                    //'keyword_description' => $rs['keyword_description'],
                    'keyword'                => $rs['keyword'],
                    'weight'                 => $rs['weight'],
                    'packagesize'            => $rs['packagesize'],
                    'unit'                   => $rs['unit'],
                    'categoryphoto'          => App::getModel('gallery')->getImagePath(App::getModel('gallery')
                            ->getSmallImageById($rs['categoryphoto'], 0)),
                    'categoryname'           => $rs['categoryname'],
                    'categoryid'             => $rs['categoryid'],
                    'categoryseo'            => $rs['categoryseo'],
                    'availablityname'        => $rs['availablityname'],
                    'availablitydescription' => $rs['availablitydescription'],
                    'opinions'               => $rs['opinions'],
                    'rating'                 => $rs['rating'],
                    'statuses'               => $this->getProductStatuses($id)
                ];
            }
        } catch (Exception $e) {
            throw new FrontendException($e->getMessage());
        }

        return $Data;
    }

    public function getProducerAll($Categories = [])
    {
        if (!empty($Categories)) {
            $sql
                = 'SELECT
						P.idproducer AS id,
						PT.name,
						PT.seo,						P.photoid
					FROM producer P
					INNER JOIN product PR ON PR.producerid = P.idproducer
					LEFT JOIN productcategory PC ON PC.productid = PR.idproduct
					LEFT JOIN producertranslation PT ON PT.producerid = P.idproducer AND PT.languageid = :language
					WHERE PC.categoryid IN (' . Core::arrayAsString($Categories) . ') AND PR.enable = 1 AND PT.name IS NOT NULL
					GROUP BY P.idproducer
					ORDER BY PT.name ASC';
        } else {
            $sql
                = 'SELECT
						P.idproducer AS id,
						PT.name,
						PT.seo,						P.photoid
					FROM producer P
					LEFT JOIN producertranslation PT ON PT.producerid = P.idproducer AND PT.languageid = :language
					WHERE PT.name IS NOT NULL
					GROUP BY P.idproducer
					ORDER BY PT.name ASC';
        }
        $Data = [];
        $stmt = Db::getInstance()->prepare($sql);
        $stmt->bindValue('language', Helper::getLanguageId());
        $stmt->execute();
        while ($rs = $stmt->fetch()) {
            $Data[] = [
                'id'    => $rs['id'],
                'name'  => $rs['name'],
                'seo'   => $rs['seo'],
                'photo' => App::getModel('categorylist')->getImagePath($rs['photoid'])
            ];
        }

        return $Data;
    }

    public function getPhotos(&$product)
    {
        $gallery = App::getModel('gallery');

        if (is_array($product['photo'])) {
            if (isset($product['mainphotoid']) && $product['mainphotoid'] > 0) {
                $product['mainphoto']['small']   = $this->getSeoPhoto($gallery->getImagePath($gallery->getSmallImageById($product['mainphotoid'])),
                    $product['seo']);
                $product['mainphoto']['normal']  = $this->getSeoPhoto($gallery->getImagePath($gallery->getNormalImageById($product['mainphotoid'])),
                    $product['seo']);
                $product['mainphoto']['large']   = $this->getSeoPhoto($gallery->getImagePath($gallery->getLargeImageById($product['mainphotoid'])),
                    $product['seo']);
                $product['mainphoto']['orginal'] = $this->getSeoPhoto($gallery->getImagePath($gallery->getOrginalImageById($product['mainphotoid'])),
                    $product['seo']);
            }
            foreach ($product['photo'] as $photo) {
                $product['photo']['small'][]   = $this->getSeoPhoto($gallery->getImagePath($gallery->getSmallImageById($photo['photoid'])),
                    $product['seo']);
                $product['photo']['normal'][]  = $this->getSeoPhoto($gallery->getImagePath($gallery->getNormalImageById($photo['photoid'])),
                    $product['seo']);
                $product['photo']['large'][]   = $this->getSeoPhoto($gallery->getImagePath($gallery->getLargeImageById($photo['photoid'])),
                    $product['seo']);
                $product['photo']['orginal'][] = $this->getSeoPhoto($gallery->getImagePath($gallery->getOrginalImageById($photo['photoid'])),
                    $product['seo']);
            }
            if (isset($product['producerphotoid']) && $product['producerphotoid'] > 0) {
                $product['producerphoto'] = [
                    'small'   => $gallery->getImagePath($gallery->getSmallImageById($product['producerphotoid'])),
                    'normal'  => $gallery->getImagePath($gallery->getNormalImageById($product['producerphotoid'])),
                    'large'   => $gallery->getImagePath($gallery->getLargeImageById($product['producerphotoid'])),
                    'orginal' => $gallery->getImagePath($gallery->getOrginalImageById($product['producerphotoid']))
                ];
            }
        }
    }

    public function getOtherPhotos(&$product)
    {
        $gallery = App::getModel('gallery');

        if (is_array($product['otherphoto'])) {
            if (isset($product['mainphotoid']) && $product['mainphotoid'] = 0) {
                $product['mainphoto']['small']   = $this->getSeoPhoto($gallery->getImagePath($gallery->getSmallImageById($product['mainphotoid'])),
                    $product['seo']);
                $product['mainphoto']['normal']  = $this->getSeoPhoto($gallery->getImagePath($gallery->getNormalImageById($product['mainphotoid'])),
                    $product['seo']);
                $product['mainphoto']['large']   = $this->getSeoPhoto($gallery->getImagePath($gallery->getLargeImageById($product['mainphotoid'])),
                    $product['seo']);
                $product['mainphoto']['orginal'] = $this->getSeoPhoto($gallery->getImagePath($gallery->getOrginalImageById($product['mainphotoid'])),
                    $product['seo']);
            }
            foreach ($product['otherphoto'] as $photo) {
                $product['otherphoto']['small'][]   = $this->getSeoPhoto($gallery->getImagePath($gallery->getSmallImageById($photo['photoid'])),
                    $product['seo']);
                $product['otherphoto']['normal'][]  = $this->getSeoPhoto($gallery->getImagePath($gallery->getNormalImageById($photo['photoid'])),
                    $product['seo']);
                $product['otherphoto']['large'][]   = $this->getSeoPhoto($gallery->getImagePath($gallery->getLargeImageById($photo['photoid'])),
                    $product['seo']);
                $product['otherphoto']['orginal'][] = $this->getSeoPhoto($gallery->getImagePath($gallery->getOrginalImageById($photo['photoid'])),
                    $product['seo']);
            }
        }
    }

    public function getSeoPhoto($str, $seo)
    {
        /*
		 * Rozbijamy wartość source przekazaną z DataSet na osobne zmienne.
		 * Separatorem jest : ale można stosować inne, takie które potencjalnie
		 * nie pojawią się w linkach SEO czy EAN
		 */
        $path = explode('/', $str);

        /*
			 * Obcinamy ostatni element tablicy
			 */
        $originalPhotoName = array_pop($path);

        /*
			 * Dodajemy seo produktu i slug -foto- do adresu i łączymy wszystko
			 * w całość
			 */
        array_push($path, $seo . '-foto-' . $originalPhotoName);

        return implode('/', $path);
    }

    public function getProducerAllByProductsSearch()
    {
        $sql
              = 'SELECT
					P.idproducer AS id,
					PT.name,
					PT.seo
				FROM producer P
				INNER JOIN product PR ON PR.producerid = P.idproducer
				LEFT JOIN producertranslation PT ON PT.producerid = P.idproducer AND PT.languageid = :language
				GROUP BY P.idproducer';
        $Data = [];
        $stmt = Db::getInstance()->prepare($sql);
        $stmt->bindValue('language', Helper::getLanguageId());
        $stmt->execute();
        while ($rs = $stmt->fetch()) {
            $Data[] = [
                'id'   => $rs['id'],
                'name' => $rs['name'],
                'seo'  => $rs['seo']
            ];
        }

        return $Data;
    }
}
