<?php 

namespace dwp\core;

public function containsNullValue($input)
{
    $test=false;

    foreach $element of $input{
        if($element==NULL)
        {
            $test=true;
        }
    }

    return $test;
}
