<?php 

namespace dwp\core;

 function containsNullValue($input)
{
    $test=false;

    foreach ($input as $element){
        if($element==NULL)
        {
            $test=true;
        }
    }

    return $test;
}
