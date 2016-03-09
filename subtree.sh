#!/bin/bash
git subtree add --prefix=src/WellCommerce/Bundle/UnitBundle git@github.com:WellCommerce/UnitBundle.git master
git subtree push --prefix=src/WellCommerce/Bundle/UnitBundle git@github.com:WellCommerce/UnitBundle.git master
