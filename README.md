PHP Memoize
==============

[Wikipedia: Memoization](http://en.wikipedia.org/wiki/Memoization)

------

### Demo

We will use this simple factorial function to demonstrate the reduction in required invocations:

    $c = 0;
    function factorial($n) {
        global $c;
        ++$c;
        if ($n == 0) return 1;
        return $n * factorial($n - 1);
    }

The global is simply used for counting invocations.

Other benchmark code (namely, calls to `microtime()`) have been omitted.

### First, the long way

    $i = pow(10, 4);
    while (--$i) {
        $x = factorial(10);
    }

Locally, this took an average of **.032** seconds, and required **109989** invocations of `factorial()`.

### Now, memoized
    
    $i = pow(10, 4);
    $fact = memoize('factorial', function($args){
        return $args[0];
    });
    while (--$i) {
        $x = $fact(10);
    }

Locally, this took an average of **.012** seconds, and required **11** invocations of `factorial()`.