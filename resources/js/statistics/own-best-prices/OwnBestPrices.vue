<template>

    <div>

        <div class="table-responsive">

            <div class="col-md-12 no-padding">
                <div class="col-md-8 col-xs-12 no-padding">
                    <select id="per-page-dropdown" v-model="filter.per_page" class="form-control inline-dropdown"
                            @change="filterResult">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="*">All</option>
                    </select>
                    &nbsp;
                    <select id="category-dropdown" v-model="filter.category_id" class="form-control inline-dropdown"
                            @change="filterResult">
                        <option value="">{{ $utils.t__('general', 'all') }} {{ $utils.t__('general', 'categories') }}
                        </option>
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                    &nbsp;
                </div>

                <div class="col-md-4 col-xs-12 no-padding" style="float: right">

                    <div class="input-group">
                        <input type="text" class="form-control" v-model="filter.search" @input="filterResult"
                               :placeholder="$utils.t__('general','search') + '...'">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>


                </div>
            </div>
            <loader v-if="isLoading"></loader>
            <table class="table table-custom">
                <thead>
                <tr>
                    <th class="header-red" @click="sortBy('product_name')">
                        <b v-html="$utils.tbl__('product', true)"></b>
                        <i v-if="filter.columnName == 'product_name' && filter.order == 'ASC'"
                           class="fa fa-sort-up"></i>
                        <i v-else-if="filter.columnName == 'product_name' && filter.order == 'DESC'"
                           class="fa fa-sort-down"></i>
                        <i v-else class="fa fa-sort"></i>
                    </th>
                    <th class="header-purple">
                        <b v-html="$utils.tbl__('own_price', true)"></b>
                    </th>
                    <th class="header-orange">
                        <b v-html="$utils.tbl__('name_competitor', true)"></b>
                    </th>
                    <th class="header-red">
                        <b v-html="$utils.tbl__('product_competitor', true)"></b>
                    </th>
                    <th class="header-green">
                        <b v-html="$utils.tbl__('price_competitor', true)"></b>
                    </th>
                    <th class="header-blue" @click="sortBy('percentage')">
                        <b v-html="$utils.tbl__('percentage', true)"></b>
                        <i v-if="filter.columnName == 'percentage' && filter.order == 'ASC'"
                           class="fa fa-sort-up"></i>
                        <i v-else-if="filter.columnName == 'percentage' && filter.order == 'DESC'"
                           class="fa fa-sort-down"></i>
                        <i v-else class="fa fa-sort"></i>
                    </th>
                    <th class="header-red" @click="sortBy('category')">
                        <b v-html="$utils.tbl__('category', true)"></b>
                        <i v-if="filter.columnName == 'category' && filter.order == 'ASC'"
                           class="fa fa-sort-up"></i>
                        <i v-else-if="filter.columnName == 'category' && filter.order == 'DESC'"
                           class="fa fa-sort-down"></i>
                        <i v-else class="fa fa-sort"></i>
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-if="results.length > 0" v-for="result in results">
                    <td :data-label="$utils.t__('general', 'product')" class="vertical-center-important">
                        <div class="text-orange capital">
                            <a :title="result.name" :href=" baseurl +'/' + $utils.t__('routes', 'products') + '/' + result.id ">
                                <strong class="underline-on-hover">{{ getProductName(result.name) }} </strong>
                            </a>
                        </div>
                    </td>
                    <td :data-label="$utils.t__('general', 'own_price')" class="vertical-center-important">
                        {{ result.price_range }}
                    </td>
                    <td :data-label="$utils.t__('general', 'name_competitor')" class=" vertical-center-important">
                        <div class="comp-list" v-for="n in result.bindings">
                            <a :href="baseurl + '/' + 'products?s=' + n.product.source.name.replace(' ', '||') ">
                                {{ n.product.source.name }}</a>
                        </div>

                    </td>
                    <td :data-label="$utils.t__('general', 'product_competitor')" >
                        <div class="comp-list" v-for="n in result.bindings">
                            <a :title="n.product.name" :href="baseurl + '/' + 'products' + '/' + n.product.id ">
                                {{ getProductName(n.product.name) }}
                            </a>
                        </div>

                    </td>
                    <td :data-label="$utils.t__('general', 'price_competitor')" >
                        <div class="comp-list" v-for="n in result.bindings">
                            {{ n.product.price_range }}
                        </div>

                    </td>
                    <td :data-label="$utils.t__('general', 'percentage')" class=" vertical-center-important">
                        <div class="c-tooltip" data-direction="bottom">
                            <div class="c-tooltip__initiator"
                                 @click="copyData(result)">
                                <span :class="{'label': true,'increase': result.difference > 0, 'decrease': result.difference < 0}">
                                  {{ $utils.showVisualDifference(result.difference, true) }}
                                </span>
                            </div>
                            <div class="c-tooltip__item" v-html="$utils.getTooltipData(result)"></div>
                        </div>
                    </td>
                    <td :data-label="$utils.t__('general', 'category')" class=" vertical-center-important">
                        <span>{{ result.category.name }}</span>
                    </td>
                </tr>
                <tr v-if="results.length === 0 && firstLoad">
                    <td colspan="7" class="empty_row">
                        {{ $utils.t__('general', 'no_data_available') }}
                    </td>
                </tr>

                </tbody>
            </table>

            <pagination :pagination="pagination" :info="info"
                        :midSize="parseInt(filter.per_page/2)"
                        @paginate="fetchResults" :first_load="firstLoad"></pagination>

        </div>
    </div>
</template>

<script>
    import Pagination from '../../components/pagination'
    import Loader from '../../components/loader'

    export default {
        name: "OwnBestPrices",
        components: {
            Pagination, Loader
        },
        props: {
            categories: {
                required: true
            }
        },
        data: function () {
            return {
                baseurl: baseurl,
                isLoading: false,
                fullPage: true,
                results: [],
                pagination: {},
                info: {},
                firstLoad: false,

                filter: {
                    search: '',
                    per_page: 10,
                    category_id: '',
                    columnName: 'percentage',
                    order: 'ASC'
                },

            }
        },

        mounted: function () {
            this.fetchResults();
        },

        methods: {
            fetchResults: function (page_url, queryString) {
                var statistics = this.$utils.t__('routes', 'statistics');
                var app = this;
                this.isLoading = true;
                this.loader = true;
                if (queryString) {
                    page_url = baseurl + '/' + statistics + '/own-best-prices-data/' + queryString;
                } else {
                    page_url = page_url || baseurl + '/' + statistics + '/own-best-prices-data';
                }

                axios.get(page_url)
                    .then(function (response) {
                        if (app.filter.per_page !== '*') {
                            app.results = response.data.data;
                            app.makePagination(response.data);
                        } else {
                            app.results = response.data
                        }

                        app.firstLoad = true;
                        app.isLoading = false;

                        setTimeout(function () {
                            columns = $('.table tr').length;
                            rows = $('.table th').length;
                            shapeTable(rows, columns);
                        }, 200)
                    })
                    .catch(function (error) {
                        console.log(error)
                        app.isLoading = false
                    }.bind(this));

            },

            makePagination: function (data) {

                this.pagination = {
                    path: data.path,
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url

                };
                this.info = {
                    total: data.total,
                    to: data.to,
                    from: data.from
                }
            },

            filterResult: function () {

                var queryString = '?per_page=' + this.filter.per_page +
                    '&category_id=' + this.filter.category_id +
                    '&search=' + this.filter.search +
                    '&columnName=' + this.filter.columnName + '&order=' + this.filter.order;

                this.fetchResults(null, queryString);
            },

            sortBy(param) {
                var columnName = this.filter.columnName;

                if (columnName == param) {
                    var order = this.filter.order;
                    if (order == 'ASC') {
                        this.filter.order = 'DESC';
                    } else {
                        this.filter.order = 'ASC';
                    }
                } else {
                    this.filter.order = 'ASC';
                }
                this.filter.columnName = param;

                this.filterResult();
            },


            copyData(result) {
                if ($(window).width() < 767){
                    $('.c-tooltip__item').hide()
                    return;
                }
                var data = this.$utils.getTooltipData(result);

                var inp = document.createElement('input');
                document.body.appendChild(inp)
                inp.value = data
                inp.select();
                document.execCommand('copy', false);
                inp.remove();

                alert('Copied to clipboard')
            },

            getProductName(productName) {
                let windowWidth = $(window).width();
                if (windowWidth > 1366) {
                    return productName.length > 40 ? productName.substr(0, 38) + '...' : productName;
                } else {
                    return productName.length > 20 ? productName.substr(0, 18) + '...' : productName;
                }
            }
        }
    }
</script>

<style scoped>
    .table-responsive .loader {
        position: absolute;
        left: 40%;
        top: 40%;
    }

    .mobile-responsive-v1 > tbody > tr > td:before {
        text-align: left !important;
    }

    .mobile-responsive-v1 > tbody > tr > td {
        text-align: right !important;
    }
</style>
