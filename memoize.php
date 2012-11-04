<?php
/**
 * Wrap an existing function or method with a memoization implementation.
 *
 * @version PHP 5.3 for anonymous function support (required)
 * @version PHP 5.4 for callable type-hint support (optional)
 *
 * @param callable $func function to optimize
 * @param callable $hash generates a hash (string) for the lookup key
 * @param callable $hash - the function to calculate the hash;
 * @return function
 */
function memoize(callable $fnOrig, callable $fnHash) {
    return function() use ($fnOrig, $fnHash) {
        $args = func_get_args();
        $key = $fnHash($args);
        static $hash = array();
        if (!array_key_exists($key, $hash)) {
            $hash[$key] = call_user_func_array($fnOrig, $args);
        }
        return $hash[$key];
    };
}