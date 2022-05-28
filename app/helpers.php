<?php
/**
 * Created by Ahmed Maher Halima.
 * Email: phpcodertop@gmail.com
 * github: https://github.com/phpcodertop
 * Date: 5/15/2022
 * Time: 3:03 AM
 */

/**
 * @param $input
 * @return mixed|null
 * checks if input value is undefined "From Javascript side"
 */
function isUndefined($input)
{
    if ($input == 'undefined' || empty($input)) return '';
    return $input;
}
