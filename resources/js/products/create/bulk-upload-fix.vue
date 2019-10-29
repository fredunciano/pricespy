<template>
    <div>
        <div class="col-md-12">
            <div class="table-responsive block">

                <div class="col-md-12 no-padding">
                    <div class="col-md-8 col-xs-12 no-padding">
                        <div style="color: #E3E3E3; font-size: 15px">
                            <div class="custom-icon-exp"></div>
                            <div class="icon-with-text">
                                {{ $utils.t__('general', 'import_complete_msg') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-12 no-padding" style="float: right">
                        <div class="input-group">
                            <input :placeholder="$utils.t__('general','search') + '...'" class="form-control"
                                   type="text">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="save()" method="post">
                    <table class="table table-custom">
                        <thead>
                        <tr>
                            <th class="header-orange" width="28%"><b v-html="$utils.tbl__('import_product', true)"></b>
                            </th>
                            <th class="header-purple" width="15%"><b
                                    v-html="$utils.tbl__('product_category', true)"></b></th>
                            <th class="header-red" width="15%"><b v-html="$utils.tbl__('stores', true)"></b></th>
                            <th class="header-red" width="10%"><b v-html="$utils.tbl__('net_price', true)"></b></th>
                            <th class="header-green" width="10%"><b v-html="$utils.tbl__('gross_price', true)"></b></th>
                            <!--<th class="header-blue"><b v-html="$utils.tbl__('other_prices', true)"></b></th>-->
                            <th class="header-blue" width="5%"><b v-html="$utils.tbl__('link', true)"></b></th>
                            <th class="header-red" width="10%"><b
                                    v-html="$utils.tbl__('auto_price_overwrite', true)"></b>
                            </th>
                            <th class="header-lavender_purple" width="3%"><b v-html="$utils.tbl__('errors', true)"></b>
                            </th>
                            <th class="header-orange" width="3%"><b v-html="$utils.tbl__('actions', true)"></b></th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr :key="index" v-for="(item, index) in products" v-if="products.length > 0">
                            <td>
                                {{ products[index].name }}
                            </td>

                            <td>
                                <input @change="putCategoryIdOnProduct(index)" class="form-control" list="catsName"
                                       style="border: 1px solid #e3e3e3 !important"
                                       type="text" v-model="products[index].category_name"/>

                                <datalist class="custom-scrollbar" id="catsName"
                                          style="max-height: 50px !important; overflow-y: auto !important;">
                                    <option :data-id="cat.id" :value="cat.name" v-for="cat in categories">{{ cat.name
                                        }}
                                    </option>
                                </datalist>

                                <!--<select name="" title v-model="products[index].category_id" class="form-control"-->
                                <!--style="border: 1px solid #e3e3e3 !important"-->
                                <!--@change="selectForAllSameCategory(products[index].category_name, $event)">-->
                                <!--<option :value="null">Select</option>-->
                                <!--<option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>-->
                                <!--</select>-->
                                <!--<div v-if="item.errors.length > 0 && item.errors.includes('category_not_found')">-->
                                <!--<textarea type="text" title="" v-model="products[index].category_name"-->
                                <!--@input="selectForAllSameCategory(products[index].category_name, $event)"-->
                                <!--class="form-control"-->
                                <!--:rows="getRowSize(products[index].category_name)"></textarea>-->
                                <!--<div v-if="products[index].category_name">-->
                                <!--<input @input="selectForAllSameCategory(products[index].category_name, $event)"-->
                                <!--type="checkbox" v-model="products[index].create_category_if_not_exist">-->
                                <!--create-->
                                <!--category if not found-->
                                <!--</div>-->
                                <!--</div>-->
                            </td>

                            <td>
                                <select class="form-control" name="" style="border: 1px solid #e3e3e3 !important;" title
                                        v-model="products[index].source_id">
                                    <option :value="null" disabled>{{ $utils.t__('general', 'select') }}</option>
                                    <option :value="shop.id" v-for="shop in shops">{{ shop.name }}</option>
                                </select>

                            </td>

                            <td>
                                <input :value="products[index].display_price"
                                       @blur="displayPrice($event, true, index)"
                                       @change="changePrice($event, true, index)"
                                       @focus="setPrice(true, index)"
                                       class="form-control"
                                       type="text">
                                <!--v-model="products[index].formatted_price"-->
                            </td>
                            <td>

                                <input :value="products[index].display_vat_price"
                                       @blur="displayPrice($event, false, index)"
                                       @change="changePrice($event, false, index)"
                                       @focus="setPrice(false, index)"
                                       class="form-control pull-left"
                                       type="text">
                                <!--v-model="products[index].formatted_vat_price"-->
                                <div class="pull-right"
                                     style="margin-top: -34px;"
                                     v-if="typeof products[index].vat_price !== 'number' || (item.errors.length > 0 && item.errors.includes('product_gross_price_wrong'))">
                                    <a @click="fixProductPrice(index)" class="btn btn-info btn-sm"
                                       href="javascript:void(0)">
                                        {{ $utils.t__('general', 'fix')}}
                                    </a>
                                </div>

                            </td>
                            <!--<td>-->
                            <!--<div class="form-group row">-->
                            <!--<label class="col-md-5 control-label">-->
                            <!--{{ $utils.t__('general', 'min_price') }}:-->
                            <!--</label>-->
                            <!--<div class="col-md-7">-->
                            <!--<input type="number" step="0.01" v-model="products[index].min_price"-->
                            <!--class="form-control">-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--<div class="form-group row">-->
                            <!--<label class="col-md-5 control-label">-->
                            <!--{{ $utils.t__('general', 'max_price') }}:-->
                            <!--</label>-->
                            <!--<div class="col-md-7">-->
                            <!--<input type="number" step="0.01" v-model="products[index].max_price"-->
                            <!--class="form-control">-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--<div class="form-group row">-->
                            <!--<label class="col-md-5 control-label">-->
                            <!--{{ $utils.t__('general', 'purchase_price') }}:-->
                            <!--</label>-->
                            <!--<div class="col-md-7">-->
                            <!--<input type="number" step="0.01" v-model="products[index].purchase_price"-->
                            <!--class="form-control">-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--<div class="form-group row">-->
                            <!--<label class="col-md-5 control-label">-->
                            <!--{{ $utils.t__('general', 'shipping_cost') }}:-->
                            <!--</label>-->
                            <!--<div class="col-md-7">-->
                            <!--<input type="number" step="0.01" v-model="products[index].shipping_cost"-->
                            <!--class="form-control">-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--</td>-->
                            <td>
                                <a @click="openLink(products[index].link)"
                                   href="javascript:void(0)">
                                    <div class="custom-icon-link"></div>
                                </a>
                            </td>
                            <td>
                                <bootstrap-toggle :disabled="false"
                                                  :options="{
                                                      on: $utils.t__('general', 'yes'),
                                                      off: $utils.t__('general', 'no'),
                                                      onstyle: 'success',
                                                      offstyle: 'danger'
                                                  }"
                                                  v-model="products[index].manual_override"></bootstrap-toggle>
                            </td>
                            <td>
                                <div class="c-tooltip" data-direction="bottom" v-if="item.errors">
                                    <div class="c-tooltip__initiator">
                                        <i class="custom-icon-exp"></i>
                                    </div>
                                    <div class="c-tooltip__item error"
                                         v-html="$utils.getTooltipData(item.errors, true)"></div>
                                </div>
                                <div v-else>--</div>
                                <!--<p v-for="(error, key) in item.errors">-->
                                <!--<span class="icon-with-text">{{ $utils.t__('general', error) }}</span>-->
                                <!--</p>-->
                            </td>
                            <td>
                                <a @click.prevent="saveData(index)"
                                   href="javascript:void(0)">
                                    <i class="fa fa-save"
                                       style="color: #e3e3e3; font-size: 20px; vertical-align: super"></i>
                                </a>
                                <a @click.prevent="removeData(index)"
                                   href="javascript:void(0)">
                                    <div class="custom-icon-time" style="background-color: #e3e3e3"></div>
                                </a>
                            </td>
                        </tr>

                        <tr v-if="products.length === 0">
                            <td colspan="10">{{ $utils.t__('general', 'no_data_yet')}}</td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="col-md-12 no-padding">
                        <div class="col-md-6 no-padding">
                            <a :href="back_url" class="btn btn-secondary-transparent" style="text-transform: uppercase">{{
                                $utils.t__('general', 'back')
                                }}</a>
                        </div>
                        <div class="col-md-6 no-padding">
                            <button class="btn btn-settings-custom pull-right" style="text-transform: uppercase"
                                    type="submit">{{ $utils.t__('general',
                                'save') }}
                            </button>
                        </div>
                        <div class="col-md-12">
                            <br>
                        </div>
                    </div>
                    <pagination :first_load="firstLoad" :info="info" :midSize="parseInt(10)"
                                :pagination="pagination" @paginate="fetchResults"></pagination>
                    <!--<button class="btn btn-success">{{ $utils.t__('general', 'update_and_save') }}</button>-->
                </form>
                <br>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="filterProduct" role="dialog">
            <div class="modal-dialog custom-modal-width">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">{{ $utils.t__('general', 'batch_process') }}</h4>
                    </div>
                    <div class="modal-body">
                        <h5 style="text-transform: uppercase">{{ $utils.t__('general', 'all_error_entries') }}</h5>
                        <div class="row">
                            <div class="col-md-2">
                                <div style="padding-top: 15px; text-transform: uppercase">
                                    {{ $utils.t__('general', 'where') }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <select class="form-control custom-input" debounce-events="change" name=""
                                        title="column"
                                        v-debounce:2s="batchProcessFilter" v-model="filter.where_column">
                                    <option value="">{{ $utils.t__('general', 'Please Select') }}</option>
                                    <option value="name">{{ $utils.t__('general', 'product') }}</option>
                                    <option value="category_name">{{ $utils.t__('general', 'category') }}</option>
                                    <option value="price">{{ $utils.t__('general', 'net_price') }}</option>
                                    <option value="vat_price">{{ $utils.t__('general', 'gross_price') }}</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <div style="padding: 15px 0 0 15px">
                                    =
                                </div>
                            </div>

                            <div class="col-md-4">
                                <input class="form-control custom-input" debounce-events="input"
                                       type="text" v-debounce:2s="batchProcessFilter"
                                       v-model="filter.where_column_value">
                            </div>

                            <div class="col-md-1">
                                <div style="padding-top: 15px; text-transform: uppercase">
                                    {{ $utils.t__('general', 'is/are') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <br>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div style="padding-top: 15px; text-transform: uppercase">
                                    {{ $utils.t__('general', 'select_and_change') }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <select class="form-control custom-input" name="" title="column"
                                        v-model="filter.set_column">
                                    <option value="">{{ $utils.t__('general', 'Please Select') }}</option>
                                    <option value="name">{{ $utils.t__('general', 'product') }}</option>
                                    <option value="category_name">{{ $utils.t__('general', 'category') }}</option>
                                    <option value="price">{{ $utils.t__('general', 'net_price') }}</option>
                                    <option value="vat_price">{{ $utils.t__('general', 'gross_price') }}</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <div style="padding: 15px 0 0 15px">
                                    =
                                </div>
                            </div>

                            <div class="col-md-5">
                                <input class="form-control custom-input" type="text" v-model="filter.set_column_value">
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <hr class="hr-color">
                        <i class="fa fa-refresh fa-spin fa-2x" style="font-size:24px" v-if="loading"></i>

                        <div class="pull-left"
                             style="display: inline-block; text-transform: uppercase; font-weight: bold; font-size: 20px; text-align: left">
                            {{ $utils.t__('general', 'This update will update')}} <span style="color: #10B7B0">{{ filter.result_count }} {{ $utils.t__('general', 'entries') }}.</span>
                            <br>
                            {{ $utils.t__('general', 'Should the automated correction to be applied?')}}
                        </div>

                        <button @click="updateFilterValue" class="btn btn-success-custom" style="display: inline-block"
                                type="button">{{
                            $utils.t__('general', 'yes') }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Pagination from '../../components/pagination'
    import BootstrapToggle from 'vue-bootstrap-toggle'
    import vueDebounce from 'vue-debounce'

    window.Vue.use(vueDebounce);
    window.Vue.use(vueDebounce, {
        listenTo: ['input', 'change']
    });

    export default {
        name: "bulk-upload-fix",
        components: {
            Pagination, BootstrapToggle
        },
        props: {
            bulk_product: {
                required: true
            },
            total: {
                required: true
            },
            uploaded: {
                require: true
            },
            deleted: {
                required: true
            },
            shops: {
                required: true
            },
            categories: {
                required: true
            },
            auth_id: {
                require: true
            },
            back_url: {
                require: true
            }
        },
        created() {
        },
        mounted() {

            this.total_data = this.total;
            this.deleted_data = this.deleted;
            this.uploaded_data = this.uploaded;
            if (this.bulk_product.data.length > 0)
                this.products = this.bulk_product.data.map(elm => {
                    let product = elm.description_as_array;
                    // product.create_category_if_not_exist = false;
                    product.errors = Array.isArray(product.errors) === true ? Object.values(product.errors) : [];
                    product.display_price = this.$utils.formatMoney(product.price / 100);
                    product.display_vat_price = this.$utils.formatMoney(product.vat_price / 100);
                    return product;
                });
            this.makePagination(this.bulk_product);
        },

        data: function () {
            return {
                baseurl: baseurl,
                total_data: 0,
                deleted_data: 0,
                uploaded_data: 0,
                products: [],
                pagination: {},
                info: {},
                firstLoad: true,

                loading: false,
                filter: {
                    where_column: '',
                    where_column_value: '',
                    set_column: '',
                    set_column_value: '',
                    result_count: 0
                }
            }
        },
        computed: {
            message() {
                return `Total ${this.total_data} product data tried to be uploaded, ${this.uploaded_data} successfully uploaded, ${this.deleted_data} deleted,
                    ${this.total_data - (this.deleted_data + this.uploaded_data)} product data needs to be corrected.`;
            }
        },
        methods: {
            changePrice(e, isItNet, index) {
                // this.displayPrice(e, isItNet, index)
            },

            setPrice(isItNet, index) {
                if (isItNet) {
                    this.products[index].display_price = this.products[index].price
                } else {
                    this.products[index].display_vat_price = this.products[index].vat_price
                }
            },

            displayPrice(e, isItNet, index) {
                let enteredPrice = parseFloat(e.target.value);
                if (isItNet) {
                    let currentPrice = parseFloat(this.products[index].price);
                    if (enteredPrice !== currentPrice) {
                        this.products[index].price = enteredPrice;
                        this.products[index].vat_price = parseFloat((enteredPrice * 1.19).toFixed(2));
                        this.products[index].display_vat_price = this.$utils.formatMoney(this.products[index].vat_price / 100)
                    }
                    this.products[index].display_price = this.$utils.formatMoney(enteredPrice / 100)
                } else {
                    let currentPrice = parseFloat(this.products[index].vat_price);
                    if (enteredPrice !== currentPrice) {
                        this.products[index].vat_price = enteredPrice;
                        this.products[index].price = parseFloat((enteredPrice / 1.19).toFixed(2));
                        this.products[index].display_price = this.$utils.formatMoney(this.products[index].price / 100)
                    }
                    this.products[index].display_vat_price = this.$utils.formatMoney(enteredPrice / 100)
                }
            },

            openLink(url) {
                if (url) {
                    if (confirm(this.$utils.t__('general', 'Link_will_open_in_new_tab_Proceed'))) {
                        window.open(url, '_blank');
                    }
                } else {
                    alert(this.$utils.t__('general', 'No_link_found'))
                }
            },
            putCategoryIdOnProduct(e) {
                let categoryName = this.products[e].category_name;
                let obj = this.categories.find(cat => {
                    return cat.name === categoryName
                });
                if (obj) {
                    this.products[e].category_id = obj.id;
                }
            },


            batchProcessFilter() {
                if (this.filter.where_column === '' && this.filter.where_column_value !== '') {
                    return alert(this.$utils.t__('general', 'Please_select_where_column_type'));
                }
                let queryParam = this.filter.where_column + '=' + this.filter.where_column_value;

                if (this.filter.where_column !== '' && this.filter.where_column_value !== '') {
                    let pageUrl = this.bulk_product.path + '?' + queryParam;
                    let app = this;
                    app.loading = true;
                    axios.get(pageUrl)
                        .then(response => {
                            app.loading = false;
                            app.filter.result_count = response.data;
                        })
                        .catch(reason => {
                            console.log(reason);
                            app.loading = false
                        })
                }
            },

            fetchResults(page_url) {
                let app = this;
                axios.get(page_url)
                    .then(response => {
                        let products = response.data.data;
                        products = Object.values(products);
                        if (products.length > 0) {
                            app.products = products.map(elm => {
                                let product = elm.description_as_array;
                                // product.create_category_if_not_exist = false;
                                return product;
                            })
                        }
                        app.makePagination(response.data);
                        if (products.length === 0)
                            setTimeout(() => {
                                window.open(baseurl + '/my-shop', '_self')
                            }, 500)
                    })
            },

            makePagination: function (data) {

                this.pagination = {
                    current_page: data.current_page,
                    path: data.path,
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

            updateFilterValue() {
                if (this.filter.where_column === '' && this.filter.where_column_value === '' &&
                    this.filter.set_column === '' && this.filter.set_column_value === '') {
                    alert(this.$utils.t__('general', 'fill_up_all_fields'));
                    return false;
                }
                let app = this;
                app.loading = true;
                axios.post(baseurl + '/products/update-bulk-upload-data-by-filter', this.filter)
                    .then(response => {
                        app.loading = false;
                        app.products = response.data.data.map(elm => {
                            let product = elm.description_as_array;
                            product.create_category_if_not_exist = false;
                            return product;
                        });
                        $('#filterProduct').modal('toggle');
                    })
                    .catch(reason => {
                        console.log(reason)
                    })
            },

            selectForAllSameCategory(category_name, e) {
                let checked = e.target.checked;
                let value;
                let catId = null;
                if (e.type == 'change') {
                    value = category_name;
                    catId = e.target.value;
                } else {
                    value = e.target.value ? e.target.value : category_name;
                }
                this.products = this.products.map(product => {
                    if (product.category_name == category_name && category_name != null && category_name != '') {
                        product.create_category_if_not_exist = checked;
                        product.category_name = e.target.value == 'on' || e.target.value == 'off' ? category_name : value;
                        product.category_id = catId;
                    }
                    return product;
                })
            },

            removeData(index) {
                const temp_id = this.products[index].temp_id;
                if (confirm(this.$utils.t__('general', 'are_you_sure?'))) {
                    let app = this;
                    axios.post(baseurl + '/products/remove-product-from-error-list', {temp_id: temp_id})
                        .then(response => {
                            app.products.splice(index, 1);
                            app.deleted_data += 1;
                        })
                }
            },

            save() {
                let data = this.products;
                let app = this;
                axios.post(baseurl + '/update-products-csv-store', data)
                    .then(response => {
                        let data = response.data;
                        data.forEach(item => {
                            let index = item[index];
                            let product = item[product];
                            if (product != null) {
                                app.products[index] = item[product];
                            } else {
                                app.products.splice(index, 1);
                                app.uploaded_data += 1;
                            }
                        });
                        if (app.products.length === 0) {
                            alert(app.$utils.t__('general', 'product_create_success'));
                            app.fetchResults(app.bulk_product.path + '?page=1')
                        }

                    })
                    .catch(error => {
                        console.log(error)
                    })
            },

            saveData(index) {
                let product = this.products[index];

                if (product.name === '') {
                    alert(this.$utils.t__('general', 'product_required'));
                    return false
                }
                if (product.price === '' || product.vat_price === '') {
                    alert(this.$utils.t__('general', 'price_required'));
                    return false
                }

                let data = {product: product, index: index};
                let app = this;
                axios.post(baseurl + '/products/save-product-from-csv-fix', data)
                    .then(response => {
                        let index = response.data.index;
                        if (response.data.product != null) {
                            app.products[index] = response.data.product;
                            alert(app.$utils.t__('general', 'error'))
                        } else {
                            app.products.splice(index, 1);
                            app.uploaded_data += 1;
                            alert(app.$utils.t__('general', 'success'))
                        }

                    })
                    .catch(error => {
                        console.log(error)
                    })
            },

            fixProductPrice(index) {
                this.products[index].vat_price = this.products[index].system_calculated_vat_price;
                this.products[index].display_vat_price = this.$utils.formatMoney(this.products[index].vat_price / 100);
                let errIndex = this.products[index].errors.findIndex(err => {
                    return err === "product_gross_price_wrong";
                });
                this.products[index].errors.splice(errIndex, 1);
            },

            getRowSize(name) {
                const strLength = name ? name.length : 0;
                let size = 0;
                if (strLength > -1 && strLength < 10) {
                    size += 1;
                } else if (strLength > 10 && strLength < 30) {
                    size += 2;
                } else if (strLength > 30 && strLength < 50) {
                    size += 3;
                } else if (strLength > 50 && strLength < 70) {
                    size += 4;
                } else if (strLength > 50 && strLength < 70) {
                    size += 5;
                } else if (strLength > 70 && strLength < 90) {
                    size += 6;
                } else if (strLength > 90 && strLength < 110) {
                    size += 7;
                } else if (strLength > 110 && strLength < 130) {
                    size += 8;
                } else {
                    size += 9;
                }
                return size;
            }
        }
    }
</script>
