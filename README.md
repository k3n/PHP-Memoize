PHP Memoize
==============

Userland implementation written in PHP 5.4, but easily downgraded to 5.3 (by removing both `callable` type hints).

[Wikipedia: Memoization](http://en.wikipedia.org/wiki/Memoization)

------
function **memoize** ( callable _$fnOrig_, callable _$fnHash_ )
------

The first argument is your function to optimize.

The second argument is your hashing function, which will receive a single argument -- an array representing the parameters. Your hash function should return a value that can safely be used an array key.

Both arguments will be invoked as the first argument to [call_user_func()](http://php.net/manual/en/function.call-user-func.php).

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
$fact = memoize('factorial', function($args) {
    return $args[0];
});
$i = pow(10, 4);
while (--$i) {
    $fact(10);
}
```

Here, **11** invocations of `factorial()`.

------

### Variations

This function is extremely flexible:

```php
$fact = memoize('factorial', 'your_hasher');
```

```php
$fact = memoize('math::factorial', 'lib::hash');
```

```php
$apiGetUserData = memoize(
    [new Api, 'getUserData'],
    [new Hasher, 'hashUserData']
);
```

```php
$Logger = new Logger;
$toJson = memoize(function ($user, $action) use ($Logger) {
    $Logger->warn('cache miss');
    return json_encode(['user' => $user, 'action' => $action]);
}, function ($args) use ($Logger) {
    $Logger->info('cache lookup');
    return vsprintf("%d:%s", $args);
});
```