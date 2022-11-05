<?php
/**
 * Created by PhpStorm.
 * User: Tannv
 * Date: 2019-06-30
 * Time: 09:48
 */
if (! function_exists('old_blade')) {

    function old_blade($key = null, $default = null)
    {
        $data = config('helper.data_edit');
        if(empty($default) || (!empty($data) && $data->editMode)){
            $default = optional($data)->$key;
        }
        return app('request')->old($key, $default);
    }
}
if (! function_exists('set_old')) {

    function set_old($data = null)
    {
        $data->editMode = true;
        config(['helper.data_edit' => $data]);
    }
}

if (! function_exists('myAsset')) {
    function myAsset(string $path=''): string {
        $urlAsset = asset($path);
        $parse = parse_url($urlAsset);
        $parse['host'] = config('lapvip.host');
        
        $urlParseOutput = sprintf('%s://%s%s', $parse['scheme'], $parse['host'], $parse['path']);
        return $urlParseOutput;
    }
}