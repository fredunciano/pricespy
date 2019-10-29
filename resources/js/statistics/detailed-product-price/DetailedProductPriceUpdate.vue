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

                    <select id="product-dropdown" v-model="filter.product_id" class="form-control inline-dropdown"
                            @change="filterResult">
                        <option value="">{{ $utils.t__('general', 'all') }} {{ $utils.t__('general', 'products') }}
                        </option>
                        <option v-for="product in filteredProducts" :value="product.id">{{ product.name }}</option>
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
            <br>
            <br>
            <br>
            <Loader v-if="isLoading"></Loader>
            <table class="table table-custom">
                <thead>
                <tr>
                    <th class="header-red" width="30%">
                        <b v-html="$utils.tbl__('product_name', true)"></b>
                    </th>
                    <th class="header-purple" width="15%">
                        <b v-html="$utils.tbl__('stores', true)"></b>
                    </th>
                    <th class="header-orange " width="15%">
                        <b v-html="$utils.tbl__('old_price', true)"></b>
                    </th>
                    <th class="header-red " width="10%">
                        <b v-html="$utils.tbl__('last_price_change', true)"></b>
                    </th>
                    <th class="header-green " width="10%">
                        <b v-html="$utils.tbl__('current_price', true)"></b>
                    </th>
                    <th class="header-blue " width="10%">
                        <b v-html="$utils.tbl__('percentage_change', true)"></b>
                    </th>
                    <!--<th width="3%">-->

                    <!--</th>-->
                </tr>
                </thead>
                <tbody>

                <template v-for="result in results">
                    <tr>
                        <td :data-label="$utils.t__('general', 'product_name')">
                            <div class="capital">
                                <a :href="baseurl + '/' +$utils.t__('routes', 'products') + '/' + result.id">
                                    <strong class="underline-on-hover text-orange">{{ getProductName(result.name)
                                        }}</strong>
                                </a>

                                <a href="javascript:void(null)" @click="toggleDisplayCompetitorProduct(result.id)"
                                   style="padding-left: 1em;">
                                    <i :class="{'text-orange': true, 'fa': true,
                                    'fa-angle-right': true,
                                    'fa-angle-down': display === true && activeRow === result.id}"
                                       style="font-size: 20px"></i>
                                </a>
                            </div>


                        </td>
                        <td :data-label="$utils.t__('general', 'competitor')">
                            <a :href="baseurl + '/' + $utils.t__('routes', 'my-shop')">
                                {{ $utils.t__('general','my_shop') }}
                            </a>
                        </td>

                        <td :data-label="$utils.t__('general', 'old_price')">
                            {{ $utils.formatMoney(result.amount) }}
                        </td>
                        <td :data-label="$utils.t__('general', 'last_price_change')">
                            {{ formattedDate(result.fetched_at) }}
                        </td>
                        <td :data-label="$utils.t__('general', 'current_price')">
                            -
                        </td>
                        <td :data-label="$utils.t__('general', 'percentage_change')">
                            -
                        </td>
                        <!--<td :data-label="$utils.t__('general', 'actions')">-->
                            <!--<a :href="baseurl + '/' + $utils.t__('routes', 'products') + '/' + result.id">-->
                                <!--<i class="fa fa-eye"></i>-->
                            <!--</a>-->
                        <!--</td>-->
                    </tr>

                    <tr v-if="result.bindings.length === 0 && activeRow === result.id && display === true">
                        <td colspan="6">
                            <a class="text-uppercase" :href="baseurl + '/binding?product-id=' + result.id">
                                {{ $utils.t__('general', 'bind_message')}} <i class="fa fa-plus-circle"></i>
                            </a>
                        </td>
                    </tr>

                    <tr v-for="(r, i) in result.bindings"
                        v-if="result.bindings.length > 0 && activeRow === result.id && display === true && (i) < max ">
                        <td :data-label="$utils.t__('general', 'competitor')">
                            <div class="text-orange capital tab-space">
                                <a :href="baseurl + '/' +$utils.t__('routes', 'products') + '/' + r.product.id">
                                    <strong class="underline-on-hover">{{ getProductName(r.product.name) }}</strong>
                                </a>

                            </div>
                        </td>
                        <td :data-label="$utils.t__('general', 'competitor')">
                            <a :href="baseurl + '/' +$utils.t__('routes', 'products') + '?compName=' + r.product.source.name.split(' ').join('||')">
                                {{ r.product.source.name }}
                            </a>
                        </td>

                        <td :data-label="$utils.t__('general', 'old_price')">
                            {{ r.bound_product_old_price ? $utils.formatMoney(r.bound_product_old_price) : '-' }}
                        </td>
                        <td :data-label="$utils.t__('general', 'last_price_change')">
                            {{ r.bound_product_old_price ? r.old_price_date : '-' }}
                        </td>
                        <td :data-label="$utils.t__('general', 'current_price')">
                            {{ r.bound_product_current_price ? $utils.formatMoney(r.bound_product_current_price) : '-'}}
                        </td>
                        <td :data-label="$utils.t__('general', 'percentage_change')">
                            <a :href="baseurl + '/' + $utils.t__('routes', 'products') + '/' + result.id   + r.product.source.name.split(' ').join('||')"
                               :class="getClassName(r.bound_product_price_change_percentage)">
                                {{ r.bound_product_price_change_percentage ?
                                $utils.showVisualDifference(r.bound_product_price_change_percentage, true) :
                                '-'}}
                            </a>
                        </td>
                        <!--<td :data-label="$utils.t__('general', 'actions')">-->
                            <!--<a :href="baseurl + '/' + $utils.t__('routes', 'products') + '/' + result.id  +'?name='  + r.product.source.name.split(' ').join('||')">-->
                                <!--<i class="fa fa-eye"></i>-->
                            <!--</a>-->
                        <!--</td>-->
                    </tr>
                    <tr v-if="activeRow === result.id && display === true && max < result.bindings.length">
                        <td colspan="6">
                            <a class="text-uppercase" href="javascript:void(null)" @click="max += 10"
                               style="font-size: 10px; padding-left: 2.7em">
                                {{ $utils.t__('general', 'show_more')}} (10)
                            </a>
                        </td>
                    </tr>
                </template>

                </tbody>

            </table>

            <pagination :pagination="pagination" :info="info" :midSize="parseInt(filter.per_page/2)"
                        @paginate="fetchResults" :first_load="firstLoad"></pagination>


        </div>
        <div v-if="results.length === 0 && firstLoad" style="background: #ff6b6a; color: white; padding: 20px">
            {{ $utils.t__('general', 'no_data_available') }}
        </div>
    </div>
</template>

<script>
    import Pagination from '../../components/pagination'
    import Loader from '../../components/loader'

    export default {
        name: "DetailedProductPrice",
        props: [
            'categories',
            'products'
        ],
        components: {
            Pagination, Loader
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
                activeRow: null,
                display: false,
                max: 3,

                filter: {
                    search: '',
                    per_page: 10,
                    category_id: '',
                    product_id: '',
                    columnName: 'percentage',
                    order: 'ASC'
                },

            }
        },
        mounted: function () {
            this.fetchResults();

        },

        computed: {
            filteredProducts() {
                return this.products.filter(product => {
                    if (parseInt(product.category_id) === parseInt(this.filter.category_id)) {
                        return product;
                    }
                    return false;
                });
            }
        },

        methods: {
            fetchResults: function (page_url, queryString) {
                var statistics = this.$utils.t__('routes', 'statistics');
                var app = this;
                this.isLoading = true;
                if (queryString) {
                    page_url = baseurl + '/' + statistics + '/detailed-product-price-report-data/' + queryString;
                } else {
                    page_url = page_url || baseurl + '/' + statistics + '/detailed-product-price-report-data';
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
                            alterClass();
                            var rows = $('.table th').length;
                            var columns = $('.table tr').length;
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
                    '&product_id=' + this.filter.product_id +
                    '&search=' + this.filter.search;

                this.fetchResults(null, queryString);
            },

            getProductName(productName) {
                let windowWidth = $(window).width();
                if (windowWidth > 1366) {
                    return productName.length > 45 ? productName.substr(0, 42) + '...' : productName
                } else {
                    return productName.length > 20 ? productName.substr(0, 18) + '...' : productName;
                }
            },

            getClassName(value) {
                if (value !== null && value > 0) {
                    return 'label increase';
                } else if (value !== null && value < 0) {
                    return 'label decrease';
                } else {
                    return null;
                }
            },

            formattedDate(date) {
                let dateArr = date.split(' ')[0].split('-');
                return dateArr[2] + '.' + dateArr[1] + '.' + dateArr[0];
            },

            toggleDisplayCompetitorProduct(id) {
                if (this.activeRow === id) {
                    this.display = !this.display;
                } else {
                    this.display = true;
                }
                this.activeRow = id;
            }
        }
    }
</script>

<style scoped>
    a:hover strong.underline-on-hover {
        -webkit-text-fill-color: #ff4d6a;
        text-decoration: underline;
        cursor: pointer;
        font-weight: 600;
    }

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
