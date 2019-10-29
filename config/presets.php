<?php

return [
    'woo-commerce' => [
        'element' => '.product',
        'pagination' => 'page/',
        'name' => [
            '.woocommerce-LoopProduct-link > h3',
            '.item_name > strong',
            '.woocommerce-loop-product__title',
            '.inner_product_header > h3',
        ],
        'price' => [
            '.price > ins',
            '.price'
        ],
        'link' => [
            '.woocommerce-LoopProduct-link',
            'a.item_name'
        ],
        'sp' => [
            'price' => [
                'selectors' => [
                    '.product_price',
                    '.woocommerce-Price-amount',
                ],
            ],
            'description' => [
                'selectors' => '.woocommerce-product-details__short-description',
            ],
            'name' => [
                'selectors' => [
                    '.product_title',
                    '.entry-title',
                    'h1',
                ],
            ]
        ]
    ],
    'magento' => [
        'element' => '.product-item',
        'name' => ['.product-item-name'],
        'price' => ['.price'],
        'link' => ['.product-item-link'],
        'pagination' => '/page/'
    ],
    'shopify' => [
        'element' => '.product',
        'name' => [
            '.title',
            '.product-title'
        ],
        'price' => [
            '.money',
            '.price'
        ],
        'link' => [
            '.details > a',
            '.product > a'
        ],
        'pagination' => '?page='
    ],
    'shopify-1' => [
        'element' => '.product-item',
        'name' => [
            '.title',
            '.name',
        ],
        'price' => ['.money'],
        'link' => ['a'],
        'pagination' => '?page='
    ],
    'shopify-2' => [
        'element' => '.prod-item',
        'name' => ['.prod-name'],
        'price' => [
            '.money',
            '.prod-price',
            '.product-price',
        ],
        'link' => ['.prod-name > a'],
        'pagination' => '?page='
    ],
    'shopify-3' => [
        'element' => '.product-list-item',
        'name' => ['.product-list-item-title'],
        'price' => [
            '.money',
            '.product-list-item-price',
        ],
        'link' => ['.product-list-item-title > a'],
        'pagination' => '?page='
    ],
    'shopify-4' => [
        'element' => '.products > li',
        'name' => ['.name'],
        'price' => [
            '.amount',
            '.price',
        ],
        'link' => ['a'],
        'pagination' => '?p='
    ],
    'presta-shop' => [
        'element' => '.ajax_block_product',
        'name' => [
            '.product-name',
            '.product-title',
            'h3'
        ],
        'link' => [
            '.product-name > a',
            '.list-content',
            'h3 > a'
        ],
        'price' => [
            '.price',
            '.product-price',
            '.content_price',
        ],
        'pagination' => '?p=',
        'sp' => [
            'price' => [
                '#our_price_display',
                '.price',
            ],
            'description' => '#short_description_content',
            'name' => 'h1'
        ]
    ],
    'presta-shop-1' => [
        'element' => '.products_list > li',
        'name' => ['.cdl-prd-list-name'],
        'link' => ['a'],
        'price' => ['.cdl-prd-list-price'],
        //'pagination' => '?page=',
    ],
    'presta-shop-2' => [
        'element' => '.grid-product',
        'name' => ['.product-name'],
        'link' => [
            '.product-container > a',
            '.product-image-container > a',
            '.name > a',
        ],
        'price' => ['.price'],
        'pagination' => '?page=',
    ],
    'presta-shop-3' => [
        'element' => '.products_list_item',
        'name' => 'h5',
        'link' => 'h5 > a',
        'price' => '.price',
        'description' => 'p[itemprop=description]',
        'pagination' => '?page=',
        'sp' => [
            'price' => '.price',
            'description' => '#short_description_block',
            'name' => 'h1[itemprop=name]'
        ]
    ],
    'presta-shop-4' => [
        'element' => '.product-container',
        'name' => '.product-name',
        'link' => 'a',
        'price' => [
            '.price',
            'span[itemprop=price]'
        ],
        'pagination' => '?page=',
        'sp' => [
            'price' => '.price',
            'description' => [
                '.product-description-short',
                '.attributes_product',
            ],
            'name' => 'h1[itemprop=name]'
        ]
    ],
    'opencart' => [
        'element' => '.product-grid > div', // .product-list-wrap > div, .product-grid > li
        'name' => ['.name'],
        'price' => [
            '.price-new',
            '.price'
        ],
        'link' => ['.name > a'],
        'pagination' => '?page='
    ],
    'opencart-1' => [
        'element' => '.product.box',
        'name' => ['.name'],
        'price' => ['.price'],
        'link' => ['.more-info'],
        'pagination' => '?page=',
    ],
    'opencart-2' => [
        'element' => '.each-product',
        'name' => ['.list-product-name'],
        'link' => ['.product-image'],
        'price' => [
            '.price',
            '.regular-price',
        ],
        'pagination' => '?p='
    ],
    'opencart-3' => [
        'element' => '.span-2',
        'name' => ['.name'],
        'link' => ['.banner-square > a'],
        'price' => ['.price'],
        'pagination' => '?page='
    ],
    'opencart-4' => [
        'element' => '.product-wrapper',
        'name' => ['.name'],
        'link' => ['.image > a'],
        'price' => [
            '.price-new',
            '.price',
        ],
        'pagination' => '?page='
    ],
    'opencart-5' => [
        'element' => '.product-thumb',
        'name' => ['.caption > h4'],
        'link' => ['.caption > h4'],
        'price' => [
            '.price-weight',
            '.price_box',
        ],
        'pagination' => '?page='
    ],
    'opencart-6' => [
        'element' => '.product',
        'name' => ['h2'],
        'link' => ['.product-image'],
        'price' => [
            '.price',
            '.price-box',
        ],
        'pagination' => '?page='
    ],
    'bigcommerce' => [
        'element' => '.ProductList > li',
        'name' => ['.ProductName'],
        'link' => ['.ProductName > a'],
        'price' => ['.ProductPrice'],
        'pagination' => '?page=',
    ],
    'bigcommerce-1' => [
        'element' => '.product',
        'name' => ['.card-title'],
        'link' => ['.card-title > a'],
        'price' => [
            '.price',
            '.price--withTax',
            '.price--withoutTax',
        ],
        'pagination' => '?page=',
        'sp' => [
            'title' => '.productView-title',
            'price' =>  'meta[itemprop=price]',
            'description' => [
                'div.productView-description',
                '#tab-description > p',
                '.productView-description-tabContent',
            ],
        ],
    ],
    'bigcommerce-2' => [
        'element' => '.ProductList > li',
        'name' => ['.pname'],
        'link' => ['.pname'],
        'price' => ['.p-price'],
        'pagination' => '?page=',
    ],
    'bigcommerce-3' => [
        'element' => '.product',
        'name' => ['.listItem-title'],
        'link' => ['.listItem-title > a'],
        'price' => [
            '.price--withoutTax',
            '.price',
        ],
        'pagination' => '?page=',
        'sp' => [
            'title' => [
                'selectors' => '.productView-title',
            ],
            'price' => [
                'selectors' => 'meta[itemprop=price]',
            ],
            'description' => [
                'selectors' => [
                    '.product-overview',
                ],
            ],
        ]
    ],
    'hybris-1' => [
        'element' => '.product-item',
        'name' => ['.name'],
        'link' => ['.name'],
        'price' => [
            '.discount-price > .amount',
            '.price > .amount'
        ],
        'pagination' => '?page='
    ],
    'hybris-2' => [
        'element' => '.product-tile',
        'name' => ['.name'],
        'link' => ['.product-details > a'],
        'price' => [
            '.pNow',
            '.pricing'
        ],
        'pagination' => '?page='
    ],
    'oxid' => [
        'element' => '.productData',
        'name' => ['.title'],
        'link' => [
            '.title',
            '.fn',
            'a'
        ],
        'price' => [
            '.priceContainer',
            '.priceBlock'
        ],
        'pagination' => '/'//'&pgNr='
    ],
    'oxid-1' => [
        'element' => '.productData',
        'name' => ['.emproduct_title'],
        'link' => ['.emproduct_title'],
        'price' => ['.price'],
        'pagination' => '/',
    ],
    'oxid-2' => [
        'element' => '.product_box',
        'name' => ['.emproduct_title'],
        'link' => ['.emproduct_title'],
        'price' => ['.price'],
        'pagination' => '/',
    ],
    'demandware' => [
        'element' => '.product-tile',
        'name' => ['.product-name'],
        'link' => [
            '.product-tile-link',
            '.name-link',
            '.thumb-link',
        ],
        'price' => [
            '.product-sales-price',
            '.product-standard-price',
            '.product-tile-price-default'
        ],
        'pagination' => '/',
    ],
    'ibm' => [
        'element' => '.product',
        'name' => ['.product_name'],
        'link' => ['.product_name > a'],
        'price' => ['.price'],
    ],
    'intershop' => [
        'element' => '.product-list__item',
        'name' => ['.product__headline'],
        'price' => ['.product__current-price'],
        'link' => ['a'],
    ],
    'intershop-1' => [
        'element' => '.product',
        'name' => ['.product-name'],
        'price' => ['.price > .member'],
        'link' => ['a'],
    ],
    'intershop-2' => [
        'element' => '.listed-prod',
        'name' => ['.product-name'],
        'price' => ['.price > .member'],
        'link' => ['a'],
    ],
    'shopware' => [
        'element' => '.product--box',
        'name' => ['.product--title'],
        'price' => [
            '.price--default',
            '.product-price',
        ],
        'link' => ['.product--title'],
        'pagination' => '?p='
    ],
    'oscommerce' => [
        'element' => 'li.item',
        'name' => [
            '.product-name',
            '.item-title',
        ],
        'price' => [
            '.price',
            '.regular-price',
            '.minimal-price-link > .label'
        ],
        'link' => [
            '.product-name > a',
            '.item-title > a',
            '.product',
        ],
        'pagination' => '?p=',
        'sp' => [
            'description' => [
                'selectors' => [
                    '.short-description',
                    '.product-detail__column__description',
                    '.std',
                ],
            ],
            /*'price' => [
                'selectors' => '.price',
            ],
            'name' => [
                'selectors' => '.product-name',
            ]*/
        ],
    ],
    'oscommerce-1' => [
        'element' => '.product',
        'name' => ['.product-name'],
        'price' => ['.product-price'],
        'link' => ['.product-name > a'],
    ],
    'oscommerce-2' => [
        'element' => '.product-container',
        'name' => ['.name'],
        'price' => [
            '.price',
            '.product-price',
        ],
        'link' => ['.name > a'],
    ],
    'oscommerce-3' => [
        'element' => '.os_content_corner',
        'name' => '.os_list_title',
        'price' => '.os_list_price2',
        'link' => '.os_list_link1',
        'sp' => [
            'description' => '.os_detail_descdiv',
        ],
        'pagination' => '&pn=',
        'multiplier' => 60,
    ],
    'virtuemart' => [
        'element' => '.product',
        'name' => ['.h-pr-title'],
        'price' => ['span.PricesalesPrice'],
        'link' => ['.h-pr-title > a'],
        'pagination' => 'limit=36?start=',
        'multiplier' => 36,
    ],
    'virtuemart-1' => [
        'element' => '.product',
        'name' => ['h2'],
        'price' => ['span.PricesalesPrice'],
        'link' => ['h2 > a'],
        'fake_pagination' => '/results,0-1000'
    ],
    'virtuemart-2' => [
        'element' => '.product',
        'name' => ['h3.catProductTitle'],
        'price' => ['span.PricesalesPrice'],
        'link' => ['h3.catProductTitle > a'],
        'fake_pagination' => '/results,0-1000'
    ],
    'virtuemart-3' => [
        'element' => '.product_row_multiple',
        'name' => '#product-title',
        'link' => '.product-link',
        'price' => '#product-price',
        'fake_pagination' => '&limit=500',
        'sp' => [
            'name' => '.title',
            'price' => '.price',
            'description' => '.description',
        ]
    ],
    'xt-commerce' => [
        'element' => '.products > div',
        'name' => [
            '.title > .h4',
            '.title',
        ],
        'price' => [
            '.price-new',
            '.product-price'
        ],
        'link' => ['.h4 > a'],
        'pagination' => '?next_page='
    ],
    'xt-commerce-1' => [
        'element' => '.mod-productlist > li',
        'name' => ['h3'],
        'price' => [
            '.new-price',
            '.mod-price',
        ],
        'link' => ['a'],
    ],
    'xt-commerce-2' => [
        'element' => '.product',
        'name' => ['.product-name'],
        'price' => [
            '.price-basic',
            '.product-price',
        ],
        'link' => ['.product-name > a'],
    ],
    'xt-commerce-3' => [
        'element' => '.plist-item',
        'name' => ['.plist-head'],
        'price' => ['.plist-price'],
        'link' => ['.plist-head > a'],
    ],
    'xt-commerce-4' => [
        'element' => '.products__single',
        'name' => ['.products__title'],
        'price' => ['.products__price'],
        'link' => ['.products__link'],
        'pagination' => '?next_page='
    ],
    'xt-commerce-5' => [
        'element' => '.catalog_item',
        'name' => ['h5'],
        'price' => ['.price'],
        'link' => ['img'],
    ],
    'shopping-cart-elite' => [
        'element' => '.rowProdBox',
        'name' => ['a.prodName'],
        'price' => ['.PriceListModeBig > .text-primary'],
        'link' => ['a.prodName'],
        'sp' => [
            'name' => '.MasterProductTitle > h1',
            'brand' => '.MasterProductTitle > h3',
            'price' => '.OneBigPrice',
            'description' => [
                '#pOverview',
                '.ProductSummaryBox',
            ],
        ]
    ],
    'shopping-cart-elite-1' => [
        'element' => '.prodBox',
        'name' => ['a.productlistver_txt'],
        'price' => ['.resultsPrice > .text-primary'],
        'link' => ['a.productlistver_txt'],
        'sp' => [
            'name' => '.MasterProductTitle > h1',
            'brand' => '.MasterProductTitle > h3',
            'price' => '.OneBigPrice',
            'description' => '.ProductSummaryBox',
        ]
    ],
    'amazon' => [
        'element' => '.s-item-container',
        'name' => [
            '.a-link-normal > h2',
            '.title',
        ],
        'price' => ['.sx-price'],
        'link' => ['.a-link-normal'],
        'pagination' => '&page='
    ],
    'ebay' => [
        'element' => '.sresult',
        'name' => ['.lvtitle'],
        'price' => ['.lvprice'],
        'link' => ['.lvtitle > a'],
        'pagination' => '&_pgn='
    ],
    'tents-1' => [
        'element' => '.productBox',
        'name' => ['.productItemNameText'],
        'price' => ['.productItemCurrentPriceText'],
        'link' => ['.productItemNameText'],
    ],
    'tents-2' => [
        'element' => '.product-item',
        'brand' => '.manufacturer-title',
        'name' => ['.product-title'],
        'price' => ['.price'],
        'link' => ['.product-link'],
    ],
    'tents-3' => [
        'element' => '.product-inner-wrap',
        'brand' => '.brand-name',
        'name' => ['.product-name'],
        'price' => ['.price'],
        'link' => ['a'],
    ],
    'otto' => [
        'element' => '.product',
        'name' => ['.name'],
        'price' => [
            '.reduced',
            '.retail',
        ],
        'link' => ['.productLink'],
    ],
    'tents-4' => [
        'element' => '.art_frame',
        'name' => ['.title'],
        'link' => ['.image'],
        'price' => [
            '.sale-price',
            '.nosale-price',
        ],
        'pagination' => '/seite='
    ],
    'tents-5' => [
        'element' => '.new-product-thumbnail',
        'name' => ['.product-label'],
        'brand' => '.product-brand',
        'price' => ['.price'],
        'link' => ['.thumbnail-link'],
    ],
    'clothes-1' => [
        'element' => '.catalogArticlesList_item',
        'name' => ['.catalogArticlesList_name'],
        'link' => ['.catalogArticlesList_imageBox'],
        'price' => [
            '.specialPrice',
            '.catalogArticlesList_price'
        ],
        'pagination' => '?p='
    ],
    'generic' => [
        'element' => 'li',
        'name' => [
            '.name',
            '.title',
            '.product',
        ],
        'link' => [
            'a',
        ],
        'price' => [
            '.price',
        ],
    ],
    'generic-1' => [
        'element' => 'article',
        'name' => [
            '.name',
            '.title',
            '.product',
            'h5',
        ],
        'link' => [
            'a',
        ],
        'price' => [
            '.price',
        ],
    ],
    'freizeitarena' => [
        'element' => '.cl4-em-wrap-inner',
        'name' => '.cl4-em-title',
        'price' => '.cl4-em-thumb-price',
        'link' => '.external-link int_page_link'
    ],
    'amgrill.de' => [
        'element' => '.ListItemProductContainer',
        'name' => 'span[itemprop=name]',
        'price' => 'span[itemprop=price]',
        'description' => 'div[itemprop=description]',
        'link' => 'a[itemprop=url]',
        'pagination' => '&Page=',
    ],
    'grills_furst' => [
        'element' => '.product-item',
        'name' => '.products-name',
        'link' => '.products-name',
        'price' => '.price',
        'pagination' => '?next_page=',
        'sp' => [
            'description' => 'div[itemprop=description]',
        ]
    ],
    'onrad' => [
        'element' => '.contentRow',
        'name' => '.product__title',
        'price' => '.product__currentPrice',
        'link' => '.product__title',
        'sp' => [
            'description' => '#description',
        ]
    ],
    'opencart-7' => [
        'element' => '.product-wrapper',
        'name' => 'h2',
        'link' => '.to-details',
        'price' => '.price',
        'pagination' => '?page=',
        'sp' => [
            'description' => 'article',
        ]
    ],
    'cyberport' => [
        'element' => '.productWrapper',
        'name' => '.productTitleName',
        'price' => '.price',
        'link' => 'a',
        'sp' => [
            'description' => '#productDetailDescription',
        ],
        'pagination' => '&page=',
    ],
    'megaspin' => [
        'element' => '.product_item',
        'name' => '.productname',
        'price' => '.main_price_usd',
        'link' => '.productname',
    ],
    'tt-store' => [
        'element' => '.product-list > div',
        'name' => '.name',
        'link' => '.name > a',
        'description' => '.description',
        'pagination' => '?page=',
        'price' => [
            '.price-new',
            '.price',
        ]
    ],
    'schoeler-micke' => [
        'element' => '.productPreview',
        'name' => 'h2',
        'price' => '.thePrice',
        'link' => '.productImgContainer',
        'sp' => [
            'description' => '#beschreibung',
        ],
        'pagination' => '',
    ],
    'dandoy-sports' => [
        'element' => '.item-product',
        'brand' => '.brand',
        'name' => '.product-name',
        'link' => '.product-name > a',
        'price' => '.price',
        'sp' => [
            'description' => '#short-description',
        ]
    ],
    'andro.de' => [
        'element' => '.product',
        'name' => 'a',
        'link' => 'a',
        'price' => '.price',
        'sp' => [
            'description' => '#description',
        ]
    ],
    'trauringwelt' => [
        'element' => '.ProductItem__Wrapper',
        'name' => '.ProductItem__Title',
        'price' => '.ProductItem__Price',
        'link' => '.ProductItem__ImageWrapper',
        'pagination' => '?page=',
        'sp' => [
            'description' => '.ProductMeta__Description',
        ]
    ],
    'juweliere-kraemer' => [
        'element' => '.c-product',
        'name' => '.c-product-name__title',
        'link' => '.c-product-name__anchor',
        'price' => [
            'span.c-product-pricing__price--special',
            'span.c-product-pricing__price',
        ],
        'pagination' => '?page_number=',
        'sp' => [
            'description' => '.c-product-description',
        ]
    ]
];