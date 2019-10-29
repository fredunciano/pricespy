<template>
    <div>
        <div class="col-md-12" v-if="parseInt(solution_type) === 1">
            <h4>Information of products</h4>
            <p>
                Total {{ products.filter(elm=>{return elm.success }).length }} product price successfully updated, {{
                products.filter(elm=>{return elm.success === false }).length }} product price needs to be corrected.
            </p>
            <div class="table-responsive">
                <form @submit.prevent="update()" method="post">
                    <table class="table table-custom">
                        <thead>
                        <tr>
                            <th class="header-red"><b v-html="$utils.tbl__('store', true)"></b></th>
                            <th class="header-purple"><b v-html="$utils.tbl__('category', true)"></b></th>
                            <th class="header-orange" width="15%"><b v-html="$utils.tbl__('product', true)"></b></th>
                            <th class="header-red" width="8%"><b v-html="$utils.tbl__('net_price', true)"></b></th>
                            <th class="header-green" width="8%"><b v-html="$utils.tbl__('gross_price', true)"></b></th>
                            <th class="header-lavender_purple"><b v-html="$utils.tbl__('message', true)"></b></th>
                            <th class="header-manhattan"><b v-html="$utils.tbl__('actions', true)"></b></th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr :key="index" v-for="(item, index) in products">
                            <td>
                                <select class="form-control" name="" title v-model="products[index].source_id">
                                    <option :value="null">Select</option>
                                    <option :value="shop.id" v-for="shop in shops">{{ shop.name }}</option>
                                </select>

                            </td>
                            <td>
                                <select class="form-control" name="" title v-model="products[index].category_id">
                                    <option :value="null">Select</option>
                                    <option :value="cat.id" v-for="cat in categories">{{ cat.name }}</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" readonly title="" type="text"
                                       v-model="products[index].product_name">
                            </td>
                            <td>
                                <input class="form-control" title="" type="text" v-model="products[index].price">
                            </td>
                            <td>

                                <input class="form-control pull-left" title="" type="text"
                                       v-model="products[index].vat_price">
                                <div class="pull-right"
                                     style="margin-top: -34px;"
                                     v-if="item.success === false && item.errors.includes('product_gross_price_wrong')">
                                    <a @click="products[index].vat_price = products[index].system_calculated_vat_price"
                                       class="btn btn-info btn-sm"
                                       href="javascript:void(0)">
                                        {{ $utils.t__('general', 'fix')}}
                                    </a>
                                </div>

                            </td>
                            <td>
                                <p class="label increase" v-if="item.success === true">
                                    {{ $utils.t__('general', 'price_updated_successfully')}}
                                </p>
                                <p v-else v-for="(error, key) in item.errors">{{ (key+1) + '. ' + $utils.t__('general',
                                    error)
                                    }}</p>
                            </td>
                            <td>
                                <a @click.prevent="removeData(index)" class="btn btn-danger" href="javascript:void(0)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-success">{{ $utils.t__('general', 'update_and_save') }}</button>
                </form>
                <br>
            </div>
        </div>

        <div class="col-md-12" v-else>
            <h4>Information of products</h4>
            <p>
                Total {{ products.filter(elm=>{return elm.success }).length }} product price successfully updated, {{
                products.filter(elm=>{return elm.success === false }).length }} product price needs to be corrected.
            </p>
            <div class="table-responsive">
                <form @submit.prevent="update()" method="post">
                    <table class="table table-custom">
                        <thead>
                        <tr>
                            <th class="header-red"><b v-html="$utils.tbl__('store', true)"></b></th>
                            <th class="header-purple"><b v-html="$utils.tbl__('category', true)"></b></th>
                            <th class="header-orange" width="15%"><b v-html="$utils.tbl__('product', true)"></b></th>
                            <th class="header-red" width="8%"><b v-html="$utils.tbl__('net_price', true)"></b></th>
                            <th class="header-green" width="8%"><b v-html="$utils.tbl__('gross_price', true)"></b></th>
                            <th class="header-blue" width="20%"><b v-html="$utils.tbl__('link', true)"></b></th>
                            <th class="header-sweet_pink" width="10%"><b
                                    v-html="$utils.tbl__('manual_override', true)"></b></th>
                            <th class="header-lavender_purple"><b v-html="$utils.tbl__('errors', true)"></b></th>
                            <th class="header-manhattan"><b v-html="$utils.tbl__('message', true)"></b></th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr :key="index" v-for="(item, index) in products">
                            <td>
                                <select class="form-control" name="" title v-model="products[index].source_id">
                                    <option :value="null">Select</option>
                                    <option :value="shop.id" v-for="shop in shops">{{ shop.name }}</option>
                                </select>

                            </td>
                            <td>

                                <select class="form-control" name="" title v-model="products[index].category_id">
                                    <option :value="null">Select</option>
                                    <option :value="cat.id" v-for="cat in categories">{{ cat.name }}</option>
                                </select>
                                <div v-if="item.success === false &&  item.errors.includes('category_not_found')">
                                    <input class="form-control" readonly title=""
                                           type="text" v-model="products[index].category_name">
                                    <input @input="selectForAllSameCategory(products[index].category_name, $event)"
                                           type="checkbox" v-model="products[index].create_category_if_not_exist">
                                    create
                                    category if not found
                                </div>
                            </td>
                            <td>
                                <input class="form-control" title="" type="text" v-model="products[index].name">
                                <div v-if="item.success === false && item.errors.includes('product_does_not_exist')">
                                    <input type="checkbox" v-model="products[index].create_product_if_not_exist">
                                    create
                                    product if not found
                                </div>
                            </td>
                            <td>
                                <input class="form-control" title="" type="text" v-model="products[index].price">
                            </td>
                            <td>

                                <input class="form-control pull-left" title="" type="text"
                                       v-model="products[index].vat_price">
                                <div class="pull-right"
                                     style="margin-top: -34px;"
                                     v-if=" item.success === false &&  item.errors.includes('product_gross_price_wrong')">
                                    <a @click="products[index].vat_price = products[index].system_calculated_vat_price"
                                       class="btn btn-info btn-sm"
                                       href="javascript:void(0)">
                                        {{ $utils.t__('general', 'fix')}}
                                    </a>
                                </div>

                            </td>
                            <td>
                                <input class="form-control" title="" type="text" v-model="products[index].link">
                            </td>
                            <td>
                                <input class="form-control" title="" type="text"
                                       v-model="products[index].manual_override">
                            </td>
                            <td>
                                <p class="label increase" v-if="item.success === true">
                                    {{ $utils.t__('general', 'price_updated_successfully')}}
                                </p>
                                <p v-else v-for="(error, key) in item.errors">{{ (key+1) + '. ' + $utils.t__('general',
                                    error)
                                    }}</p>
                            </td>
                            <td>
                                <a @click.prevent="removeData(index)" class="btn btn-danger" href="javascript:void(0)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-success">{{ $utils.t__('general', 'update_and_save') }}</button>
                </form>
                <br>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        name: "bulk-price-update-fix",

        props: {
            bulk_product: {
                required: true
            },
            solution_type: {
                required: true
            },
            shops: {
                required: true
            },
            categories: {
                required: true
            }
        },

        mounted() {
            this.products = this.bulk_product.map(elm => {
                elm.create_product_if_not_exist = false;
                elm.create_category_if_not_exist = false;
                return elm;
            })
        },

        data: function () {
            return {
                baseurl: baseurl,
                products: []
            }
        },
        computed: {},
        methods: {
            update() {
                let successProduct = this.products.filter(elm => {
                    if (elm.success) {
                        return elm;
                    }
                });
                let data = this.products.filter(elm => {
                    if (!elm.success) {
                        return elm;
                    }
                });
                let app = this;
                axios.post(baseurl + '/products/update-products-price-from-list', {
                    'data': data,
                    'solution_type': app.solution_type
                })
                    .then(response => {
                        let responseProduct = response.data;
                        app.products = [...successProduct, ...responseProduct];
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },

            removeData(index) {
                if (confirm(this.$utils.t__('general', 'are_you_sure?'))) {
                    this.products.splice(index, 1);
                    if (this.products.length === 0) {
                        window.open(baseurl + '/products/bulk-upload', '_self')
                    }
                }
            },


        }
    }
</script>
