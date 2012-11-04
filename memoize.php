<?php
/**
 * Wrap an existing function or method with a memoization implementation.
 *
 * @version PHP 5.3 for anonymous function support (required)
 * @version PHP 5.4 for callable type-hint support (optional)
 *
 * @param callable $fnOrig function to optimize
 * @param callable $fnHash function to generate the hash
 * @return function
 */
function memoize(callable $fnOrig, callable $fnHash) {
    return function() use ($fnOrig, $fnHash) {
        static $hash = array();
        $args = func_get_args();
        $key = call_user_func($fnHash, $args);
        if (!array_key_exists($key, $hash)) {
            $hash[$key] = call_user_func_array($fnOrig, $args);
        }
        return $hash[$key];
    };
}