<?php
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;

    function setActive($path, $active = 'active') 
    {
        return call_user_func_array('Request::is', (array)$path) ? $active : '';
    }

    function removeCommas(string $number)
    {
        $remove = str_replace(",", "", $number);
        return $remove;
    }

    function validateJson($data)
    {

        if(is_numeric($data)): return false; endif;
        if(is_array($data)): return false; endif;
        if(is_string($data)):
            json_decode($data);
            if(json_last_error() == 0):
                return false;
            else:
                return true;
            endif;
        endif;
    }

