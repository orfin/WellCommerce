#!/usr/bin/env bash

# Add components
git stree add Collections -P src/WellCommerce/Component/Collections git@github.com:WellCommerce/Collections.git
git stree add DataSet -P src/WellCommerce/Component/DataSet git@github.com:WellCommerce/DataSet.git
git stree add DataGrid -P src/WellCommerce/Component/DataGrid git@github.com:WellCommerce/DataGrid.git
git stree add Form -P src/WellCommerce/Component/Form git@github.com:WellCommerce/Form.git

# Add bundles
git stree add CategoryBundle -P src/WellCommerce/Bundle/CategoryBundle git@github.com:WellCommerce/CategoryBundle.git
git stree add CouponBundle -P src/WellCommerce/Bundle/CouponBundle git@github.com:WellCommerce/CouponBundle.git
git stree add CurrencyBundle -P src/WellCommerce/Bundle/CurrencyBundle git@github.com:WellCommerce/CurrencyBundle.git
git stree add DelivererBundle -P src/WellCommerce/Bundle/DelivererBundle git@github.com:WellCommerce/DelivererBundle.git
git stree add DictionaryBundle -P src/WellCommerce/Bundle/DictionaryBundle git@github.com:WellCommerce/DictionaryBundle.git
git stree add LocaleBundle -P src/WellCommerce/Bundle/LocaleBundle git@github.com:WellCommerce/LocaleBundle.git
git stree add MediaBundle -P src/WellCommerce/Bundle/MediaBundle git@github.com:WellCommerce/MediaBundle.git
git stree add NewsBundle -P src/WellCommerce/Bundle/NewsBundle git@github.com:WellCommerce/NewsBundle.git
git stree add PageBundle -P src/WellCommerce/Bundle/PageBundle git@github.com:WellCommerce/PageBundle.git
git stree add PaymentBundle -P src/WellCommerce/Bundle/PaymentBundle git@github.com:WellCommerce/PaymentBundle.git
git stree add ProductBundle -P src/WellCommerce/Bundle/ProductBundle git@github.com:WellCommerce/ProductBundle.git
git stree add ProducerBundle -P src/WellCommerce/Bundle/ProducerBundle git@github.com:WellCommerce/ProducerBundle.git
git stree add ShippingBundle -P src/WellCommerce/Bundle/ShippingBundle git@github.com:WellCommerce/ShippingBundle.git
git stree add ShopBundle -P src/WellCommerce/Bundle/ShopBundle git@github.com:WellCommerce/ShopBundle.git
git stree add TaxBundle -P src/WellCommerce/Bundle/TaxBundle git@github.com:WellCommerce/TaxBundle.git
git stree add ThemeBundle -P src/WellCommerce/Bundle/ThemeBundle git@github.com:WellCommerce/ThemeBundle.git

git stree push Form
git stree push DataSet
git stree push DataGrid
git stree push Collections
git stree push TaxBundle
git stree push LocaleBundle
