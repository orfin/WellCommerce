#!/usr/bin/env bash

action=$1

if [ "$action" == 'init' ]
    then
        rm -rf src/WellCommerce/Bundle/*
        rm -rf src/WellCommerce/Component/*
        rm -rf web/themes/wellcommerce-default-theme
        git commit -a -m "Reinitializing subtrees"

        git subtree add --prefix=src/WellCommerce/Component/Collections git@github.com:WellCommerce/Collections.git master
        git subtree add --prefix=src/WellCommerce/Component/DataSet git@github.com:WellCommerce/DataSet.git master
        git subtree add --prefix=src/WellCommerce/Component/DataGrid git@github.com:WellCommerce/DataGrid.git master
        git subtree add --prefix=src/WellCommerce/Component/Form git@github.com:WellCommerce/Form.git master
        git subtree add --prefix=src/WellCommerce/Bundle/AdminBundle git@github.com:WellCommerce/AdminBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ApiBundle git@github.com:WellCommerce/ApiBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/AppBundle git@github.com:WellCommerce/AppBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/AttributeBundle git@github.com:WellCommerce/AttributeBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/AvailabilityBundle git@github.com:WellCommerce/AvailabilityBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/CompanyBundle git@github.com:WellCommerce/CompanyBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/CategoryBundle git@github.com:WellCommerce/CategoryBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ClientBundle git@github.com:WellCommerce/ClientBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ContactBundle git@github.com:WellCommerce/ContactBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/CoreBundle git@github.com:WellCommerce/CoreBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/CountryBundle git@github.com:WellCommerce/CountryBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/CouponBundle git@github.com:WellCommerce/CouponBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/CurrencyBundle git@github.com:WellCommerce/CurrencyBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/DelivererBundle git@github.com:WellCommerce/DelivererBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/DictionaryBundle git@github.com:WellCommerce/DictionaryBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/DistributionBundle git@github.com:WellCommerce/DistributionBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/DoctrineBundle git@github.com:WellCommerce/DoctrineBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/LayeredNavigationBundle git@github.com:WellCommerce/LayeredNavigationBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/LayoutBundle git@github.com:WellCommerce/LayoutBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/LocaleBundle git@github.com:WellCommerce/LocaleBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/MediaBundle git@github.com:WellCommerce/MediaBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/NewsBundle git@github.com:WellCommerce/NewsBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/PageBundle git@github.com:WellCommerce/PageBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/OAuthBundle git@github.com:WellCommerce/OAuthBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/OrderBundle git@github.com:WellCommerce/OrderBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/PaymentBundle git@github.com:WellCommerce/PaymentBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ProductBundle git@github.com:WellCommerce/ProductBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ProductStatusBundle git@github.com:WellCommerce/ProductStatusBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ProducerBundle git@github.com:WellCommerce/ProducerBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ReportBundle git@github.com:WellCommerce/ReportBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ReviewBundle git@github.com:WellCommerce/ReviewBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/RoutingBundle git@github.com:WellCommerce/RoutingBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/SearchBundle git@github.com:WellCommerce/SearchBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ShippingBundle git@github.com:WellCommerce/ShippingBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ShopBundle git@github.com:WellCommerce/ShopBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/TaxBundle git@github.com:WellCommerce/TaxBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/ThemeBundle git@github.com:WellCommerce/ThemeBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/UnitBundle git@github.com:WellCommerce/UnitBundle.git master
        git subtree add --prefix=src/WellCommerce/Bundle/WishlistBundle git@github.com:WellCommerce/WishlistBundle.git master
        git subtree add --prefix=web/themes/wellcommerce-default-theme git@github.com:WellCommerce/wellcommerce-default-theme.git master
fi

if [ "$action" == 'push' ]
    then
        git commit -a -m "Pushing changes before synchronizing subtrees"

        git subtree push --prefix=src/WellCommerce/Component/Collections git@github.com:WellCommerce/Collections.git master
        git subtree push --prefix=src/WellCommerce/Component/DataSet git@github.com:WellCommerce/DataSet.git master
        git subtree push --prefix=src/WellCommerce/Component/DataGrid git@github.com:WellCommerce/DataGrid.git master
        git subtree push --prefix=src/WellCommerce/Component/Form git@github.com:WellCommerce/Form.git master
        git subtree push --prefix=src/WellCommerce/Bundle/AdminBundle git@github.com:WellCommerce/AdminBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ApiBundle git@github.com:WellCommerce/ApiBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/AppBundle git@github.com:WellCommerce/AppBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/AttributeBundle git@github.com:WellCommerce/AttributeBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/AvailabilityBundle git@github.com:WellCommerce/AvailabilityBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/CompanyBundle git@github.com:WellCommerce/CompanyBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/CategoryBundle git@github.com:WellCommerce/CategoryBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ClientBundle git@github.com:WellCommerce/ClientBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ContactBundle git@github.com:WellCommerce/ContactBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/CoreBundle git@github.com:WellCommerce/CoreBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/CountryBundle git@github.com:WellCommerce/CountryBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/CouponBundle git@github.com:WellCommerce/CouponBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/CurrencyBundle git@github.com:WellCommerce/CurrencyBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/DelivererBundle git@github.com:WellCommerce/DelivererBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/DictionaryBundle git@github.com:WellCommerce/DictionaryBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/DistributionBundle git@github.com:WellCommerce/DistributionBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/DoctrineBundle git@github.com:WellCommerce/DoctrineBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/LayeredNavigationBundle git@github.com:WellCommerce/LayeredNavigationBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/LayoutBundle git@github.com:WellCommerce/LayoutBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/LocaleBundle git@github.com:WellCommerce/LocaleBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/MediaBundle git@github.com:WellCommerce/MediaBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/NewsBundle git@github.com:WellCommerce/NewsBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/PageBundle git@github.com:WellCommerce/PageBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/OAuthBundle git@github.com:WellCommerce/OAuthBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/OrderBundle git@github.com:WellCommerce/OrderBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/PaymentBundle git@github.com:WellCommerce/PaymentBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ProductBundle git@github.com:WellCommerce/ProductBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ProductStatusBundle git@github.com:WellCommerce/ProductStatusBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ProducerBundle git@github.com:WellCommerce/ProducerBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ReportBundle git@github.com:WellCommerce/ReportBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ReviewBundle git@github.com:WellCommerce/ReviewBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/RoutingBundle git@github.com:WellCommerce/RoutingBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/SearchBundle git@github.com:WellCommerce/SearchBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ShippingBundle git@github.com:WellCommerce/ShippingBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ShopBundle git@github.com:WellCommerce/ShopBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/TaxBundle git@github.com:WellCommerce/TaxBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/ThemeBundle git@github.com:WellCommerce/ThemeBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/UnitBundle git@github.com:WellCommerce/UnitBundle.git master
        git subtree push --prefix=src/WellCommerce/Bundle/WishlistBundle git@github.com:WellCommerce/WishlistBundle.git master
        git subtree push --prefix=web/themes/wellcommerce-default-theme git@github.com:WellCommerce/wellcommerce-default-theme.git master
fi

if [ "$action" == 'pull' ]
    then
        git commit -a -m "Pushing changes before synchronizing subtrees"

        git subtree pull --prefix=src/WellCommerce/Component/Collections git@github.com:WellCommerce/Collections.git master
        git subtree pull --prefix=src/WellCommerce/Component/DataSet git@github.com:WellCommerce/DataSet.git master
        git subtree pull --prefix=src/WellCommerce/Component/DataGrid git@github.com:WellCommerce/DataGrid.git master
        git subtree pull --prefix=src/WellCommerce/Component/Form git@github.com:WellCommerce/Form.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/AdminBundle git@github.com:WellCommerce/AdminBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ApiBundle git@github.com:WellCommerce/ApiBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/AppBundle git@github.com:WellCommerce/AppBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/AttributeBundle git@github.com:WellCommerce/AttributeBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/AvailabilityBundle git@github.com:WellCommerce/AvailabilityBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/CompanyBundle git@github.com:WellCommerce/CompanyBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/CategoryBundle git@github.com:WellCommerce/CategoryBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ClientBundle git@github.com:WellCommerce/ClientBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ContactBundle git@github.com:WellCommerce/ContactBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/CoreBundle git@github.com:WellCommerce/CoreBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/CountryBundle git@github.com:WellCommerce/CountryBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/CouponBundle git@github.com:WellCommerce/CouponBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/CurrencyBundle git@github.com:WellCommerce/CurrencyBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/DelivererBundle git@github.com:WellCommerce/DelivererBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/DictionaryBundle git@github.com:WellCommerce/DictionaryBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/DistributionBundle git@github.com:WellCommerce/DistributionBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/DoctrineBundle git@github.com:WellCommerce/DoctrineBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/LayeredNavigationBundle git@github.com:WellCommerce/LayeredNavigationBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/LayoutBundle git@github.com:WellCommerce/LayoutBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/LocaleBundle git@github.com:WellCommerce/LocaleBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/MediaBundle git@github.com:WellCommerce/MediaBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/NewsBundle git@github.com:WellCommerce/NewsBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/PageBundle git@github.com:WellCommerce/PageBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/OAuthBundle git@github.com:WellCommerce/OAuthBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/OrderBundle git@github.com:WellCommerce/OrderBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/PaymentBundle git@github.com:WellCommerce/PaymentBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ProductBundle git@github.com:WellCommerce/ProductBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ProductStatusBundle git@github.com:WellCommerce/ProductStatusBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ProducerBundle git@github.com:WellCommerce/ProducerBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ReportBundle git@github.com:WellCommerce/ReportBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ReviewBundle git@github.com:WellCommerce/ReviewBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/RoutingBundle git@github.com:WellCommerce/RoutingBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/SearchBundle git@github.com:WellCommerce/SearchBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ShippingBundle git@github.com:WellCommerce/ShippingBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ShopBundle git@github.com:WellCommerce/ShopBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/TaxBundle git@github.com:WellCommerce/TaxBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/ThemeBundle git@github.com:WellCommerce/ThemeBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/UnitBundle git@github.com:WellCommerce/UnitBundle.git master
        git subtree pull --prefix=src/WellCommerce/Bundle/WishlistBundle git@github.com:WellCommerce/WishlistBundle.git master
        git subtree pull --prefix=web/themes/wellcommerce-default-theme git@github.com:WellCommerce/wellcommerce-default-theme.git master
fi
