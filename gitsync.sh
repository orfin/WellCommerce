#!/usr/bin/env bash

action=$1

if [ "$action" == 'clear' ]
    then
        git stree clear
        git remote rm stree-adminbundle
        git remote rm stree-apibundle
        git remote rm stree-appbundle
        git remote rm stree-attributebundle
        git remote rm stree-availabilitybundle
        git remote rm stree-cartbundle
        git remote rm stree-categorybundle
        git remote rm stree-clientbundle
        git remote rm stree-collections
        git remote rm stree-companybundle
        git remote rm stree-contactbundle
        git remote rm stree-corebundle
        git remote rm stree-countrybundle
        git remote rm stree-couponbundle
        git remote rm stree-currencybundle
        git remote rm stree-datagrid
        git remote rm stree-dataset
        git remote rm stree-delivererbundle
        git remote rm stree-dictionarybundle
        git remote rm stree-distributionbundle
        git remote rm stree-doctrinebundle
        git remote rm stree-form
        git remote rm stree-generatorbundle
        git remote rm stree-layerednavigationbundle
        git remote rm stree-layoutbundle
        git remote rm stree-localebundle
        git remote rm stree-mediabundle
        git remote rm stree-newsbundle
        git remote rm stree-orderbundle
        git remote rm stree-oauthbundle
        git remote rm stree-pagebundle
        git remote rm stree-paymentbundle
        git remote rm stree-producerbundle
        git remote rm stree-productbundle
        git remote rm stree-productstatusbundle
        git remote rm stree-reportbundle
        git remote rm stree-reviewbundle
        git remote rm stree-routingbundle
        git remote rm stree-searchbundle
        git remote rm stree-shippingbundle
        git remote rm stree-shopbundle
        git remote rm stree-taxbundle
        git remote rm stree-themebundle
        git remote rm stree-unitbundle
        git remote rm stree-wellcommerce-default-theme
        git remote rm stree-wishlistbundle

        git branch -D stree-backports-adminbundle
        git branch -D stree-backports-apibundle
        git branch -D stree-backports-appbundle
        git branch -D stree-backports-attributebundle
        git branch -D stree-backports-availabilitybundle
        git branch -D stree-backports-cartbundle
        git branch -D stree-backports-categorybundle
        git branch -D stree-backports-clientbundle
        git branch -D stree-backports-collections
        git branch -D stree-backports-companybundle
        git branch -D stree-backports-contactbundle
        git branch -D stree-backports-corebundle
        git branch -D stree-backports-countrybundle
        git branch -D stree-backports-couponbundle
        git branch -D stree-backports-currencybundle
        git branch -D stree-backports-datagrid
        git branch -D stree-backports-dataset
        git branch -D stree-backports-delivererbundle
        git branch -D stree-backports-dictionarybundle
        git branch -D stree-backports-distributionbundle
        git branch -D stree-backports-doctrinebundle
        git branch -D stree-backports-form
        git branch -D stree-backports-layerednavigationbundle
        git branch -D stree-backports-layoutbundle
        git branch -D stree-backports-localebundle
        git branch -D stree-backports-mediabundle
        git branch -D stree-backports-newsbundle
        git branch -D stree-backports-orderbundle
        git branch -D stree-backports-oauthbundle
        git branch -D stree-backports-pagebundle
        git branch -D stree-backports-paymentbundle
        git branch -D stree-backports-producerbundle
        git branch -D stree-backports-productbundle
        git branch -D stree-backports-productstatusbundle
        git branch -D stree-backports-reportbundle
        git branch -D stree-backports-reviewbundle
        git branch -D stree-backports-routingbundle
        git branch -D stree-backports-searchbundle
        git branch -D stree-backports-shippingbundle
        git branch -D stree-backports-shopbundle
        git branch -D stree-backports-taxbundle
        git branch -D stree-backports-themebundle
        git branch -D stree-backports-unitbundle
        git branch -D stree-backports-wellcommerce-default-theme
        git branch -D stree-backports-wishlistbundle

        rm -rf src/WellCommerce/Bundle/*
        rm -rf src/WellCommerce/Component/*
        rm -rf web/themes/wellcommerce-default-theme
fi

if [ "$action" == 'init' ]
    then
        git stree add Collections -P src/WellCommerce/Component/Collections git@github.com:WellCommerce/Collections.git
        git stree add DataSet -P src/WellCommerce/Component/DataSet git@github.com:WellCommerce/DataSet.git
        git stree add DataGrid -P src/WellCommerce/Component/DataGrid git@github.com:WellCommerce/DataGrid.git
        git stree add Form -P src/WellCommerce/Component/Form git@github.com:WellCommerce/Form.git
        git stree add AdminBundle -P src/WellCommerce/Bundle/AdminBundle git@github.com:WellCommerce/AdminBundle.git
        git stree add ApiBundle -P src/WellCommerce/Bundle/ApiBundle git@github.com:WellCommerce/ApiBundle.git
        git stree add AppBundle -P src/WellCommerce/Bundle/AppBundle git@github.com:WellCommerce/AppBundle.git
        git stree add AttributeBundle -P src/WellCommerce/Bundle/AttributeBundle git@github.com:WellCommerce/AttributeBundle.git
        git stree add AvailabilityBundle -P src/WellCommerce/Bundle/AvailabilityBundle git@github.com:WellCommerce/AvailabilityBundle.git
        git stree add CompanyBundle -P src/WellCommerce/Bundle/CompanyBundle git@github.com:WellCommerce/CompanyBundle.git
        git stree add CategoryBundle -P src/WellCommerce/Bundle/CategoryBundle git@github.com:WellCommerce/CategoryBundle.git
        git stree add CartBundle -P src/WellCommerce/Bundle/CartBundle git@github.com:WellCommerce/CartBundle.git
        git stree add ClientBundle -P src/WellCommerce/Bundle/ClientBundle git@github.com:WellCommerce/ClientBundle.git
        git stree add ContactBundle -P src/WellCommerce/Bundle/ContactBundle git@github.com:WellCommerce/ContactBundle.git
        git stree add CoreBundle -P src/WellCommerce/Bundle/CoreBundle git@github.com:WellCommerce/CoreBundle.git
        git stree add CountryBundle -P src/WellCommerce/Bundle/CountryBundle git@github.com:WellCommerce/CountryBundle.git
        git stree add CouponBundle -P src/WellCommerce/Bundle/CouponBundle git@github.com:WellCommerce/CouponBundle.git
        git stree add CurrencyBundle -P src/WellCommerce/Bundle/CurrencyBundle git@github.com:WellCommerce/CurrencyBundle.git
        git stree add DelivererBundle -P src/WellCommerce/Bundle/DelivererBundle git@github.com:WellCommerce/DelivererBundle.git
        git stree add DictionaryBundle -P src/WellCommerce/Bundle/DictionaryBundle git@github.com:WellCommerce/DictionaryBundle.git
        git stree add DistributionBundle -P src/WellCommerce/Bundle/DistributionBundle git@github.com:WellCommerce/DistributionBundle.git
        git stree add DoctrineBundle -P src/WellCommerce/Bundle/DoctrineBundle git@github.com:WellCommerce/DoctrineBundle.git
        git stree add LayeredNavigationBundle -P src/WellCommerce/Bundle/LayeredNavigationBundle git@github.com:WellCommerce/LayeredNavigationBundle.git
        git stree add LayoutBundle -P src/WellCommerce/Bundle/LayoutBundle git@github.com:WellCommerce/LayoutBundle.git
        git stree add LocaleBundle -P src/WellCommerce/Bundle/LocaleBundle git@github.com:WellCommerce/LocaleBundle.git
        git stree add MediaBundle -P src/WellCommerce/Bundle/MediaBundle git@github.com:WellCommerce/MediaBundle.git
        git stree add NewsBundle -P src/WellCommerce/Bundle/NewsBundle git@github.com:WellCommerce/NewsBundle.git
        git stree add PageBundle -P src/WellCommerce/Bundle/PageBundle git@github.com:WellCommerce/PageBundle.git
        git stree add OAuthBundle -P src/WellCommerce/Bundle/OAuthBundle git@github.com:WellCommerce/OAuthBundle.git
        git stree add OrderBundle -P src/WellCommerce/Bundle/OrderBundle git@github.com:WellCommerce/OrderBundle.git
        git stree add PaymentBundle -P src/WellCommerce/Bundle/PaymentBundle git@github.com:WellCommerce/PaymentBundle.git
        git stree add ProductBundle -P src/WellCommerce/Bundle/ProductBundle git@github.com:WellCommerce/ProductBundle.git
        git stree add ProductStatusBundle -P src/WellCommerce/Bundle/ProductStatusBundle git@github.com:WellCommerce/ProductStatusBundle.git
        git stree add ProducerBundle -P src/WellCommerce/Bundle/ProducerBundle git@github.com:WellCommerce/ProducerBundle.git
        git stree add ReportBundle -P src/WellCommerce/Bundle/ReportBundle git@github.com:WellCommerce/ReportBundle.git
        git stree add ReviewBundle -P src/WellCommerce/Bundle/ReviewBundle git@github.com:WellCommerce/ReviewBundle.git
        git stree add RoutingBundle -P src/WellCommerce/Bundle/RoutingBundle git@github.com:WellCommerce/RoutingBundle.git
        git stree add SearchBundle -P src/WellCommerce/Bundle/SearchBundle git@github.com:WellCommerce/SearchBundle.git
        git stree add ShippingBundle -P src/WellCommerce/Bundle/ShippingBundle git@github.com:WellCommerce/ShippingBundle.git
        git stree add ShopBundle -P src/WellCommerce/Bundle/ShopBundle git@github.com:WellCommerce/ShopBundle.git
        git stree add TaxBundle -P src/WellCommerce/Bundle/TaxBundle git@github.com:WellCommerce/TaxBundle.git
        git stree add ThemeBundle -P src/WellCommerce/Bundle/ThemeBundle git@github.com:WellCommerce/ThemeBundle.git
        git stree add UnitBundle -P src/WellCommerce/Bundle/UnitBundle git@github.com:WellCommerce/UnitBundle.git
        git stree add WishlistBundle -P src/WellCommerce/Bundle/WishlistBundle git@github.com:WellCommerce/WishlistBundle.git
        git stree add wellcommerce-default-theme -P web/themes/wellcommerce-default-theme git@github.com:WellCommerce/wellcommerce-default-theme.git
fi

if [ "$action" == 'push' ]
    then
        git stree push AdminBundle
        git stree push ApiBundle
        git stree push AppBundle
        git stree push AttributeBundle
        git stree push AvailabilityBundle
        git stree push CartBundle
        git stree push CategoryBundle
        git stree push ClientBundle
        git stree push Collections
        git stree push CompanyBundle
        git stree push ContactBundle
        git stree push CoreBundle
        git stree push CountryBundle
        git stree push CouponBundle
        git stree push CurrencyBundle
        git stree push DataGrid
        git stree push DataSet
        git stree push DelivererBundle
        git stree push DictionaryBundle
        git stree push DistributionBundle
        git stree push DoctrineBundle
        git stree push Form
        git stree push LayeredNavigationBundle
        git stree push LayoutBundle
        git stree push LocaleBundle
        git stree push MediaBundle
        git stree push NewsBundle
        git stree push OrderBundle
        git stree push OAuthBundle
        git stree push PageBundle
        git stree push PaymentBundle
        git stree push ProducerBundle
        git stree push ProductBundle
        git stree push ProductStatusBundle
        git stree push ReportBundle
        git stree push ReviewBundle
        git stree push RoutingBundle
        git stree push SearchBundle
        git stree push ShippingBundle
        git stree push ShopBundle
        git stree push TaxBundle
        git stree push ThemeBundle
        git stree push UnitBundle
        git stree push WishlistBundle
        git stree push wellcommerce-default-theme
fi
