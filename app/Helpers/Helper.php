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

    function multiSum($data, $key)
    {
        $sum = 0;
        if(is_array($data) || is_object($data)):
            foreach($data as $arr):
                $sum += $arr[$key];
            endforeach;
            return $sum;
        else:
            return $sum;
        endif;
    }

    function arrayOccurenceCount($data, $key)
    {
        $count = 0;
        foreach ($data as $value):
            if(is_array($value)):
                $count += arrayOccurenceCount($value, $key);
            else:
                if($value == $key):
                    $count++;
                endif;
            endif;
        endforeach;
        return $count;
    }

