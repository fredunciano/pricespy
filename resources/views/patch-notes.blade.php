@extends('layouts.app')
@section('page-title')
    Patch Notes
@stop
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div>
                <h2>1.45.0</h2>
                <h4><i>06.03.2019</i></h4>
                <ol>
                    <li>Added search-base product binding</li>
                    <li>Added german translation to select2 binding script</li>
                </ol>
                <h2>1.44.2</h2>
                <h4><i>04.03.2019</i></h4>
                <ol>
                    <li>Fixed product link for own shop's products</li>
                    <li>Added 75 chars limit for long product names</li>
                    <li>Changed the title of the login page to PriceSpy</li>
                    <li>Added a limitation to the best prices chart not to show the values above 0% (higher than competitor price cannot be considered best)</li>
                </ol>
                <h2>1.44.1</h2>
                <h4><i>01.03.2019</i></h4>
                <ol>
                    <li>Several fixes for texts and forms update</li>
                </ol>
                <h2>1.44.0</h2>
                <h4><i>28.02.2019</i></h4>
                <ol>
                    <li>Modified tables to have bicoloured headings</li>
                    <li>Added possibility to choose the colour for the heading or just rotate it based on index</li>
                    <li>Changed bordered tables to custom ones</li>
                </ol>
                <h2>1.43.0</h2>
                <h4><i>26.02.2019</i></h4>
                <ol>
                    <li>Added laratables (ajax driven datatables) to products listings</li>
                </ol>
                <h2>1.42.2</h2>
                <h4><i>26.02.2019</i></h4>
                <ol>
                    <li>Changed default avatar icon for users</li>
                </ol>
                <h2>1.42.1</h2>
                <h4><i>24.02.2019</i></h4>
                <ol>
                    <li>Fixed price sorting on the product comparison page</li>
                    <li>Removed sorting from the categories actions</li>
                </ol>
                <h2>1.42.0</h2>
                <h4><i>24.02.2019</i></h4>
                <ol>
                    <li>Added "secondary" button colour preset for back and link buttons</li>
                    <li>Refactored alerts into a js-driven top right messages that disappear on click or over time</li>
                    <li>Refactored, optimised and simplified page headings. Now any heading will allow an action button to the right, with minimal effort to add one</li>
                    <li>Refactored page title alignments for most of the pages</li>
                    <li>Optimised scripts, moved several of the scripts to compilable resources</li>
                    <li>Added extendable alert functionality to the scripts</li>
                    <li>Grouped up the module styles into a separated file, deferred custom styles to a custom file (fixes styles overlapping)</li>
                    <li>Refactored datatables script, added possibility to extend datatables functionality per page (f.e. remove sorting from columns)</li>
                    <li>Removed sorting for links, actions on multiple tables</li>
                    <li>Fixed sorting by price for products listings</li>
                    <li>Changed success message for competitor request page</li>
                    <li>Split views and methods for client's products and the competitors' ones</li>
                    <li>Changed create button colour on several pages</li>
                    <li>Fixed page title texts on several pages</li>
                    <li>Differentiated page and button texts for client's and competitors' products</li>
                    <li>Fixed several translation strings</li>
                    <li>Added custom scrollbar functionality to lower dashboard widgets</li>
                    <li>Changed notification titles on the dashboard</li>
                    <li>Modified "premium" button on the dashboard</li>
                    <li>Added progress bars functionality and a corresponding block to the dashboard page</li>
                    <li>Fixed page resizing issues on the lower dashboard widgets</li>
                    <li>Added datatables for categories, added missing translations, added description to the listing</li>
                    <li>Fixed menu highlight for price comparison</li>
                    <li>Added minification and versioning for assets</li>
                </ol>
                <h2>1.41.2</h2>
                <h4><i>22.02.2019</i></h4>
                <ol>
                    <li>Usability 0.1</li>
                    <li>Changed colour on the top widget blocks of the dashboard</li>
                    <li>Fixed type on the "Competitor Add" button</li>
                    <li>Limited in size profile image on the dashboard</li>
                </ol>
                <h2>1.41.1</h2>
                <h4><i>22.02.2019</i></h4>
                <ol>
                    <li>More visual fixes and fixes with translations</li>
                </ol>
                <h2>1.41.0</h2>
                <h4><i>22.02.2019</i></h4>
                <ol>
                    <li>Visual fixes for the dashboard</li>
                    <li>Added simple pagination for products when they exceed 1000</li>
                </ol>
                <h2>1.40.4</h2>
                <h4><i>21.02.2019</i></h4>
                <ol>
                    <li>Fixed binding issues</li>
                    <li>Fixed home page issues if there are no products bound</li>
                </ol>
                <h2>1.40.3</h2>
                <h4><i>20.02.2019</i></h4>
                <ol>
                    <li>Changed the home page "Show more" buttons colours to be monolite</li>
                    <li>Added hover effect on "Show more" buttons</li>
                    <li>Changed the size of the pie chart block and the position of the chart (currently works correctly only FHD or mobile)</li>
                    <li>Fixed headings on several pages</li>
                </ol>
                <h2>1.40.2</h2>
                <h4><i>15.02.2019</i></h4>
                <ol>
                    <li>More design for main page</li>
                </ol>
                <h2>1.40.1</h2>
                <h4><i>12.02.2019</i></h4>
                <ol>
                    <li>Restructured the best prices charts to handle long names</li>
                    <li>Fixed the broken responsiveness on dropdown selectors</li>
                </ol>
                <h2>1.40.0</h2>
                <h4><i>12.02.2019</i></h4>
                <ol>
                    <li>Redesign (Phase 2)</li>
                </ol>
                <h2>1.39.0</h2>
                <h4><i>11.02.2019</i></h4>
                <ol>
                    <li>Refactored the product show page</li>
                    <li>Moved Product History chart to the product show page</li>
                    <li>Moved Watching related actions to the product show page</li>
                    <li>Lightly restructured product related controllers</li>
                    <li>Moved away history generation functionality out of controllers</li>
                </ol>
                <h2>1.38.1</h2>
                <h4><i>10.02.2019</i></h4>
                <ol>
                    <li>Fixed a bug with missing category names on the listings</li>
                    <li>Added category info page link to the categories reflected on the listings</li>
                </ol>
                <h2>1.38.0</h2>
                <h4><i>10.02.2019</i></h4>
                <ol>
                    <li>Added category management functionality for user</li>
                    <li>Added category listing</li>
                    <li>Added the quantity of relations to the categories</li>
                    <li>Fixed the cascading issue of the Competitors Best Prices chart</li>
                </ol>
                <h2>1.37.0</h2>
                <h4><i>03.02.2019</i></h4>
                <ol>
                    <li>Added top 5 products charts functionality (dynamic)</li>
                    <li>Added functionality to handle the 0-priced entries (When products appear on the lists, they might have no price defined or due to a crawling issue)</li>
                </ol>
                <h2>1.36.0</h2>
                <h4><i>01.02.2019</i></h4>
                <ol>
                    <li>Added the dashboard page skeleton and positioned the future reports</li>
                    <li>Refactored the page title to be outside of the "widget windows"</li>
                    <li>Refactored table borders</li>
                    <li>Changed link colours</li>
                    <li>Changed the "primary" colour which should be used for most buttons leading to new pages</li>
                </ol>
                <h2>1.35.2</h2>
                <h4><i>30.01.2019</i></h4>
                <ol>
                    <li>Fixed the pages links and the "Request Competitor" link</li>
                    <li>Cleaned up the competitor requests</li>
                    <li>Fixed the "Image" button on the product show page</li>
                </ol>
                <h2>1.35.1</h2>
                <h4><i>30.01.2019</i></h4>
                <ol>
                    <li>Moved migrations, seeders, factories to the admin part of the project</li>
                    <li>Added "origin" to the product, to reflect where the last data set comes from</li>
                </ol>
                <h2>1.35.0</h2>
                <h4><i>27.01.2019</i></h4>
                <ol>
                    <li>Extended the database structure for single page parsing</li>
                </ol>
                <h2>1.34.0</h2>
                <h4><i>25.01.2019</i></h4>
                <ol>
                    <li>Massive redesign (phase 1)</li>
                    <li>Changed the styles from the generic css to colour-configurable sass styles</li>
                    <li>Fixed the bug where the "request a competitor" page was throwing an error</li>
                </ol>
                <h2>1.33.0</h2>
                <h4><i>23.01.2019</i></h4>
                <ol>
                    <li>Refactored pages crud</li>
                    <li>Added possibility to add single product pages (this far without any effect on the crawler until the corresponding functionality is implemented)</li>
                </ol>
                <h2>1.32.0</h2>
                <h4><i>19.01.2019</i></h4>
                <ol>
                    <li>Added price overriding control functionality</li>
                    <li>Added a possibility to edit any product</li>
                </ol>
                <h2>1.31.0</h2>
                <h4><i>19.01.2019</i></h4>
                <ol>
                    <li>Removed unnecessary commands</li>
                    <li>Price in the listings will now reflect the chosen by user VAT state with a corresponding tip</li>
                    <li>Removed an obsolete vat field from the products table</li>
                </ol>
                <h2>1.30.0</h2>
                <h4><i>19.01.2019</i></h4>
                <ol>
                    <li>Added description to the categories</li>
                    <li>Added tip reflection for the categories wherever they are mentioned</li>
                </ol>
                <h2>1.29.0</h2>
                <h4><i>17.01.2019</i></h4>
                <ol>
                    <li>Added both net / gross prices to product creation / edit</li>
                    <li>In the product creation / edit forms, net and gross prices autocomplete each other based on currently selected shop's VAT rate</li>
                </ol>
                <h2>1.28.1</h2>
                <h4><i>17.01.2019</i></h4>
                <ol>
                    <li>Tiny wording fix for after tax prices</li>
                </ol>
                <h2>1.28.0</h2>
                <h4><i>17.01.2019</i></h4>
                <ol>
                    <li>Refactored the prices before and after VAT</li>
                    <li>Refactored the storage logic for user preference for before and after tax</li>
                    <li>Added the possibility in the Settings menu to toggle the prices preference</li>
                </ol>
                <h2>1.27.0</h2>
                <h4><i>15.01.2019</i></h4>
                <ol>
                    <li>Changed layout structure (removed php dependencies and prepared for a new layout)</li>
                    <li>Added possibility to add products to competitors</li>
                    <li>Added possibility to edit manually created competitors products</li>
                </ol>
                <h2>1.26.0</h2>
                <h4><i>15.01.2019</i></h4>
                <ol>
                    <li>Added per-category statistics</li>
                    <li>Adjusted menu highlighting</li>
                    <li>Refactored and restructured statistics</li>
                </ol>
                <h2>1.25.0</h2>
                <h4><i>05.01.2019</i></h4>
                <ol>
                    <li>Added prices modifiers to the products and sources in the database</li>
                </ol>
                <h2>1.24.1</h2>
                <h4><i>21.12.2018</i></h4>
                <ol>
                    <li>Fixed the page title for the competitor request page</li>
                </ol>
                <h2>1.24.0</h2>
                <h4><i>21.12.2018</i></h4>
                <ol>
                    <li>Added shop request functionality</li>
                </ol>
                <h2>1.23.0</h2>
                <h4><i>17.12.2018</i></h4>
                <ol>
                    <li>Added "show" page to own products</li>
                    <li>Added image upload to own products</li>
                    <li>Added lightbox image preview on own products page</li>
                </ol>
                <h2>1.22.0</h2>
                <h4><i>17.12.2018</i></h4>
                <ol>
                    <li>Added currencies tables and their initial seeding</li>
                </ol>
                <h2>1.21.0</h2>
                <h4><i>16.12.2018</i></h4>
                <ol>
                    <li>Added VAT tables and their initial seeding</li>
                </ol>
                <h2>1.20.0</h2>
                <h4><i>16.12.2018</i></h4>
                <ol>
                    <li>Added profile editing and avatar management functionality</li>
                </ol>
                <h2>1.19.0</h2>
                <h4><i>03.12.2018</i></h4>
                <ol>
                    <li>Adapted data structure to the new stockpiling functionality</li>
                </ol>
                <h2>1.18.1</h2>
                <h4><i>30.11.2018</i></h4>
                <ol>
                    <li>Fixed and refactored categories statistics</li>
                </ol>
                <h2>1.18.0</h2>
                <h4><i>26.11.2018</i></h4>
                <ol>
                    <li>Added seeding for bindings (populates all matches)</li>
                    <li>Added seeding for prices stockpiling (only seeding this far)</li>
                    <li>Added trigger to enable price watching (might need addition of a confirmation/explanation modal)</li>
                    <li>Added price history chart (primary version)</li>
                    <li>Reduced price variation for seeded products</li>
                </ol>
                <h2>1.17.0</h2>
                <h4><i>20.11.2018</i></h4>
                <ol>
                    <li>Majorly refactored categories</li>
                    <li>Refactored seeders to fit new categories changes</li>
                    <li>Fixed several seeder issues</li>
                </ol>
                <h2>1.16.1</h2>
                <h4><i>19.11.2018</i></h4>
                <ol>
                    <li>Recovered missing translation</li>
                </ol>
                <h2>1.16.0</h2>
                <h4><i>19.11.2018</i></h4>
                <ol>
                    <li>Added Settings Page to the upper right menu</li>
                    <li>Added functional possibility to establish the equality percent (needed for charts comparison)</li>
                </ol>
                <h2>1.15.0</h2>
                <h4><i>19.11.2018</i></h4>
                <ol>
                    <li>Added Categorisation and competitor choice to the general performance chart</li>
                    <li>Fixed several naming conventions</li>
                </ol>
                <h2>1.14.0</h2>
                <h4><i>12.11.2018</i></h4>
                <ol>
                    <li>Added additional categories to the seeders</li>
                    <li>Slightly optimised the options seeding</li>
                    <li>Fixed the urls for sources</li>
                    <li>Added pages seeding</li>
                    <li>Added per-category shop statistics</li>
                    <li>Slightly optimised routing translations and several routing name conventions</li>
                </ol>
                <h2>1.13.0</h2>
                <h4><i>07.11.2018</i></h4>
                <ol>
                    <li>Added tabindex = -1 to "View Products" on the binding page, so when you press "Tab" - you get to the next shop</li>
                    <li>Added products difference statistics per shop</li>
                </ol>
                <h2>1.12.0</h2>
                <h4><i>26.10.2018</i></h4>
                <ol>
                    <li>Refactored Menu structure and optimised it</li>
                    <li>Fixed alignment for the remaining listings</li>
                </ol>
                <h2>1.11.0</h2>
                <h4><i>24.10.2018</i></h4>
                <ol>
                    <li>Binding initial refactor (not final, just first phase)</li>
                </ol>
                <h2>1.10.1</h2>
                <h4><i>19.10.2018</i></h4>
                <ol>
                    <li>Fixed alignment on multiple pages</li>
                    <li>Added pricing gradient to the comparison page</li>
                    <li>Added percentages to the stats dashboard</li>
                </ol>
                <h2>1.10.0</h2>
                <h4><i>17.10.2018</i></h4>
                <ol>
                    <li>Fixed the "competitors" menu highlighting</li>
                    <li>After saving the binding added the autoselect of the saved main product entry</li>
                    <li>Reverted back one to many binding</li>
                    <li>Significantly refactored the statistics page</li>
                    <li>Added a relative colour difference gradient to the statistics page</li>
                    <li>Renamed "Main Product Price" in to "My Product Price" on the comparison page</li>
                    <li>Fixed several alignments on the comparison page</li>
                    <li>Removed the client's shops from the concurrent page</li>
                    <li>Fixed the bug where submitting and empty binding was crashing</li>
                </ol>
                <h2>1.9.0</h2>
                <h4><i>15.10.2018</i></h4>
                <ol>
                    <li>Added first dynamic statistics doughnut chart, reflecting the general state of the production compared to competitors</li>
                </ol>
                <h2>1.8.0</h2>
                <h4><i>14.10.2018</i></h4>
                <ol>
                    <li>Added "My Shop" menu</li>
                    <li>All options menus were hidden</li>
                    <li>Split the products listings between the ones belonging to the client (My Shop) and to the concurrent (Concurrent menu)</li>
                    <li>Added shop selector to the products listings</li>
                    <li>Basic Rebranding (PriceSpy name)</li>
                    <li>Changed the default table amounts to 10, 25, 50, 100</li>
                    <li>Added shop choice to product creation (adaptation to multiple main shops)</li>
                </ol>
                <h2>1.7.1</h2>
                <h4><i>11.10.2018</i></h4>
                <ol>
                    <li>Added alphabetic order for products and options on the binding pages, at least until the selectors get categorised</li>
                </ol>
                <h2>1.7.0</h2>
                <h4><i>11.10.2018</i></h4>
                <ol>
                    <li>Re-optimised the whole Demo system, now all data will be re-generated from seeds for the statistics purposes</li>
                    <li>Added a lot of dummy data for production</li>
                    <li>Changed label on the comparison page from "price" to "concurrent price"</li>
                    <li>Changed default values for products, options, presets for better safety and logical clarity</li>
                    <li>Binding options are also set 1 to 1 of a competitor shop</li>
                    <li>Changed ranged price representation on products comparison page</li>
                </ol>
                <h2>1.6.1</h2>
                <h4><i>11.10.2018</i></h4>
                <ol>
                    <li>Fixed translation text for product update</li>
                    <li>Added translation text for product creation</li>
                </ol>
                <h2>1.6.0</h2>
                <h4><i>11.10.2018</i></h4>
                <ol>
                    <li>Added basic (most viable) product creation functionality</li>
                    <li>Added product edit functionality. Only manually created can be edited</li>
                    <li>Small translation bugfixes</li>
                </ol>
                <h2>1.5.0</h2>
                <h4><i>10.10.2018</i></h4>
                <ol>
                    <li>Increased the size of page headers. Headers structure simplified and refactored</li>
                    <li>Refactored and simplified translations usage, added missing translations</li>
                    <li>Refactored menu structure (phase 1)</li>
                    <li>Added menu main tabs highlighting</li>
                    <li>Binding switched to a single product binding</li>
                    <li>Renamed "Overview" page into "Products" for better clarity</li>
                    <li>Renamed +/- into "Price Difference"</li>
                </ol>
            </div>
        </div>
        <div class="col-md-3">
            <h1 class="block-header">Notes</h1>
            <div>-</div>
        </div>
    </div>
@stop