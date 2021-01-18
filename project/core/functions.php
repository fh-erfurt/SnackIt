<?php 

namespace dwp\core;

public function containsNullValue($input)
{
    $test=true;

    foreach $element of $input{
        if($element==NULL)
        {
            $test=false;
        }
    }

    return $test;
}
