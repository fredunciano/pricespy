<template>
    <div v-if="first_load" class="row">
        <div class="col-sm-5 hidden-xs">
            <div class="dataTables_info" role="status" aria-live="polite">
                <strong>{{ info.from ? info.from : 0 }}</strong> {{ $utils.t__('general', 'to') }} <strong>{{ info.to ?
                info.to : 0 }} </strong> {{ $utils.t__('general', 'from') }}
                <strong> {{ info.total
                    }} </strong> {{ $utils.t__('general', 'entries') }}
            </div>
        </div>
        <div class="col-sm-7 col-xs-12 clearfix">
            <div class="paging_bootstrap" style="text-align: right">
                <ul class="pagination pagination-sm remove-margin">
                    <li :class="{disabled: !pagination.prev_page_url, prev: true}">
                        <a href="javascript:void(0)" @click="fetchResults(pagination.prev_page_url)"><i
                                class="fa fa-chevron-left"></i></a>
                    </li>

                    <li :class="[ ((pagination.current_page === pageNo) ? 'active' : '') ]"
                        v-for="pageNo in range(paginateLoop, numberOfPage)"
                        @click="fetchResults(pagination.path + '?page=' + pageNo)">
                        <a href="javascript:void(0)">{{ pageNo }}</a>
                    </li>

                    <li :class="{disabled: !pagination.next_page_url, next: true}">
                        <a @click="fetchResults(pagination.next_page_url)" href="javascript:void(0)"> <i
                                class="fa fa-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "pagination",
        props: {
            info: {
                required: true,
                type: Object
            },
            pagination: {
                required: true,
                type: Object
            },
            first_load: {
                required: true,
                type: Boolean
            },
            midSize: {
                required: true,
                type: Number,
                default: 5
            }
        },
        methods: {
            fetchResults(pageNo) {
                this.$emit('paginate', pageNo);
                $("html, body").animate({scrollTop: "10px"}, 1500)
            },

            range(start, count) {
                return Array.apply(0, Array(count))
                    .map(function (element, index) {
                        return Math.round(index + start);
                    });
            },
        },
        computed: {
            paginateLoop() {
                let results = this.pagination;

                if (results.last_page > this.midSize) {
                    if ((results.last_page - ((this.midSize - 1) / 2)) <= results.current_page) {
                        return results.last_page - (this.midSize - 1);
                    }

                    if (results.current_page > (((this.midSize - 1) / 2) + 1)) {
                        return results.current_page - ((this.midSize - 1) / 2);
                    }
                }
                return 1;
            },

            numberOfPage() {
                if (this.pagination.last_page < this.midSize) {
                    return this.pagination.last_page;
                } else {
                    return this.midSize;
                }
            }
        }
    }
</script>

<style scoped>

</style>