<?php

use Illuminate\Database\Seeder;
use App\VatRate;

class VatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = [
            [
                'country' => 'Andorra',
                'code' => 'AD',
                'rate' => 4.5,
            ],
            [
                'country' => 'United Arab Emirates',
                'code' => 'AE',
                'rate' => 5,
            ],
            [
                'country' => 'Afghanistan',
                'code' => 'AF',
                'rate' => 10,
            ],
            [
                'country' => 'Albania',
                'code' => 'AL',
                'rate' => 20,
            ],
            [
                'country' => 'Angola',
                'code' => 'AO',
                'rate' => 10,
            ],
            [
                'country' => 'Argentina',
                'code' => 'AR',
                'rate' => 21,
            ],
            [
                'country' => 'Austria',
                'code' => 'AT',
                'rate' => 20,
            ],
            [
                'country' => 'Australia',
                'code' => 'AU',
                'rate' => 10,
            ],
            [
                'country' => 'Aruba',
                'code' => 'AW',
                'rate' => 3,
            ],
            [
                'country' => 'Azerbaijan',
                'code' => 'AZ',
                'rate' => 18,
            ],
            [
                'country' => 'Bosnia and Herzegovina',
                'code' => 'BA',
                'rate' => 17,
            ],
            [
                'country' => 'Barbados',
                'code' => 'BB',
                'rate' => 17.5,
            ],
            [
                'country' => 'Bangladesh',
                'code' => 'BD',
                'rate' => 15,
            ],
            [
                'country' => 'Belgium',
                'code' => 'BE',
                'rate' => 21,
            ],
            [
                'country' => 'Bulgaria',
                'code' => 'BG',
                'rate' => 20,
            ],
            [
                'country' => 'Bahrain',
                'code' => 'BH',
                'rate' => 5,
            ],
            [
                'country' => 'Bolivia',
                'code' => 'BO',
                'rate' => 13,
            ],
            [
                'country' => 'Brazil',
                'code' => 'BR',
                'rate' => 17,
            ],
            [
                'country' => 'Bahamas',
                'code' => 'BS',
                'rate' => 12,
            ],
            [
                'country' => 'Belarus',
                'code' => 'BY',
                'rate' => 20,
            ],
            [
                'country' => 'Canada',
                'code' => 'CA',
                'rate' => 15,
            ],
            [
                'country' => 'Switzerland',
                'code' => 'CH',
                'rate' => 7.7,
            ],
            [
                'country' => 'Cook Islands',
                'code' => 'CK',
                'rate' => 15,
            ],
            [
                'country' => 'Chile',
                'code' => 'CL',
                'rate' => 19,
            ],
            [
                'country' => 'China',
                'code' => 'CN',
                'rate' => 6,
            ],
            [
                'country' => 'Colombia',
                'code' => 'CO',
                'rate' => 19,
            ],
            [
                'country' => 'Costa Rica',
                'code' => 'CR',
                'rate' => 13,
            ],
            [
                'country' => 'Cape Verde',
                'code' => 'CV',
                'rate' => 15,
            ],
            [
                'country' => 'Curaçao',
                'code' => 'CW',
                'rate' => 5,
            ],
            [
                'country' => 'Cyprus',
                'code' => 'CY',
                'rate' => 19,
            ],
            [
                'country' => 'Czech Republic',
                'code' => 'CZ',
                'rate' => 21,
            ],
            [
                'country' => 'Germany',
                'code' => 'DE',
                'rate' => 19,
            ],
            [
                'country' => 'Djibouti',
                'code' => 'DJ',
                'rate' => 10,
            ],
            [
                'country' => 'Denmark',
                'code' => 'DK',
                'rate' => 25,
            ],
            [
                'country' => 'Dominica',
                'code' => 'DM',
                'rate' => 15,
            ],
            [
                'country' => 'Dominican Republic',
                'code' => 'DO',
                'rate' => 18,
            ],
            [
                'country' => 'Algeria',
                'code' => 'DZ',
                'rate' => 19,
            ],
            [
                'country' => 'Ecuador',
                'code' => 'EC',
                'rate' => 12,
            ],
            [
                'country' => 'Estonia',
                'code' => 'EE',
                'rate' => 20,
            ],
            [
                'country' => 'Egypt',
                'code' => 'EG',
                'rate' => 14,
            ],
            [
                'country' => 'Spain',
                'code' => 'ES',
                'rate' => 21,
            ],
            [
                'country' => 'Ethiopia',
                'code' => 'ET',
                'rate' => 15,
            ],
            [
                'country' => 'Finland',
                'code' => 'FI',
                'rate' => 24,
            ],
            [
                'country' => 'Fiji',
                'code' => 'FJ',
                'rate' => 9,
            ],
            [
                'country' => 'France',
                'code' => 'FR',
                'rate' => 20,
            ],
            [
                'country' => 'United Kingdom',
                'code' => 'GB',
                'rate' => 20,
            ],
            [
                'country' => 'Ghana',
                'code' => 'GH',
                'rate' => 12,
            ],
            [
                'country' => 'Guinea',
                'code' => 'GN',
                'rate' => 14,
            ],
            [
                'country' => 'Greece',
                'code' => 'GR',
                'rate' => 24,
            ],
            [
                'country' => 'Guam',
                'code' => 'GU',
                'rate' => 2,
            ],
            [
                'country' => 'Guyana',
                'code' => 'GY',
                'rate' => 18,
            ],
            [
                'country' => 'Honduras',
                'code' => 'HN',
                'rate' => 15,
            ],
            [
                'country' => 'Croatia',
                'code' => 'HR',
                'rate' => 25,
            ],
            [
                'country' => 'Hungary',
                'code' => 'HU',
                'rate' => 27,
            ],
            [
                'country' => 'Indonesia',
                'code' => 'ID',
                'rate' => 10,
            ],
            [
                'country' => 'Ireland',
                'code' => 'IE',
                'rate' => 23,
            ],
            [
                'country' => 'Israel',
                'code' => 'IL',
                'rate' => 17,
            ],
            [
                'country' => 'India',
                'code' => 'IN',
                'rate' => 12,
            ],
            [
                'country' => 'Iran',
                'code' => 'IR',
                'rate' => 8,
            ],
            [
                'country' => 'Iceland',
                'code' => 'IS',
                'rate' => 24,
            ],
            [
                'country' => 'Italy',
                'code' => 'IT',
                'rate' => 22,
            ],
            [
                'country' => 'Jersey',
                'code' => 'JE',
                'rate' => 5,
            ],
            [
                'country' => 'Jordan',
                'code' => 'JO',
                'rate' => 16,
            ],
            [
                'country' => 'Kenya',
                'code' => 'KE',
                'rate' => 16,
            ],
            [
                'country' => 'Kyrgyzstan',
                'code' => 'KG',
                'rate' => 12,
            ],
            [
                'country' => 'South Korea',
                'code' => 'KR',
                'rate' => 10,
            ],
            [
                'country' => 'Kazakhstan',
                'code' => 'KZ',
                'rate' => 12,
            ],
            [
                'country' => 'Lebanon',
                'code' => 'LB',
                'rate' => 11,
            ],
            [
                'country' => 'Saint Lucia',
                'code' => 'LC',
                'rate' => 15,
            ],
            [
                'country' => 'Sri Lanka',
                'code' => 'LK',
                'rate' => 15,
            ],
            [
                'country' => 'Liberia',
                'code' => 'LR',
                'rate' => 7,
            ],
            [
                'country' => 'Lithuania',
                'code' => 'LT',
                'rate' => 21,
            ],
            [
                'country' => 'Luxembourg',
                'code' => 'LU',
                'rate' => 17,
            ],
            [
                'country' => 'Latvia',
                'code' => 'LV',
                'rate' => 21,
            ],
            [
                'country' => 'Morocco',
                'code' => 'MA',
                'rate' => 20,
            ],
            [
                'country' => 'Monaco',
                'code' => 'MC',
                'rate' => 20,
            ],
            [
                'country' => 'Moldova',
                'code' => 'MD',
                'rate' => 20,
            ],
            [
                'country' => 'Montenegro',
                'code' => 'ME',
                'rate' => 21,
            ],
            [
                'country' => 'Madagascar',
                'code' => 'MG',
                'rate' => 20,
            ],
            [
                'country' => 'Macedonia',
                'code' => 'MK',
                'rate' => 18,
            ],
            [
                'country' => 'Malta',
                'code' => 'MT',
                'rate' => 18,
            ],
            [
                'country' => 'Mauritius',
                'code' => 'MU',
                'rate' => 15,
            ],
            [
                'country' => 'Malawi',
                'code' => 'MW',
                'rate' => 16.5,
            ],
            [
                'country' => 'Mexico',
                'code' => 'MX',
                'rate' => 16,
            ],
            [
                'country' => 'Malaysia',
                'code' => 'MY',
                'rate' => 6,
            ],
            [
                'country' => 'Namibia',
                'code' => 'NA',
                'rate' => 15,
            ],
            [
                'country' => 'Nigeria',
                'code' => 'NG',
                'rate' => 5,
            ],
            [
                'country' => 'Netherlands',
                'code' => 'NL',
                'rate' => 21,
            ],
            [
                'country' => 'Norway',
                'code' => 'NO',
                'rate' => 25,
            ],
            [
                'country' => 'Nepal',
                'code' => 'NP',
                'rate' => 15,
            ],
            [
                'country' => 'New Zealand',
                'code' => 'NZ',
                'rate' => 15,
            ],
            [
                'country' => 'Peru',
                'code' => 'PE',
                'rate' => 18,
            ],
            [
                'country' => 'Philippines',
                'code' => 'PH',
                'rate' => 12,
            ],
            [
                'country' => 'Pakistan',
                'code' => 'PK',
                'rate' => 17,
            ],
            [
                'country' => 'Poland',
                'code' => 'PL',
                'rate' => 23,
            ],
            [
                'country' => 'Puerto Rico',
                'code' => 'PR',
                'rate' => 11.5,
            ],
            [
                'country' => 'Portugal',
                'code' => 'PT',
                'rate' => 23,
            ],
            [
                'country' => 'Paraguay',
                'code' => 'PY',
                'rate' => 10,
            ],
            [
                'country' => 'Romania',
                'code' => 'RO',
                'rate' => 19,
            ],
            [
                'country' => 'Serbia',
                'code' => 'RS',
                'rate' => 20,
            ],
            [
                'country' => 'Russia',
                'code' => 'RU',
                'rate' => 18,
            ],
            [
                'country' => 'Saudi Arabia',
                'code' => 'SA',
                'rate' => 5,
            ],
            [
                'country' => 'Seychelles',
                'code' => 'SC',
                'rate' => 15,
            ],
            [
                'country' => 'Sweden',
                'code' => 'SE',
                'rate' => 25,
            ],
            [
                'country' => 'Singapore',
                'code' => 'SG',
                'rate' => 7,
            ],
            [
                'country' => 'Slovenia',
                'code' => 'SI',
                'rate' => 22,
            ],
            [
                'country' => 'Slovakia',
                'code' => 'SK',
                'rate' => 20,
            ],
            [
                'country' => 'Suriname',
                'code' => 'SR',
                'rate' => 8,
            ],
            [
                'country' => 'South Sudan',
                'code' => 'SS',
                'rate' => 5,
            ],
            [
                'country' => 'Togo',
                'code' => 'TG',
                'rate' => 18,
            ],
            [
                'country' => 'Thailand',
                'code' => 'TH',
                'rate' => 7,
            ],
            [
                'country' => 'Tunisia',
                'code' => 'TN',
                'rate' => 19,
            ],
            [
                'country' => 'Turkey',
                'code' => 'TR',
                'rate' => 18,
            ],
            [
                'country' => 'Trinidad and Tobago',
                'code' => 'TT',
                'rate' => 12.5,
            ],
            [
                'country' => 'Taiwan',
                'code' => 'TW',
                'rate' => 5,
            ],
            [
                'country' => 'Tanzania',
                'code' => 'TZ',
                'rate' => 18,
            ],
            [
                'country' => 'Ukraine',
                'code' => 'UA',
                'rate' => 20,
            ],
            [
                'country' => 'Uganda',
                'code' => 'UG',
                'rate' => 18,
            ],
            [
                'country' => 'Uruguay',
                'code' => 'UY',
                'rate' => 22,
            ],
            [
                'country' => 'Uzbekistan',
                'code' => 'UZ',
                'rate' => 20,
            ],
            [
                'country' => 'Venezuela',
                'code' => 'VE',
                'rate' => 12,
            ],
            [
                'country' => 'Vietnam',
                'code' => 'VN',
                'rate' => 10,
            ],
            [
                'country' => 'Vanuatu',
                'code' => 'VU',
                'rate' => 15,
            ],
            [
                'country' => 'Kosovo',
                'code' => 'XK',
                'rate' => 18,
            ],
            [
                'country' => 'South Africa',
                'code' => 'ZA',
                'rate' => 15,
            ],
            [
                'country' => 'Zambia',
                'code' => 'ZM',
                'rate' => 16,
            ],
            [
                'country' => 'Zimbabwe',
                'code' => 'ZW',
                'rate' => 15,
            ],
        ];

        VatRate::insert($entries);
    }
}
