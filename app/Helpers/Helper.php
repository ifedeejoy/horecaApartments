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
    
    function readableNumber(int $n)
    {
        if ($n >= 0 && $n < 1000):
            $n_format = floor($n);
            $suffix = '';
        elseif ($n >= 1000 && $n < 1000000):
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        elseif ($n >= 1000000 && $n < 1000000000):
            // 1m-999m
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        elseif ($n >= 1000000000 && $n < 1000000000000):
            // 1b-999b
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        elseif ($n >= 1000000000000):
            // 1t+
            $n_format = floor($n / 1000000000000);
            $suffix = 'T+';
        endif;
        return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    }
