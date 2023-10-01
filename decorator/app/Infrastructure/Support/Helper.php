<?php namespace App\Infrastructure\Support;

use Illuminate\Support\Facades\File;

class Helper {

    /**
     * load module helpers
     *
     * @param $dir
     */
    public static function loadModuleHelpers($dir)
    {
        $helpers = File::glob($dir . '/../Helpers/*.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }

    /**
     * load module configs
     *
     * @param $dir
     * @return array
     */
    public static function loadModuleConfig($dir): array
    {
        $files = File::glob($dir . '/../Config/*.php');
        $configs = split_files_with_basename($files);

        return ($configs);
    }

    /**
     * load module configs V2
     *
     * @param $path
     * @return array
     */
    public static function loadModuleConfigV2($path): array
    {

        $files = File::glob($path);
        $configs = split_files_with_basename($files);

        return ($configs);
    }


    /**
     * load module helpers V2
     *
     */
    public static function loadModuleHelpersV2()
    {
        $path = base_path('app/Domain/*/Helpers/*.php');

        $helpers = File::glob($path);
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }

}
