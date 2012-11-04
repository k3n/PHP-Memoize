PHP Memoize
==============

Userland implementation written in PHP 5.4, but easily downgraded to 5.3 (by removing both `callable` type hints).

[Wikipedia: Memoization](http://en.wikipedia.org/wiki/Memoization)

------
function **memoize** ( callable _$fnOrig_, callable _$fnHash_ )
------

The first argument is your function to that you want to optimize.

The second argument is your hashing function, which will receive a single argument -- an array representing the parameters. Your hash function should return a value that can safely be used an array key.

------

### Demo

We will use this simple factorial function to demonstrate the reduction in required invocations:

```php
function factorial($n) {
    if ($n == 0) return 1;
    return factorial($n - 1);
}
```

### First, the long way

```php
$i = pow(10, 4);
while (--$i) {
    factorial(10);
}
```

This requires **109989** invocations of `factorial()`.

### Now, memoized
    
```php
$fact = memoize('factorial', function($args){
    return $args[0];
});
$i = pow(10, 4);
while (--$i) {
    $fact(10);
}
```

Here, **11** invocations of `factorial()`.