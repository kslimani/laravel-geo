<?php

namespace Sk\Geo;

use Illuminate\Contracts\Config\Repository;
use NumberFormatter; // PHP intl extension

class Locale
{
    /**
     * @var array
     */
    const COUNTRY_LOCALE = [
        // AQ : Antartica has no official language
        'AC' => 'en_AC',
        'AD' => 'ca_AD',
        'AE' => 'ar_AE',
        'AF' => 'fa_AF',
        'AG' => 'en_AG',
        'AI' => 'en_AI',
        'AL' => 'sq_AL',
        'AM' => 'hy_AM',
        'AN' => 'pap_AN',
        'AO' => 'pt_AO',
        'AQ' => 'und_AQ',
        'AR' => 'es_AR',
        'AS' => 'sm_AS',
        'AT' => 'de_AT',
        'AU' => 'en_AU',
        'AW' => 'nl_AW',
        'AX' => 'sv_AX',
        'AZ' => 'az_Latn_AZ',
        'BA' => 'bs_BA',
        'BB' => 'en_BB',
        'BD' => 'bn_BD',
        'BE' => 'nl_BE',
        'BF' => 'mos_BF',
        'BG' => 'bg_BG',
        'BH' => 'ar_BH',
        'BI' => 'rn_BI',
        'BJ' => 'fr_BJ',
        'BL' => 'fr_BL',
        'BM' => 'en_BM',
        'BN' => 'ms_BN',
        'BO' => 'es_BO',
        'BQ' => 'de_BQ',
        'BR' => 'pt_BR',
        'BS' => 'en_BS',
        'BT' => 'dz_BT',
        'BV' => 'und_BV',
        'BW' => 'en_BW',
        'BY' => 'be_BY',
        'BZ' => 'en_BZ',
        'CA' => 'en_CA',
        'CC' => 'ms_CC',
        'CD' => 'sw_CD',
        'CF' => 'fr_CF',
        'CG' => 'fr_CG',
        'CH' => 'de_CH',
        'CI' => 'fr_CI',
        'CK' => 'en_CK',
        'CL' => 'es_CL',
        'CM' => 'fr_CM',
        'CN' => 'zh_Hans_CN',
        'CO' => 'es_CO',
        'CR' => 'es_CR',
        'CU' => 'es_CU',
        'CV' => 'kea_CV',
        'CW' => 'de_CW',
        'CX' => 'en_CX',
        'CY' => 'el_CY',
        'CZ' => 'cs_CZ',
        'DE' => 'de_DE',
        'DG' => 'en_DG',
        'DJ' => 'aa_DJ',
        'DK' => 'da_DK',
        'DM' => 'en_DM',
        'DO' => 'es_DO',
        'DZ' => 'ar_DZ',
        'EA' => 'es_EA',
        'EC' => 'es_EC',
        'EE' => 'et_EE',
        'EG' => 'ar_EG',
        'EH' => 'ar_EH',
        'ER' => 'ti_ER',
        'ES' => 'es_ES',
        'ET' => 'en_ET',
        'FI' => 'fi_FI',
        'FJ' => 'hi_FJ',
        'FK' => 'en_FK',
        'FM' => 'chk_FM',
        'FO' => 'fo_FO',
        'FR' => 'fr_FR',
        'GA' => 'fr_GA',
        'GB' => 'en_GB',
        'GD' => 'en_GD',
        'GE' => 'ka_GE',
        'GF' => 'fr_GF',
        'GG' => 'en_GG',
        'GH' => 'ak_GH',
        'GI' => 'en_GI',
        'GL' => 'iu_GL',
        'GM' => 'en_GM',
        'GN' => 'fr_GN',
        'GP' => 'fr_GP',
        'GQ' => 'fan_GQ',
        'GR' => 'el_GR',
        'GS' => 'und_GS',
        'GT' => 'es_GT',
        'GU' => 'en_GU',
        'GW' => 'pt_GW',
        'GY' => 'en_GY',
        'HK' => 'zh_Hant_HK',
        'HM' => 'und_HM',
        'HN' => 'es_HN',
        'HR' => 'hr_HR',
        'HT' => 'ht_HT',
        'HU' => 'hu_HU',
        'IC' => 'es_IC',
        'ID' => 'id_ID',
        'IE' => 'en_IE',
        'IL' => 'he_IL',
        'IM' => 'en_IM',
        'IN' => 'hi_IN',
        'IO' => 'und_IO',
        'IQ' => 'ar_IQ',
        'IR' => 'fa_IR',
        'IS' => 'is_IS',
        'IT' => 'it_IT',
        'JE' => 'en_JE',
        'JM' => 'en_JM',
        'JO' => 'ar_JO',
        'JP' => 'ja_JP',
        'KE' => 'en_KE',
        'KG' => 'ky_Cyrl_KG',
        'KH' => 'km_KH',
        'KI' => 'en_KI',
        'KM' => 'ar_KM',
        'KN' => 'en_KN',
        'KP' => 'ko_KP',
        'KR' => 'ko_KR',
        'KW' => 'ar_KW',
        'KY' => 'en_KY',
        'KZ' => 'ru_KZ',
        'LA' => 'lo_LA',
        'LB' => 'ar_LB',
        'LC' => 'en_LC',
        'LI' => 'de_LI',
        'LK' => 'si_LK',
        'LR' => 'en_LR',
        'LS' => 'st_LS',
        'LT' => 'lt_LT',
        'LU' => 'fr_LU',
        'LV' => 'lv_LV',
        'LY' => 'ar_LY',
        'MA' => 'ar_MA',
        'MC' => 'fr_MC',
        'MD' => 'ro_MD',
        'ME' => 'sr_Latn_ME',
        'MF' => 'fr_MF',
        'MG' => 'mg_MG',
        'MH' => 'mh_MH',
        'MK' => 'mk_MK',
        'ML' => 'bm_ML',
        'MM' => 'my_MM',
        'MN' => 'mn_Cyrl_MN',
        'MO' => 'zh_Hant_MO',
        'MP' => 'en_MP',
        'MQ' => 'fr_MQ',
        'MR' => 'ar_MR',
        'MS' => 'en_MS',
        'MT' => 'mt_MT',
        'MU' => 'mfe_MU',
        'MV' => 'dv_MV',
        'MW' => 'ny_MW',
        'MX' => 'es_MX',
        'MY' => 'ms_MY',
        'MZ' => 'pt_MZ',
        'NA' => 'kj_NA',
        'NC' => 'fr_NC',
        'NE' => 'ha_Latn_NE',
        'NF' => 'en_NF',
        'NG' => 'en_NG',
        'NI' => 'es_NI',
        'NL' => 'nl_NL',
        'NO' => 'nb_NO',
        'NP' => 'ne_NP',
        'NR' => 'en_NR',
        'NU' => 'niu_NU',
        'NZ' => 'en_NZ',
        'OM' => 'ar_OM',
        'PA' => 'es_PA',
        'PE' => 'es_PE',
        'PF' => 'fr_PF',
        'PG' => 'tpi_PG',
        'PH' => 'fil_PH',
        'PK' => 'ur_PK',
        'PL' => 'pl_PL',
        'PM' => 'fr_PM',
        'PN' => 'en_PN',
        'PR' => 'es_PR',
        'PS' => 'ar_PS',
        'PT' => 'pt_PT',
        'PW' => 'pau_PW',
        'PY' => 'gn_PY',
        'QA' => 'ar_QA',
        'RE' => 'fr_RE',
        'RO' => 'ro_RO',
        'RS' => 'sr_Cyrl_RS',
        'RU' => 'ru_RU',
        'RW' => 'rw_RW',
        'SA' => 'ar_SA',
        'SB' => 'en_SB',
        'SC' => 'en_SC',
        'SD' => 'ar_SD',
        'SE' => 'sv_SE',
        'SG' => 'en_SG',
        'SH' => 'en_SH',
        'SI' => 'sl_SI',
        'SJ' => 'nb_SJ',
        'SK' => 'sk_SK',
        'SL' => 'kri_SL',
        'SM' => 'it_SM',
        'SN' => 'fr_SN',
        'SO' => 'sw_SO',
        'SR' => 'srn_SR',
        'SS' => 'en_SS',
        'ST' => 'pt_ST',
        'SV' => 'es_SV',
        'SX' => 'de_SX',
        'SY' => 'ar_SY',
        'SZ' => 'en_SZ',
        'TA' => 'en_TA',
        'TC' => 'en_TC',
        'TD' => 'fr_TD',
        'TF' => 'und_TF',
        'TG' => 'fr_TG',
        'TH' => 'th_TH',
        'TJ' => 'tg_Cyrl_TJ',
        'TK' => 'tkl_TK',
        'TL' => 'pt_TL',
        'TM' => 'tk_TM',
        'TN' => 'ar_TN',
        'TO' => 'to_TO',
        'TR' => 'tr_TR',
        'TT' => 'en_TT',
        'TV' => 'tvl_TV',
        'TW' => 'zh_Hant_TW',
        'TZ' => 'sw_TZ',
        'UA' => 'uk_UA',
        'UG' => 'sw_UG',
        'UM' => 'en_UM',
        'US' => 'en_US',
        'UY' => 'es_UY',
        'UZ' => 'uz_Cyrl_UZ',
        'VA' => 'it_VA',
        'VC' => 'en_VC',
        'VE' => 'es_VE',
        'VG' => 'en_VG',
        'VI' => 'en_VI',
        'VN' => 'vi_VN',
        'VU' => 'bi_VU',
        'WF' => 'fr_WF',
        'WS' => 'sm_WS',
        'XK' => 'sq_XK',
        'YE' => 'ar_YE',
        'YT' => 'swb_YT',
        'ZA' => 'en_ZA',
        'ZM' => 'en_ZM',
        'ZW' => 'sn_ZW',
    ];

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var array
     */
    protected $countries;

    /**
     * @var array
     */
    protected $languages;

    /**
     * @var array
     */
    protected $currencies;

    /**
     * @var string
     */
    protected $appLocale;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @return void
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get countries with ISO 3166-1 codes.
     *
     * @param  string  $locale
     * @return array
     */
    public function countries($locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        if (! $this->countries || $this->appLocale !== $locale) {
            $this->countries = GeoList::countries(
                $locale,
                $this->config->get('app.fallback_locale')
            );

            // Filters exceptionally reserved codes
            // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Exceptional_reservations
            unset(
                $this->countries['EZ'], // Eurozone
                $this->countries['UN']  // United Nations
            );

            asort($this->countries);
            $this->appLocale = $locale;
        }

        return $this->countries;
    }

    /**
     * Get country name.
     *
     * @param  string  $code
     * @param  string  $locale
     * @return string|null
     */
    public function country($code, $locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        if (! $this->countries || $this->appLocale !== $locale) {
            $this->countries($locale);
        }

        return isset($this->countries[$code]) ? $this->countries[$code] : null;
    }

    /**
     * Get languages with ISO 639-1 codes.
     *
     * @param  string  $locale
     * @return array
     */
    public function languages($locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        if (! $this->languages || $this->appLocale !== $locale) {
            $countries = $this->countries($locale);
            $languages = GeoList::languages(
                $locale,
                $this->config->get('app.fallback_locale')
            );

            // Languages are filtered to match countries
            foreach ($countries as $code => $country) {
                if (! $countryLocale = $this->countryLocale($code)) {
                    continue;
                }
                $language = $this->localeLanguage($countryLocale);
                if (! isset($languages[$language])) {
                    continue;
                }
                $this->languages[$language] = $languages[$language];
            }

            asort($this->languages);
            $this->appLocale = $locale;
        }

        return $this->languages;
    }

    /**
     * Get language name.
     *
     * @param  string  $code
     * @param  string  $locale
     * @return string|null
     */
    public function language($code, $locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        if (! $this->languages || $this->appLocale !== $locale) {
            $this->languages($locale);
        }

        return isset($this->languages[$code]) ? $this->languages[$code] : null;
    }

    /**
     * Get currencies with ISO 4217 codes.
     *
     * @param  string  $locale
     * @return array
     */
    public function currencies($locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        if (! $this->currencies || $this->appLocale !== $locale) {
            $countries = $this->countries($locale);
            $currencies = GeoList::currencies(
                $locale,
                $this->config->get('app.fallback_locale')
            );

            // Add new Belarusian Ruble if not available
            if (! isset($currencies['BYN']) && isset($currencies['BYR'])) {
                $currencies['BYN'] = $currencies['BYR'];
            }

            // Currencies are filtered to match countries
            foreach ($countries as $code => $country) {
                if (! $countryLocale = $this->countryLocale($code)) {
                    continue;
                }
                if (! $currency = $this->localeCurrency($countryLocale)) {
                    continue;
                }
                if (! isset($currencies[$currency])) {
                    continue;
                }

                $this->currencies[$currency] = $currencies[$currency];
            }

            asort($this->currencies);
            $this->appLocale = $locale;
        }

        return $this->currencies;
    }

    /**
     * Get currency name.
     *
     * @param  string  $code
     * @param  string  $locale
     * @return string|null
     */
    public function currency($code, $locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        if (! $this->currencies || $this->appLocale !== $locale) {
            $this->currencies($locale);
        }

        return isset($this->currencies[$code]) ? $this->currencies[$code] : null;
    }

    /**
     * Get default country locale.
     *
     * @param  string  $countryCode
     * @return string|null
     */
    public function countryLocale($countryCode)
    {
        return isset(self::COUNTRY_LOCALE[$countryCode])
            ? self::COUNTRY_LOCALE[$countryCode]
            : null;
    }

    /**
     * Get language code from country code.
     *
     * @param  string  $countryCode
     * @return string|null
     */
    public function countryLanguage($countryCode)
    {
        if (! $locale = $this->countryLocale($countryCode)) {
            return null;
        }

        $language = $this->localeLanguage($locale);
        if (! $this->languages) {
            $this->languages($this->appLocale);
        }

        return isset($this->languages[$language]) ? $language : null;
    }

    /**
     * Get currency code from country code.
     *
     * @param  string  $countryCode
     * @return string|null
     */
    public function countryCurrency($countryCode)
    {
        if (! $locale = $this->countryLocale($countryCode)) {
            return null;
        }
        if (! $currency = $this->localeCurrency($locale)) {
            return null;
        }

        if (! $this->currencies) {
            $this->currencies($this->appLocale);
        }

        return isset($this->currencies[$currency]) ? $currency : null;
    }

    /**
     * Get ISO 639-1 language code.
     *
     * @param  string  $locale
     */
    protected function localeLanguage($locale)
    {
        list($language, $scriptOrCountry) = explode('_', $locale);

        return $language === 'zh' ? $language.'_'.$scriptOrCountry : $language;
    }

    /**
     * Get ISO 4217 currency code.
     *
     * @param  string  $locale
     * @return string|null
     */
    protected function localeCurrency($locale)
    {
        $currency = (new NumberFormatter($locale, NumberFormatter::CURRENCY))
            ->getTextAttribute(NumberFormatter::CURRENCY_CODE);

        // Belarusian Ruble is no longer 'BYR'
        if ($currency === 'BYR') {
            $currency = 'BYN';
        }

        return (! $currency || $currency === 'XXX') ? null : $currency;
    }
}
