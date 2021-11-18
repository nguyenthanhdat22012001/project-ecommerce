<?php
if (!function_exists('ImgProcess')) {
    function ImageProcess($image)
    {
        $destination_path='public/images/';
        $image_name=$image->getClientOriginalName();
        $path=$image->storeAs($destination_path,$image_name);
        return $image_name;
    }
}
