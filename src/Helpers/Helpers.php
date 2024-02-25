<?php


if(!function_exists('hasNestedArrays')){
    /**
     * Determines whether an array contains any nested arrays within its structure.
     * @param array $array
     * @return bool
     */
    function hasNestedArrays(array $array):bool {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }
}

if(!function_exists('validateDateFormat')){
    /**
     * Validate format date like YYYY-MM-DD
     * @param string $date
     * @return bool
     */
    function validateDateFormat(string $date):bool {
        return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date) == true;
    }
}