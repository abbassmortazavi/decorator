<?php


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('base_is_mobile')) {
    /**
     * @return false|int
     */
    function base_is_mobile(): bool|int
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT']);
    }
}

if (!function_exists('base_i18n_set_name')) {
    /**
     * if language is farsi or arabic file should be with .rtl
     *
     * @param $fileName
     * @param null $locale
     * @return mixed
     */
    function base_i18n_set_name($fileName, $locale = null): mixed
    {
        $locale = is_null($locale) ? App::getLocale() : $locale;

        if ($locale == 'fa' || $locale == 'ar') {
            $array = explode('.', $fileName);
            $ext = @end($array);

            if (strlen($ext) > 3) {
                return $fileName;
            }

            if (!str_contains($fileName, '.')) {
                return $fileName;
            }

            if (str_contains($fileName, '.min.')) {
                return str_replace('.min.', '.rtl.min.', $fileName);
            } else {
                return str_replace('.' . $ext, '.rtl.' . $ext, $fileName);
            }
        }

        return $fileName;
    }
}

if (!function_exists('base_i18n_persian_optimize')) {
    /**
     * tart Convert (e) Arabic 2 (e) Standard Persian
     * @param $text
     * @return mixed|string
     */
    function base_i18n_persian_optimize($text): string
    {
        $text = str_replace('&#1740;', 'ی', $text);
        $text = str_replace('ك', 'ک', $text);
        $text = str_replace('ي', 'ی', $text);     //new!!!
        $text = str_replace('&#65265; ', 'ى ', $text);
        $text = str_replace('&#65266; ', 'ى ', $text);
        $text = str_replace('\"', '"', $text);

        $from = $to = [];
        $from[] = ['؆', '؇', '؈', '؉', '؊', '؍', '؎', 'ؐ', 'ؑ', 'ؒ', 'ؓ', 'ؔ', 'ؕ',
            'ؖ', 'ؘ', 'ؙ', 'ؚ', '؞', 'ٖ', 'ٗ', '٘', 'ٙ', 'ٚ', 'ٛ', 'ٜ', 'ٝ', 'ٞ', 'ٟ', '٪',
            '٬', '٭', 'ہ', 'ۂ', 'ۃ', '۔', 'ۖ', 'ۗ', 'ۘ', 'ۙ', 'ۚ', 'ۛ', 'ۜ', '۞', '۟', '۠',
            'ۡ', 'ۢ', 'ۣ', 'ۤ', 'ۥ', 'ۦ', 'ۧ', 'ۨ', '۩', '۪', '۫', '۬', 'ۭ', 'ۮ', 'ۯ', 'ﮧ',
            '﮲', '﮳', '﮴', '﮵', '﮶', '﮷', '﮸', '﮹', '﮺', '﮻', '﮼', '﮽', '﮾', '﮿', '﯀', '﯁', 'ﱞ',
            'ﱟ', 'ﱠ', 'ﱡ', 'ﱢ', 'ﱣ', 'ﹰ', 'ﹱ', 'ﹲ', 'ﹳ', 'ﹴ', 'ﹶ', 'ﹷ', 'ﹸ', 'ﹹ', 'ﹺ', 'ﹻ', 'ﹼ', 'ﹽ',
            'ﹾ', 'ﹿ',];
        $to[] = '';
        $from[] = ['أ', 'إ', 'ٱ', 'ٲ', 'ٳ', 'ٵ', 'ݳ', 'ݴ', 'ﭐ', 'ﭑ', 'ﺃ', 'ﺄ', 'ﺇ', 'ﺈ',
            'ﺍ', 'ﺎ', '𞺀', 'ﴼ', 'ﴽ', '𞸀',];
        $to[] = 'ا';
        $from[] = ['ٮ', 'ݕ', 'ݖ', 'ﭒ', 'ﭓ', 'ﭔ', 'ﭕ', 'ﺏ', 'ﺐ', 'ﺑ', 'ﺒ', '𞸁', '𞸜',
            '𞸡', '𞹡', '𞹼', '𞺁', '𞺡',];
        $to[] = 'ب';
        $from[] = ['ڀ', 'ݐ', 'ݔ', 'ﭖ', 'ﭗ', 'ﭘ', 'ﭙ', 'ﭚ', 'ﭛ', 'ﭜ', 'ﭝ'];
        $to[] = 'پ';
        $from[] = ['ٹ', 'ٺ', 'ٻ', 'ټ', 'ݓ', 'ﭞ', 'ﭟ', 'ﭠ', 'ﭡ', 'ﭢ', 'ﭣ', 'ﭤ', 'ﭥ',
            'ﭦ', 'ﭧ', 'ﭨ', 'ﭩ', 'ﺕ', 'ﺖ', 'ﺗ', 'ﺘ', '𞸕', '𞸵', '𞹵', '𞺕', '𞺵',];
        $to[] = 'ت';
        $from[] = ['ٽ', 'ٿ', 'ݑ', 'ﺙ', 'ﺚ', 'ﺛ', 'ﺜ', '𞸖', '𞸶', '𞹶', '𞺖', '𞺶'];
        $to[] = 'ث';
        $from[] = ['ڃ', 'ڄ', 'ﭲ', 'ﭳ', 'ﭴ', 'ﭵ', 'ﭶ', 'ﭷ', 'ﭸ', 'ﭹ', 'ﺝ', 'ﺞ', 'ﺟ',
            'ﺠ', '𞸂', '𞸢', '𞹂', '𞹢', '𞺂', '𞺢',];
        $to[] = 'ج';
        $from[] = ['ڇ', 'ڿ', 'ݘ', 'ﭺ', 'ﭻ', 'ﭼ', 'ﭽ', 'ﭾ', 'ﭿ', 'ﮀ', 'ﮁ',
            '𞸃', '𞺃',];
        $to[] = 'چ';
        $from[] = ['ځ', 'ݮ', 'ݯ', 'ݲ', 'ݼ', 'ﺡ', 'ﺢ', 'ﺣ', 'ﺤ', '𞸇', '𞸧', '𞹇', '𞹧',
            '𞺇', '𞺧',];
        $to[] = 'ح';
        $from[] = ['ڂ', 'څ', 'ݗ', 'ﺥ', 'ﺦ', 'ﺧ', 'ﺨ', '𞸗', '𞸷', '𞹗', '𞹷', '𞺗', '𞺷'];
        $to[] = 'خ';
        $from[] = ['ڈ', 'ډ', 'ڊ', 'ڌ', 'ڍ', 'ڎ', 'ڏ', 'ڐ', 'ݙ', 'ݚ', 'ﺩ', 'ﺪ', '𞺣', 'ﮂ',
            'ﮃ', 'ﮈ', 'ﮉ',];
        $to[] = 'د';
        $from[] = ['ﱛ', 'ﱝ', 'ﺫ', 'ﺬ', '𞸘', '𞺘', '𞺸', 'ﮄ', 'ﮅ', 'ﮆ', 'ﮇ'];
        $to[] = 'ذ';
        $from[] = ['٫', 'ڑ', 'ڒ', 'ړ', 'ڔ', 'ڕ', 'ږ', 'ݛ', 'ݬ', 'ﮌ', 'ﮍ', 'ﱜ', 'ﺭ', 'ﺮ',
            '𞸓', '𞺓', '𞺳',];
        $to[] = 'ر';
        $from[] = ['ڗ', 'ڙ', 'ݫ', 'ݱ', 'ﺯ', 'ﺰ', '𞸆', '𞺆', '𞺦'];
        $to[] = 'ز';
        $from[] = ['ﮊ', 'ﮋ', 'ژ'];
        $to[] = 'ژ';
        $from[] = ['ښ', 'ݽ', 'ݾ', 'ﺱ', 'ﺲ', 'ﺳ', 'ﺴ', '𞸎', '𞸮', '𞹎', '𞹮', '𞺎', '𞺮'];
        $to[] = 'س';
        $from[] = ['ڛ', 'ۺ', 'ݜ', 'ݭ', 'ݰ', 'ﺵ', 'ﺶ', 'ﺷ', 'ﺸ', '𞸔', '𞸴', '𞹔', '𞹴',
            '𞺔', '𞺴',];
        $to[] = 'ش';
        $from[] = ['ڝ', 'ﺹ', 'ﺺ', 'ﺻ', 'ﺼ', '𞸑', '𞹑', '𞸱', '𞹱', '𞺑', '𞺱'];
        $to[] = 'ص';
        $from[] = ['ڞ', 'ۻ', 'ﺽ', 'ﺾ', 'ﺿ', 'ﻀ', '𞸙', '𞸹', '𞹙', '𞹹', '𞺙', '𞺹'];
        $to[] = 'ض';
        $from[] = ['ﻁ', 'ﻂ', 'ﻃ', 'ﻄ', '𞸈', '𞹨', '𞺈', '𞺨'];
        $to[] = 'ط';
        $from[] = ['ڟ', 'ﻅ', 'ﻆ', 'ﻇ', 'ﻈ', '𞸚', '𞹺', '𞺚', '𞺺'];
        $to[] = 'ظ';
        $from[] = ['؏', 'ڠ', 'ﻉ', 'ﻊ', 'ﻋ', 'ﻌ', '𞸏', '𞸯', '𞹏', '𞹯', '𞺏', '𞺯'];
        $to[] = 'ع';
        $from[] = ['ۼ', 'ݝ', 'ݞ', 'ݟ', 'ﻍ', 'ﻎ', 'ﻏ', 'ﻐ', '𞸛', '𞸻', '𞹛', '𞹻', '𞺛',
            '𞺻',];
        $to[] = 'غ';
        $from[] = ['؋', 'ڡ', 'ڢ', 'ڣ', 'ڤ', 'ڥ', 'ڦ', 'ݠ', 'ݡ', 'ﭪ', 'ﭫ', 'ﭬ', 'ﭭ',
            'ﭮ', 'ﭯ', 'ﭰ', 'ﭱ', 'ﻑ', 'ﻒ', 'ﻓ', 'ﻔ', '𞸐', '𞸞', '𞸰', '𞹰', '𞹾', '𞺐', '𞺰',];
        $to[] = 'ف';
        $from[] = ['ٯ', 'ڧ', 'ڨ', 'ﻕ', 'ﻖ', 'ﻗ', 'ﻘ', '𞸒', '𞸟', '𞸲', '𞹒', '𞹟', '𞹲',
            '𞺒', '𞺲', '؈',];
        $to[] = 'ق';
        $from[] = ['ػ', 'ؼ', 'ك', 'ڪ', 'ګ', 'ڬ', 'ڭ', 'ڮ', 'ݢ', 'ݣ', 'ݤ', 'ݿ', 'ﮎ',
            'ﮏ', 'ﮐ', 'ﮑ', 'ﯓ', 'ﯔ', 'ﯕ', 'ﯖ', 'ﻙ', 'ﻚ', 'ﻛ', 'ﻜ', '𞸊', '𞸪', '𞹪',];
        $to[] = 'ک';
        $from[] = ['ڰ', 'ڱ', 'ڲ', 'ڳ', 'ڴ', 'ﮒ', 'ﮓ', 'ﮔ', 'ﮕ', 'ﮖ', 'ﮗ', 'ﮘ', 'ﮙ', 'ﮚ',
            'ﮛ', 'ﮜ', 'ﮝ',];
        $to[] = 'گ';
        $from[] = ['ڵ', 'ڶ', 'ڷ', 'ڸ', 'ݪ', 'ﻝ', 'ﻞ', 'ﻟ', 'ﻠ', '𞸋', '𞸫', '𞹋', '𞺋',
            '𞺫',];
        $to[] = 'ل';
        $from[] = ['۾', 'ݥ', 'ݦ', 'ﻡ', 'ﻢ', 'ﻣ', 'ﻤ', '𞸌', '𞸬', '𞹬', '𞺌', '𞺬'];
        $to[] = 'م';
        $from[] = ['ڹ', 'ں', 'ڻ', 'ڼ', 'ڽ', 'ݧ', 'ݨ', 'ݩ', 'ﮞ', 'ﮟ', 'ﮠ', 'ﮡ', 'ﻥ', 'ﻦ',
            'ﻧ', 'ﻨ', '𞸍', '𞸝', '𞸭', '𞹍', '𞹝', '𞹭', '𞺍', '𞺭',];
        $to[] = 'ن';
        $from[] = ['ؤ', 'ٶ', 'ٷ', 'ۄ', 'ۅ', 'ۆ', 'ۇ', 'ۈ', 'ۉ', 'ۊ', 'ۋ', 'ۏ', 'ݸ', 'ݹ',
            'ﯗ', 'ﯘ', 'ﯙ', 'ﯚ', 'ﯛ', 'ﯜ', 'ﯝ', 'ﯞ', 'ﯟ', 'ﯠ', 'ﯡ', 'ﯢ', 'ﯣ', 'ﺅ', 'ﺆ', 'ﻭ', 'ﻮ',
            '𞸅', '𞺅', '𞺥',];
        $to[] = 'و';
        $from[] = ['ة', 'ھ', 'ۀ', 'ە', 'ۿ', 'ﮤ', 'ﮥ', 'ﮦ', 'ﮩ', 'ﮨ', 'ﮪ', 'ﮫ', 'ﮬ', 'ﮭ',
            'ﺓ', 'ﺔ', 'ﻩ', 'ﻪ', 'ﻫ', 'ﻬ', '𞸤', '𞹤', '𞺄',];
        $to[] = 'ه';
        $from[] = ['ؠ', 'ؽ', 'ؾ', 'ؿ', 'ى', 'ي', 'ٸ', 'ۍ', 'ێ', 'ې', 'ۑ', 'ے', 'ۓ',
            'ݵ', 'ݶ', 'ݷ', 'ݺ', 'ݻ', 'ﮢ', 'ﮣ', 'ﮮ', 'ﮯ', 'ﮰ', 'ﮱ', 'ﯤ', 'ﯥ', 'ﯦ', 'ﯧ', 'ﯨ',
            'ﯩ', 'ﯼ', 'ﯽ', 'ﯾ', 'ﯿ', 'ﺉ', 'ﺊ', 'ﺋ', 'ﺌ', 'ﻯ', 'ﻰ', 'ﻱ', 'ﻲ', 'ﻳ', 'ﻴ', '𞸉', '𞸩',
            '𞹉', '𞹩', '𞺉', '𞺩',];
        $to[] = 'ی';
        $from[] = ['ٴ', '۽', 'ﺀ'];
        $to[] = 'ء';
        $from[] = ['ﻵ', 'ﻶ', 'ﻷ', 'ﻸ', 'ﻹ', 'ﻺ', 'ﻻ', 'ﻼ'];
        $to[] = 'لا';
        $from[] = ['ﷲ', '﷼', 'ﷳ', 'ﷴ', 'ﷵ', 'ﷶ', 'ﷷ', 'ﷸ',
            'ﷹ', 'ﷺ', 'ﷻ',];
        $to[] = ['الله', 'ریال', 'اکبر', 'محمد', 'صلعم', 'رسول', 'علیه', 'وسلم',
            'صلی', 'صلی الله علیه وسلم', 'جل جلاله',];

        for ($i = 0; $i < count($from); $i++) {
            $text = str_replace($from[$i], $to[$i], $text);
        }

        return $text;
    }
}

if (!function_exists('base_i18n_global_to_local_url')) {

    function base_i18n_global_to_local_url($text = null)
    {
        if (is_null($text)) {
            return $text;
        }

        $storage_folder = '/image/original'; //!empty(config('filer.folder')) ? config('filer.folder') : 'storage/uploads';
        $base_url_from = url('/') . $storage_folder;
        $base_url_to = $storage_folder;
        $text = str_replace($base_url_from, $base_url_to, $text);

        return $text;
    }
}

if (!function_exists('base_i18n_local_to_global_url')) {

    /**
     * @param $text
     * @return array|mixed|string|string[]|null
     */
    function base_i18n_local_to_global_url($text = null)
    {
        if (is_null($text)) {
            return $text;
        }

        $base_url_from = $storage_folder = '/image/original'; //!empty(config('filer.folder')) ? config('filer.folder') : 'storage/uploads';
        $base_url_to = url('/') . $base_url_from;
        return str_replace($base_url_from, $base_url_to, $text);
    }
}

if (!function_exists('base_convert_numbers')) {
    /**
     * @param $string
     * @param $locale
     * @return string|array
     */
    function base_convert_numbers($string, $locale = null): string|array
    {
        $locale = is_null($locale) ? App::getLocale() : $locale;
        $invalid_array = ['&#1632;' => '0', '&#1633;' => '1', '&#1634;' => '2', '&#1635;' => '3', '&#1636;' => '4', '&#1637;' => '5', '&#1638;' => '6', '&#1639;' => '7', '&#1640;' => '8', '&#1641;' => '9'];
        $farsi_array = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        $english_array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return $locale == 'fa' ?
            str_replace($english_array, $farsi_array, $string) :
            strtr($string, ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9']);

    }
}

if (!function_exists('base_str_slug_i18n')) {
    function base_str_slug_i18n($string, $sep = '-'): string
    {
        $string = trim($string);
        $flip = $sep == '-' ? '_' : '-';
        $string = preg_replace('![' . preg_quote($flip) . ']+!u', $sep, $string);
        $string = preg_replace('![^' . preg_quote($sep) . '\pL\pN\s]+!u', '', mb_strtolower($string));
        $string = preg_replace('![' . preg_quote($sep) . '\s]+!u', $sep, $string);

        return trim($string, $sep);
    }
}

