window.Vue = require('vue');
const _ = require('lodash');
Vue.prototype.trans = string => _.get(window.i18n, string);

export default {
    t__(type, string) {
        if (type == 'routes') {
            return string;
        }
        return Vue.prototype.trans(type + '.' + string);
    },

    tbl__(string, uppercase = 0) {
        var words = Vue.prototype.trans('general.' + string);
        if (uppercase) {
            words = words.toUpperCase();
        }
        words = words.split(' ');
        if (words.length > 1) {
            words = words[0] + '<br/><span class="secondary">' + words.slice(1).join(' ') + '</span>'
        } else {
            words = '<span class="secondary">' + words[0] + '</span>';
        }
        return words;
    },

    numberClass(number) {
        if (number > 0) {
            return 'diff-success'
        } else if (number < 0) {
            return 'diff-danger'
        } else {
            return 'diff-neutral'
        }
    },

    formatMoney(number) {
        const formatter = new Intl.NumberFormat('de-DE', {
            style: 'currency',
            currency: 'EUR'
        })

        return formatter.format(number * 100);
    },

    showVisualDifference(difference, percents = false) {
        let dif = parseFloat(difference);
        if (dif === 0) {
            return difference + (percents ? ' %' : '');
        }
        return (dif > 0 ? '+ ' : '- ') + Math.abs(difference) + (percents ? ' %' : '');
    },

    getTooltipData(result, csv = false) {
        let string = '';
        if (!csv) {
            string = '<div class="tooltip-title">' + this.t__('general', 'price_history') + '</div>';
            if (result.yesterday_difference < 0) {
                string += '<div class="info-title">' + this.t__('general', 'yesterday') + ': ' + '</div> ' + result.yesterday_difference + '%<br>';
            }
            if (result.last_week_difference < 0) {
                string += '<div class="info-title">' + this.t__('general', 'last_week') + ': ' + '</div> ' + result.last_week_difference + '%<br>';
            }
            if (result.last_month_difference < 0) {
                string += '<div class="info-title">' + this.t__('general', 'last_month') + ': ' + '</div> ' + result.last_month_difference + '%<br>';
            }
            if (result.last_year_difference < 0) {
                string += '<div class="info-title">' + this.t__('general', 'last_year') + ': ' + '</div> ' + result.last_year_difference + '%<br>';
            }
            if (string === '<div class="tooltip-title">' + this.t__('general', 'price_history') + '</div>') {
                string = '<div style="padding: 5px 0 0 10px; text-align: center">No price history</div>';
            }
        } else {
            string = '<div class="tooltip-title">' + this.t__('general', 'errors') + '</div>';
            // console.log(result)
            for (let i = 0; i < result.length; i++) {
                string += '<div class="info-title">' + '</div> <i class="fa fa-arrow-right"></i> ' + this.t__('general', result[i]) + '<br>';
            }
        }

        return string;
    },
}
