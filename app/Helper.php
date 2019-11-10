<?php
if(!function_exists('encryption')){
    function encryption($password){
        return md5(sha1($password.'whjfgkjwherkgjhkh2736'));
    }
}

if(!function_exists('template_path')){
    function template_path($plate){
        return "/static/{$plate}/";
    }
}