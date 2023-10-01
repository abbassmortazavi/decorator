<?php
namespace App\Infrastructure\Validator;

class CustomValidator
{
    /**
     * without spaces
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function mobile($attribute, $value, $parameters, $validator): bool
    {
        if (preg_match('/^09\d{9}$/', $value)) {
            return true;
        }

        return false;
    }

    /**
     * without spaces
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function withoutSpaces($attribute, $value, $parameters, $validator): bool
    {
        if (preg_match('/^\S*$/u', $value)) {
            return true;
        }

        return false;
    }

    /**
     * Validate Password Strength level
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function isStrengthPassword($attribute, $value, $parameters, $validator): bool
    {
        if (preg_match('/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $value)) {
            return true;
        }

        return false;
    }

    /**
     * Validate Iran Billing Ids
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function isBillingId($attribute, $value, $parameters, $validator): bool
    {
        $factor             = 2;
        $computedCheckDigit = 0;
        $code               = $value;
        $givenCheckDigit    = substr($code, -1);

        for ($i = strlen($code) - 2 ; $i >= 0; --$i,++$digit) {
            $digit = $code[$i];
            $computedCheckDigit += $digit * $factor;
            $factor = ($factor == 7) ? 2 : ++$factor;
        }

        $computedCheckDigit %= 11;
        $computedCheckDigit = ($computedCheckDigit <= 1) ? 0 : 11 - $computedCheckDigit;
        return ($computedCheckDigit == $givenCheckDigit);
    }

    /**
     * Validate Iran Shetab Card Numbers
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function isDebitCard($attribute, $value, $parameters, $validator): bool
    {
        if (empty($value) || !is_numeric($value)) {
            return false;
        }

        settype($value, 'string');

        if (preg_match('/^(627353|505801)/', $value)) {
            if (strlen($value) != 16) {
                return false;
            }
        } else {
            $sumTable = [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                [0, 2, 4, 6, 8, 1, 3, 5, 7, 9]];
            $sum      = 0;
            $flip     = 0;

            for ($i = strlen($value) - 1; $i >= 0; $i--) {
                $sum += $sumTable[$flip++ & 0x1][$value[$i]];
            }

            if (!($sum % 10 === 0)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $attribute
     * @param $card_number
     * @param $parameters
     * @return bool
     */
    public function isDebitCardOther($attribute, $card_number, $parameters): bool
    {
        $card_length = strlen($card_number);
        if ($card_length < 16 || substr($card_number, 1, 10) == 0 || substr($card_number, 10, 6) == 0) {
            return false;
        }

        $banks_names = [
            'bmi'           => '603799',
            'banksepah'     => '589210',
            'edbi'          => '627648',
            'bim'           => '627961',
            'bki'           => '603770',
            'bank-maskan'   => '628023',
            'postbank'      => '627760',
            'ttbank'        => '502908',
            'enbank'        => '627412',
            'parsian-bank'  => '622106',
            'bpi'           => '502229',
            'karafarinbank' => '627488',
            'sb24'          => '621986',
            'sinabank'      => '639346',
            'sbank'         => '639607',
            'shahr-bank'    => '502806',
            'bank-day'      => '502938',
            'bsi'           => '603769',
            'bankmellat'    => '610433',
            'tejaratbank'   => '627353',
            'refah-bank'    => '589463',
            'ansarbank'     => '627381',
            'mebank'        => '639370',
        ];

        if (isset($parameters[0]) && (!isset($banks_names[$parameters[0]]) || substr($card_number, 0, 6) != $banks_names[$parameters[0]])) {
            return false;
        }

        $c = (int) substr($card_number, 15, 1);
        $s = 0;
        $k = null;
        $d = null;
        for ($i = 0; $i < 16; $i++) {
            $k = ($i % 2 == 0) ? 2 : 1;
            $d = (int) substr($card_number, $i, 1) * $k;
            $s += ($d > 9) ? $d - 9 : $d;
        }

        return (($s % 10) == 0);
    }

    /**
     * Validate UUID format
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function isUuid($attribute, $value, $parameters, $validator): bool
    {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $value) === 1;
    }

    /**
     * validating Iranian national id code
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function isIndividualNationalId($attribute, $value, $parameters, $validator): bool
    {
        if (!preg_match('/^[0-9]{10}$/', $value)) {
            return false;
        }
        for ($i=0;$i < 10;$i++) {
            if (preg_match('/^'.$i.'{10}$/', $value)) {
                return false;
            }
        }
        for ($i=0,$sum=0;$i < 9;$i++) {
            $sum += ((10 - $i) * intval(substr($value, $i, 1)));
        }
        $ret   =$sum % 11;
        $parity=intval(substr($value, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity)) {
            return true;
        }
        return false;
    }

    /**
     * Check weather is valid domain
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function isValidSubdomain($attribute, $value): bool
    {
        $reserved = [
                'www', 'admin', 'administrator', 'blog', 'dashboard', 'admindashboard',
                'assets', 'assets1', 'assets2', 'assets3', 'assets4', 'assets5',
                'images', 'img', 'files', 'videos', 'help', 'support', 'cname', 'test',
                'cache', 'api', 'api1', 'api2', 'api3', 'js', 'css', 'static', 'mail',
                'ftp', 'webmail', 'webdisk', 'ns', 'ns1', 'ns2', 'ns3', 'ns4', 'ns5',
                'register', 'pop', 'pop3', 'beta', 'stage', 'http', 'https', 'donate',
                'store', 'payment', 'payments', 'smtp', 'ad', 'admanager', 'ads',
                'adsense', 'adwords', 'about', 'abuse', 'affiliate', 'affiliates',
                'shop', 'client', 'clients', 'code', 'community', 'buy', 'cpanel',
                'whm', 'dev', 'developer', 'developers', 'docs', 'email', 'whois',
                'signup', 'gettingstarted', 'home', 'invoice', 'invoices', 'ios',
                'ipad', 'iphone', 'log', 'logs', 'my', 'status', 'network', 'networks',
                'new', 'newsite', 'news', 'partner', 'partners', 'partnerpage', 'popular',
                'wiki', 'redirect', 'random', 'public', 'registration', 'resolver', 'rss',
                'sandbox', 'search', 'server', 'servers', 'service', 'signin', 'signup',
                'sitemap', 'sitenews', 'sites', 'sms', 'sorry', 'ssl', 'staging',
                'development', 'stats', 'statistics', 'graph', 'graphs', 'survey',
                'surveys', 'talk', 'trac', 'git', 'svn', 'translate', 'upload', 'uploads',
                'video', 'validation', 'validations', 'email', 'webmaster', 'ww', 'wwww',
                'www1', 'www2', 'feeds', 'secure', 'demo', 'i', 'img', 'img1', 'img2',
                'img3', 'css1', 'css2', 'css3', 'js', 'js1', 'js2', 'billing',
                'calendar', 'forum', 'imap', 'login', 'manage', 'mx', 'pages', 'press',
                'videos', 'kb', 'knowledgebase',
        ];

        if (!preg_match('/^[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?$/', $value)) {
            return false;
        }
        if (in_array($value, $reserved)) {
            return false;
        }
        return true;
    }

    /**
     *
     * Validate Iranian Postal Code
     *
     * @param $attribute
     * @param $code
     * @param $parameters
     * @return bool
     */
    public function isPostalCode($attribute, $code, $parameters): bool
    {
        return (bool) preg_match('/^([13456789]{10})$/', $code);
    }

    /**
     *
     * Validate Iranian Alphabets
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function isPersianAlphabets($attribute, $value, $parameters): bool
    {
        if (empty($value)) {
            return true;
        }

        return (bool) preg_match("/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u", $value);
        //return (bool) preg_match('/^[^\x{600}-\x{6FF}]+$/u', str_replace("\\\\","",$value));
        //return (bool) preg_match('/^([0-9 پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ])+$/u', $input);
    }

    /**
     *
     * Validate Iranian Alphabet and Numbers
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function isPersianAlphabetsNumbers($attribute, $value, $parameters): bool
    {
        if (empty($value)) {
            return true;
        }

        return (bool) preg_match('/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u', $value);
    }
}
