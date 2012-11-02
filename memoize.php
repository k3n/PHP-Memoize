<?php
/**
 * Wrap an existing function or method with a memoization implementation.
 *
 * This is a poor-man's in-memory cache, and plays on the classic time/space
 * tradeoff whereby we are trading memory space for computation time. The more
 * use your memoized function sees, the more memory will be used; however, if
 * there are repeated function calls that will yield the same result, then we
 * end up calling the original [now-wrapped] function less frequently than if
 * it had not been memoized.
 *
 * @param callable $func - the function to optimize
 * @param callable $hash - the function to calculate the hash; it will receive a
 *                         single argument: an array representing the parameters
 *                         passed to your function. Your hash function should
 *                         return a scalar value that can safely be used as an
 *                         array key.
 * @return function
 */
function memoize(callable $func, callable $hash) {
    return function() use ($func, $hash) {
        $args = func_get_args();
        $key = $hash($args);
        static $cache = array();
        if (!array_key_exists($key, $cache)) {
            $cache[$key] = call_user_func_array($func, $args);
        }
        return $cache[$key];
    };
}
?>