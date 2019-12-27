<?php

if(!function_exists('aurl')){
    function aurl($url = null){
        return url('admin/' . $url);
    }
}

if(!function_exists('uploads')){
    function uploads($url = null){
        return url("uploads/" . $url);
    }
}
