<?php

use Illuminate\Support\Facades\File;

if (!function_exists('set_minify')) {
    /**
     * Add .min before file extension. for instance app.css would be app.min.css
     *
     * @param $fileName
     * @return mixed
     */
    function set_minify($fileName)
    {
        $debug = config('app.debug');
        if (!$debug) {
            $ext = @end(explode('.', $fileName));

            if (strlen($ext) > 3)
                return $fileName;

            if (strpos($fileName, '.') === false)
                return $fileName;

            if (strpos($fileName, '.min.') === false)
                return str_replace('.' . $ext, '.min.' . $ext, $fileName);
        }
        return $fileName;
    }
}

if (!function_exists('split_files_with_basename')) {

    /**
     * @param array $files
     * @param string $suffix
     * @return array
     */
    function split_files_with_basename(array $files, $suffix = '.php')
    {
        $result = [];
        foreach ($files as $row) {
            $baseName = basename($row, $suffix);
            $result[$baseName] = $row;
        }
        return $result;
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param $path
     * @return array
     */
    function scan_folder($path)
    {
        if (is_dir($path)) {
            return array_diff(scandir($path), ['.', '..']);
        }
        return [];
    }
}

if (!function_exists('get_folders_in_path')) {
    /**
     * @param $path
     * @return array
     */
    function get_folders_in_path($path)
    {
        if (!File::exists($path)) {
            return [];
        }
        return File::directories($path);
    }
}

if (!function_exists('get_base_folder')) {
    /**
     * @param $path
     * @return string
     */
    function get_base_folder($path)
    {
        if (is_dir($path)) {
            return $path;
        }

        $path = dirname($path);

        if (!base_ends_with('/', $path)) {
            $path .= '/';
        }

        return $path;
    }
}

if (!function_exists('get_file_name')) {
    /**
     * @param $path
     * @param null $suffix
     * @return mixed|string
     */
    function get_file_name($path, $suffix = null)
    {
        if (is_dir($path)) {
            return '';
        }

        $path = basename($path);

        if ($suffix === null) {
            return $path;
        }

        return str_replace($suffix, '', $path);
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param string $path
     * @return string
     */
    function get_file_data($path)
    {
        if (!File::exists($path) || !File::isFile($path)) {
            return null;
        }

        return File::get($path, true);
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param string $path
     * @param string|array|object $data
     * @param bool $json
     * @return bool
     */
    function save_file_data($path, $data, $json = false)
    {
        try {
            if ($json === true) {
                $data = json_encode_prettify($data);
            }
            File::put($path, $data);
            return true;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}

if (!function_exists('format_file_size')) {
    /**
     * Format the file size to bytes, KB, MB, GB, TB...
     * @param $bytes
     * @param int $precision
     * @return int|string
     */
    function format_file_size($bytes, $precision = 2)
    {
        $bytes = (int)$bytes;
        $precision = (int)$precision;

        if ($bytes > 0) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
            return number_format($bytes / pow(1024, $power), $precision, '.', ',') . ' ' . $units[$power];
        }
        return $bytes;
    }
}

if (!function_exists('get_files_download')) {
    /**
     * @param $files
     * @param $isClient
     * @return string
     */
    function get_files_download($files, $isClient = null): string
    {
        if (!empty($files)) {
            $fileLinks = '';
            foreach ($files as $file) {
                $ext = pathinfo($file['file'], PATHINFO_EXTENSION);
                if (in_array($ext, config('filer.image_extensions'), true)) {
                    $prefix = 'image/original';
                } else {
                    $prefix = 'file/display' ;
                }
                $fileUrl = url($prefix . $file['path']);
                $fileIcon = ($isClient == '1') ? 'fa-paperclip' : 'fa-download';
                $fileLinks .= ' [<a class="dialogue-download mt-2" href="' . $fileUrl . '" target="_blank"  class="m-1"><i class="far ' . $fileIcon . ' fa-1x"></i> ' . $ext . '</a>] ';
            }
            return $fileLinks;
        }
        return '';
    }
}
