<?php
return [
    'en' => [
        [
            'name' => 'Dashboard',
            'url' => '/',
            'icon' => 'fa fa-dashboard',
            'route' => 'home',
            'contains' => false,
        ],
        [
            'name' => 'Price Comparison',
            'url' => 'comparison',
            'icon' => 'fa fa-square',
            'route' => 'products.comparison.index',
            'contains' => false,
        ],
        [
            'name' => 'My Shop',
            'icon' => 'fa fa-shopping-cart',
            'sub' => [
                /*[
                    'name'  => 'Overview',
                    'url'   => 'my-shop',
                    'route' => 'products.my'
                ],*/
                [
                    'name' => 'Products Overview',
                    'url' => 'my-shop',
                    'route' => 'products.my'
                ],
                [
                    'name' => 'Add Product',
                    'url' => 'products/create',
                    'route' => 'products.create'
                ],
                [
                    'name' => 'Import From Csv',
                    'url' => 'products/bulk-upload',
                    'route' => 'products.csv.index'
                ],
            ]
        ],
        [
            'name' => 'Competitors',
            'icon' => 'fa fa-users',
            'sub' => [
                [
                    'name' => 'Overview',
                    'url' => 'competitors',
                    'route' => 'competitors.index',
                ],
                [
                    'name' => 'Pages',
                    'url' => 'pages',
                    'route' => 'pages.index',
                ],
                [
                    'name' => 'Products',
                    'url' => 'products',
                    'route' => 'products.index'
                ],
                [
                    'name' => 'Add Product',
                    'url' => 'competitors/products/create',
                    'route' => 'competitors.products.create'
                ],
            ]
        ],
        /*[
            'name'  => 'Options Binding',
            'url'   => 'options-binding',
            'icon'  => 'fa fa-share-alt',
            'route' => 'options-binding',
        ],
        [
            'name'  => 'Options Comparison',
            'url'   => 'options-comparison',
            'icon'  => 'gi gi-sort',
            'route' => 'options-comparison',
        ],
        [
            'name'  => 'Options Overview',
            'url'   => 'options-overview',
            'icon'  => 'fa fa-list',
            'route' => 'options-overview',
        ],*/
        [
            'name' => 'Products Binding',
            'url' => 'binding',
            'icon' => 'fa fa-link',
            'route' => 'products.bindings.edit',
            'contains' => false,
        ],
        [
            'name' => 'Categories',
            'url' => 'categories',
            'icon' => 'fa fa-list-alt',
            'route' => 'categories.index',
            'group' => 'categories',
        ],
//        [
//            'name'  => 'Statistics',
//            'url'   => 'statistics',
//            'icon'  => 'gi gi-stats',
//            'route' => 'statistics.competitors.index',
//            'group' => 'statistics',
//        ],
        [
            'name' => 'Statistics',
            'icon' => 'fa fa-line-chart',
            'sub' => [
                [
                    'name' => 'Statistics Overview',
                    'url' => 'statistics',
                    'icon' => 'gi gi-stats',
                    'route' => 'statistics.competitors.index',
                    'group' => 'statistics',
                ],
                [
                    'name' => 'Top Daily Categories',
                    'url' => 'statistics/top-daily-categories',
                    'icon' => 'gi gi-stats',
                    'route' => 'statistics.trending.data.getCategories',
                    'group' => 'statistics',
                ],
                [
                    'name' => 'My Best Prices',
                    'url' => 'statistics/own-best-prices',
                    'route' => 'statistics.own.best.prices'
                ],
                [
                    'name' => 'Competitors Best Prices',
                    'url' => 'statistics/competitors-best-prices',
                    'route' => 'statistics.competitors.best.prices'
                ],
                [
                    'name' => 'Detailed Product Price',
                    'url' => 'statistics/detailed-product-price',
                    'route' => 'statistics.detailed.product.price'
                ],
//                [
//                    'name' => 'Category Percentage Difference',
//                    'url' => 'statistics/category-percentage-difference',
//                    'route' => 'statistics.category.percentage.difference'
//                ],
                [
                    'name' => 'Price Changes',
                    'url' => 'statistics/price-changes',
                    'icon' => 'gi gi-stats',
                    'route' => 'statistics.trending.data.priceChange',
                    'group' => 'statistics',
                ],
//                [
//                    'name' => 'Price Difference By Category',
//                    'url' => 'statistics/priceDifference',
//                    'icon' => 'gi gi-stats',
//                    'route' => 'statistics.priceDifferenceByCategory.index',
//                    'group' => 'statistics',
//                ]
            ]
        ],

        [
            'name' => 'Settings',
            'url' => 'settings-for-mobile',
            'icon' => 'fa fa-cogs',
            'route' => 'settings.for.mobile',
            'group' => 'settings',
        ],
    ],
    'de' => [
        [
            'name' => 'Dashboard',
            'url' => '/',
            'icon' => 'fa fa-dashboard',
            'route' => 'home',
            'contains' => false,
        ],
        [
            'name' => 'Preisvergleich',
            'url' => 'comparison',
            'icon' => 'fa fa-square',
            'route' => 'products.comparison.index',
            'contains' => false,
        ],
        [
            'name' => 'Mein Shop',
            'icon' => 'fa fa-shopping-cart',
            'sub' => [
                /*[
                    'name'  => 'Übersicht',
                    'url'   => 'mein-laden',
                    'route' => 'products.my'
                ],*/
                [
                    'name' => 'Produktübersicht',
                    'url' => 'my-shop',
                    'route' => 'products.my'
                ],
                [
                    'name' => 'Produkte Hinzufügen',
                    'url' => 'products/create',
                    'route' => 'products.create'
                ],
                [
                    'name' => 'Aus CSV Importieren',
                    'url' => 'products/bulk-upload',
                    'route' => 'products.csv.index'
                ],
            ]
        ],
        [
            'name' => 'Wettbewerber',
            'icon' => 'fa fa-users',
            'sub' => [
                [
                    'name' => 'Übersicht',
                    'url' => 'competitors',
                    'route' => 'competitors.index',
                ],
                [
                    'name' => 'Seiten',
                    'url' => 'pages',
                    'route' => 'pages.index',
                ],
                [
                    'name' => 'Produktübersicht',
                    'url' => 'products',
                    'route' => 'products.index'
                ],
                [
                    'name' => 'Produkte hinzufügen',
                    'url' => 'competitors/products/create',
                    'route' => 'competitors.products.create'
                ],
            ]
        ],
        /*[
            'name'  => 'Optionen Verknüpfen',
            'url'   => 'optionen-verknupfen',
            'icon'  => 'fa fa-share-alt',
            'route' => 'options-binding',
        ],
        [
            'name'  => 'Optionen-Preisvergleich',
            'url'   => 'optionen-preisvergleich',
            'icon'  => 'gi gi-sort',
            'route' => 'options-comparison',
        ],
        [
            'name'  => 'Optionen Übersicht',
            'url'   => 'optionen-ubersicht',
            'icon'  => 'fa fa-list',
            'route' => 'options-overview',
        ],*/
        [
            'name' => 'Produkte Verknüpfen',
            'url' => 'binding',
            'icon' => 'fa fa-link',
            'route' => 'products.bindings.edit',
            'contains' => false,
        ],
        [
            'name' => 'Kategorien',
            'url' => 'categories',
            'icon' => 'fa fa-list-alt',
            'route' => 'categories.index',
            'group' => 'categories',
        ],
//        [
//            'name'  => 'Statistiken',
//            'url'   => 'statistiken',
//            'icon'  => 'gi gi-stats',
//            'route' => 'statistics.index',
//            'group' => 'statistics',
//        ],
        [
            'name' => 'Statistiken',
            'icon' => 'fa fa-line-chart',
            'sub' => [
                [
                    'name' => 'Statistiken Übersicht',
                    'url' => 'statistics',
                    'icon' => 'gi gi-stats',
                    'route' => 'statistics.competitors.index',
                    'group' => 'statistics',
                ],
                [
                    'name' => 'Tägliche Kategorien',
                    'url' => 'statistics/top-daily-categories',
                    'icon' => 'gi gi-stats',
                    'route' => 'statistics.trending.data.getCategories',
                    'group' => 'statistics',
                ],
                [
                    'name' => 'Eigener Bestpreis',
                    'url' => 'statistics/own-best-prices',
                    'route' => 'statistics.own.best.prices'
                ],
                [
                    'name' => 'Wettbewerber Bestpreis',
                    'url' => 'statistics/competitors-best-prices',
                    'route' => 'statistics.competitors.best.prices'
                ],
                [
                    'name'  => 'Produktpreise im Detail',
                    'url'   => 'statistics/detailed-product-price',
                    'route' => 'statistics.detailed.product.price'
                ],

//                [
//                    'name' => 'Kategorie Prozentsatzunterschied',
//                    'url' => 'statistics/category-percentage-difference',
//                    'route' => 'statistics.category.percentage.difference'
//                ],

                [
                    'name' => 'Preisänderungen',
                    'url' => 'statistics/price-changes',
                    'icon' => 'gi gi-stats',
                    'route' => 'statistics.trending.data.priceChange',
                    'group' => 'statistics',
                ],
//                [
//                    'name' => 'Preisunterschied nach Kategorien',
//                    'url' => 'statistics/priceDifference',
//                    'icon' => 'gi gi-stats',
//                    'route' => 'statistics.priceDifferenceByCategory.index',
//                    'group' => 'statistics',
//                ]

            ]
        ],

        [
            'name' => 'Einstellungen',
            'url' => 'settings-for-mobile',
            'icon' => 'fa fa-cogs',
            'route' => 'settings.for.mobile',
            'group' => 'settings',
        ],
    ],
];
