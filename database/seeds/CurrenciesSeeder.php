<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\CurrencyRate;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            [
                'currency' => 'AED',
                'rate' => 4.164695,
            ],
            [
                'currency' => 'AFN',
                'rate' => 86.063163,
            ],
            [
                'currency' => 'ALL',
                'rate' => 123.24091,
            ],
            [
                'currency' => 'AMD',
                'rate' => 547.588084,
            ],
            [
                'currency' => 'ANG',
                'rate' => 2.00865,
            ],
            [
                'currency' => 'AOA',
                'rate' => 349.828134,
            ],
            [
                'currency' => 'ARS',
                'rate' => 43.254678,
            ],
            [
                'currency' => 'AUD',
                'rate' => 1.579961,
            ],
            [
                'currency' => 'AWG',
                'rate' => 2.040849,
            ],
            [
                'currency' => 'AZN',
                'rate' => 1.933113,
            ],
            [
                'currency' => 'BAM',
                'rate' => 1.961312,
            ],
            [
                'currency' => 'BBD',
                'rate' => 2.265115,
            ],
            [
                'currency' => 'BDT',
                'rate' => 94.858674,
            ],
            [
                'currency' => 'BGN',
                'rate' => 1.955582,
            ],
            [
                'currency' => 'BHD',
                'rate' => 0.427388,
            ],
            [
                'currency' => 'BIF',
                'rate' => 2021.517447,
            ],
            [
                'currency' => 'BMD',
                'rate' => 1.133805,
            ],
            [
                'currency' => 'BND',
                'rate' => 1.786661,
            ],
            [
                'currency' => 'BOB',
                'rate' => 7.819456,
            ],
            [
                'currency' => 'BRL',
                'rate' => 4.442531,
            ],
            [
                'currency' => 'BSD',
                'rate' => 1.131481,
            ],
            [
                'currency' => 'BTC',
                'rate' => 0.000347,
            ],
            [
                'currency' => 'BTN',
                'rate' => 81.121503,
            ],
            [
                'currency' => 'BWP',
                'rate' => 12.181579,
            ],
            [
                'currency' => 'BYN',
                'rate' => 2.399581,
            ],
            [
                'currency' => 'BYR',
                'rate' => 22222.576048,
            ],
            [
                'currency' => 'BZD',
                'rate' => 2.281045,
            ],
            [
                'currency' => 'CAD',
                'rate' => 1.517655,
            ],
            [
                'currency' => 'CDF',
                'rate' => 1840.165423,
            ],
            [
                'currency' => 'CHF',
                'rate' => 1.12825,
            ],
            [
                'currency' => 'CLF',
                'rate' => 0.028399,
            ],
            [
                'currency' => 'CLP',
                'rate' => 775.195298,
            ],
            [
                'currency' => 'CNY',
                'rate' => 7.819831,
            ],
            [
                'currency' => 'COP',
                'rate' => 3622.620037,
            ],
            [
                'currency' => 'CRC',
                'rate' => 675.549301,
            ],
            [
                'currency' => 'CUC',
                'rate' => 1.133805,
            ],
            [
                'currency' => 'CUP',
                'rate' => 30.04583,
            ],
            [
                'currency' => 'CVE',
                'rate' => 110.581696,
            ],
            [
                'currency' => 'CZK',
                'rate' => 25.803359,
            ],
            [
                'currency' => 'DJF',
                'rate' => 201.499594,
            ],
            [
                'currency' => 'DKK',
                'rate' => 7.465788,
            ],
            [
                'currency' => 'DOP',
                'rate' => 56.933988,
            ],
            [
                'currency' => 'DZD',
                'rate' => 134.673379,
            ],
            [
                'currency' => 'EGP',
                'rate' => 20.358565,
            ],
            [
                'currency' => 'ERN',
                'rate' => 17.006712,
            ],
            [
                'currency' => 'ETB',
                'rate' => 31.832682,
            ],
            [
                'currency' => 'EUR',
                'rate' => 1,
            ],
            [
                'currency' => 'FJD',
                'rate' => 2.408145,
            ],
            [
                'currency' => 'FKP',
                'rate' => 0.8957,
            ],
            [
                'currency' => 'GBP',
                'rate' => 0.898189,
            ],
            [
                'currency' => 'GEL',
                'rate' => 3.024423,
            ],
            [
                'currency' => 'GGP',
                'rate' => 0.898166,
            ],
            [
                'currency' => 'GHS',
                'rate' => 5.494022,
            ],
            [
                'currency' => 'GIP',
                'rate' => 0.8957,
            ],
            [
                'currency' => 'GMD',
                'rate' => 56.179745,
            ],
            [
                'currency' => 'GNF',
                'rate' => 10293.144764,
            ],
            [
                'currency' => 'GTQ',
                'rate' => 8.758761,
            ],
            [
                'currency' => 'GYD',
                'rate' => 236.574051,
            ],
            [
                'currency' => 'HKD',
                'rate' => 8.860402,
            ],
            [
                'currency' => 'HNL',
                'rate' => 27.603047,
            ],
            [
                'currency' => 'HRK',
                'rate' => 7.392636,
            ],
            [
                'currency' => 'HTG',
                'rate' => 86.011004,
            ],
            [
                'currency' => 'HUF',
                'rate' => 323.320294,
            ],
            [
                'currency' => 'IDR',
                'rate' => 16516.702887,
            ],
            [
                'currency' => 'ILS',
                'rate' => 4.280215,
            ],
            [
                'currency' => 'IMP',
                'rate' => 0.898166,
            ],
            [
                'currency' => 'INR',
                'rate' => 81.129412,
            ],
            [
                'currency' => 'IQD',
                'rate' => 1350.304946,
            ],
            [
                'currency' => 'IRR',
                'rate' => 47738.85527,
            ],
            [
                'currency' => 'ISK',
                'rate' => 139.197076,
            ],
            [
                'currency' => 'JEP',
                'rate' => 0.898166,
            ],
            [
                'currency' => 'JMD',
                'rate' => 145.455899,
            ],
            [
                'currency' => 'JOD',
                'rate' => 0.804549,
            ],
            [
                'currency' => 'JPY',
                'rate' => 128.452724,
            ],
            [
                'currency' => 'KES',
                'rate' => 116.203233,
            ],
            [
                'currency' => 'KGS',
                'rate' => 79.175822,
            ],
            [
                'currency' => 'KHR',
                'rate' => 4549.335762,
            ],
            [
                'currency' => 'KMF',
                'rate' => 493.602242,
            ],
            [
                'currency' => 'KPW',
                'rate' => 1020.494275,
            ],
            [
                'currency' => 'KRW',
                'rate' => 1282.163112,
            ],
            [
                'currency' => 'KWD',
                'rate' => 0.345015,
            ],
            [
                'currency' => 'KYD',
                'rate' => 0.943065,
            ],
            [
                'currency' => 'KZT',
                'rate' => 419.814049,
            ],
            [
                'currency' => 'LAK',
                'rate' => 9682.750676,
            ],
            [
                'currency' => 'LBP',
                'rate' => 1706.546472,
            ],
            [
                'currency' => 'LKR',
                'rate' => 203.969377,
            ],
            [
                'currency' => 'LRD',
                'rate' => 178.74428,
            ],
            [
                'currency' => 'LSL',
                'rate' => 16.31829,
            ],
            [
                'currency' => 'LTL',
                'rate' => 3.347831,
            ],
            [
                'currency' => 'LVL',
                'rate' => 0.685827,
            ],
            [
                'currency' => 'LYD',
                'rate' => 1.58024,
            ],
            [
                'currency' => 'MAD',
                'rate' => 10.878914,
            ],
            [
                'currency' => 'MDL',
                'rate' => 19.566039,
            ],
            [
                'currency' => 'MGA',
                'rate' => 3982.049385,
            ],
            [
                'currency' => 'MKD',
                'rate' => 61.525915,
            ],
            [
                'currency' => 'MMK',
                'rate' => 1779.450044,
            ],
            [
                'currency' => 'MNT',
                'rate' => 2991.592942,
            ],
            [
                'currency' => 'MOP',
                'rate' => 9.107344,
            ],
            [
                'currency' => 'MRO',
                'rate' => 404.768776,
            ],
            [
                'currency' => 'MUR',
                'rate' => 39.150851,
            ],
            [
                'currency' => 'MVR',
                'rate' => 17.517717,
            ],
            [
                'currency' => 'MWK',
                'rate' => 823.919007,
            ],
            [
                'currency' => 'MXN',
                'rate' => 22.882994,
            ],
            [
                'currency' => 'MYR',
                'rate' => 4.732516,
            ],
            [
                'currency' => 'MZN',
                'rate' => 69.8141,
            ],
            [
                'currency' => 'NAD',
                'rate' => 16.318286,
            ],
            [
                'currency' => 'NGN',
                'rate' => 410.789129,
            ],
            [
                'currency' => 'NIO',
                'rate' => 36.694429,
            ],
            [
                'currency' => 'NOK',
                'rate' => 9.767499,
            ],
            [
                'currency' => 'NPR',
                'rate' => 130.291237,
            ],
            [
                'currency' => 'NZD',
                'rate' => 1.665389,
            ],
            [
                'currency' => 'OMR',
                'rate' => 0.436509,
            ],
            [
                'currency' => 'PAB',
                'rate' => 1.131594,
            ],
            [
                'currency' => 'PEN',
                'rate' => 3.793541,
            ],
            [
                'currency' => 'PGK',
                'rate' => 3.812589,
            ],
            [
                'currency' => 'PHP',
                'rate' => 60.116606,
            ],
            [
                'currency' => 'PKR',
                'rate' => 157.710818,
            ],
            [
                'currency' => 'PLN',
                'rate' => 4.288379,
            ],
            [
                'currency' => 'PYG',
                'rate' => 6705.540845,
            ],
            [
                'currency' => 'QAR',
                'rate' => 4.128226,
            ],
            [
                'currency' => 'RON',
                'rate' => 4.655006,
            ],
            [
                'currency' => 'RSD',
                'rate' => 118.425643,
            ],
            [
                'currency' => 'RUB',
                'rate' => 75.503508,
            ],
            [
                'currency' => 'RWF',
                'rate' => 1009.347136,
            ],
            [
                'currency' => 'SAR',
                'rate' => 4.252899,
            ],
            [
                'currency' => 'SBD',
                'rate' => 9.192833,
            ],
            [
                'currency' => 'SCR',
                'rate' => 15.465244,
            ],
            [
                'currency' => 'SDG',
                'rate' => 53.878627,
            ],
            [
                'currency' => 'SEK',
                'rate' => 10.264313,
            ],
            [
                'currency' => 'SGD',
                'rate' => 1.558526,
            ],
            [
                'currency' => 'SHP',
                'rate' => 1.497646,
            ],
            [
                'currency' => 'SLL',
                'rate' => 9750.721991,
            ],
            [
                'currency' => 'SOS',
                'rate' => 657.606887,
            ],
            [
                'currency' => 'SRD',
                'rate' => 8.455956,
            ],
            [
                'currency' => 'STD',
                'rate' => 23867.272994,
            ],
            [
                'currency' => 'SVC',
                'rate' => 9.901968,
            ],
            [
                'currency' => 'SYP',
                'rate' => 583.909435,
            ],
            [
                'currency' => 'SZL',
                'rate' => 16.280321,
            ],
            [
                'currency' => 'THB',
                'rate' => 37.183135,
            ],
            [
                'currency' => 'TJS',
                'rate' => 10.660091,
            ],
            [
                'currency' => 'TMT',
                'rate' => 3.968317,
            ],
            [
                'currency' => 'TND',
                'rate' => 3.330949,
            ],
            [
                'currency' => 'TOP',
                'rate' => 2.562002,
            ],
            [
                'currency' => 'TRY',
                'rate' => 6.098113,
            ],
            [
                'currency' => 'TTD',
                'rate' => 7.627162,
            ],
            [
                'currency' => 'TWD',
                'rate' => 34.958665,
            ],
            [
                'currency' => 'TZS',
                'rate' => 2607.64147,
            ],
            [
                'currency' => 'UAH',
                'rate' => 31.572498,
            ],
            [
                'currency' => 'UGX',
                'rate' => 4181.355622,
            ],
            [
                'currency' => 'USD',
                'rate' => 1.133805,
            ],
            [
                'currency' => 'UYU',
                'rate' => 36.474322,
            ],
            [
                'currency' => 'UZS',
                'rate' => 9382.632438,
            ],
            [
                'currency' => 'VEF',
                'rate' => 281827.333314,
            ],
            [
                'currency' => 'VND',
                'rate' => 26439.196472,
            ],
            [
                'currency' => 'VUV',
                'rate' => 128.790109,
            ],
            [
                'currency' => 'WST',
                'rate' => 2.957733,
            ],
            [
                'currency' => 'XAF',
                'rate' => 657.821712,
            ],
            [
                'currency' => 'XAG',
                'rate' => 0.077565,
            ],
            [
                'currency' => 'XAU',
                'rate' => 0.000915,
            ],
            [
                'currency' => 'XCD',
                'rate' => 3.064164,
            ],
            [
                'currency' => 'XDR',
                'rate' => 0.82072,
            ],
            [
                'currency' => 'XOF',
                'rate' => 657.822095,
            ],
            [
                'currency' => 'XPF',
                'rate' => 119.594048,
            ],
            [
                'currency' => 'YER',
                'rate' => 283.785485,
            ],
            [
                'currency' => 'ZAR',
                'rate' => 16.280928,
            ],
            [
                'currency' => 'ZMK',
                'rate' => 10205.603135,
            ],
            [
                'currency' => 'ZMW',
                'rate' => 13.607885,
            ],
            [
                'currency' => 'ZWL',
                'rate' => 365.487691,
            ],
        ];

        $date = Carbon::now();

        foreach ($rates as $i => $rate) {
            $rates[$i]['created_at'] = $date;
            $rates[$i]['updated_at'] = $date;
        }

        CurrencyRate::insert($rates);
    }
}
