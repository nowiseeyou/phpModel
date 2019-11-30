## PHP异常处理 ##

异常用于在指定的错误发生时改变脚本的正常流程。

### 异常是什么 ###
PHP 5 提供了一种新的面向对象的错误处理方法。
异常处理用于在指定的错误（异常）情况发生时改变脚本的正常流程。这种情况称为异常。

当异常被触发时，通常会发生：
 
- 当前代码状态被保存
- 代码执行被切换到预定义（自定义）的异常处理函数
- 根据情况，处理器也许会从保存的代码状态重新开始执行代码，终止脚本执行，或从代码另外的位置继续执行脚本

我们将展示不同的错误处理方法

- 异常的基本使用
- 创建自定义的异常处理器
- 多个异常
- 重新抛出异常
- 设置顶层异常处理器

**注释：**异常应该仅仅在错误情况下使用，而不该用于在一个指定的点跳转到代码的另一个位置。

### 异常的基本使用 ###

当异常被抛出时，其后的代码不会继续执行，PHP会尝试查找匹配的 "catch" 代码块。

如果异常没有被捕获，而且又没有使用 set_exception_handler() 做相应的处理的话，那么将发生一个严重的错误（致命错误），并且输出 "Uncaught Exception"（未捕获异常）的错误信息。

让我们尝试抛出一个异常，同时不去捕获它：

    <?php
	//创建一个有异常处理的函数
	function checkNum($number){
		if($number >1){
			throw new Exception("Value must be 1 or below");
		}
		return true;
	}

	//触发异常
	checkNum(2);

上面的代码会得到类似这样的错误：

	Fatal error: Uncaught exception 'Exception' with message 'Value must be 1 or below' in /www/runoob/test/test.php:7 Stack trace: #0 /www/runoob/test/test.php(13): checkNum(2) #1 {main} thrown in /www/runoob/test/test.php on line 7
    
### try ，throw 和 catch ###

要避免上面实例中出现的错误，我们需要创建适当的代码来处理异常。

适当的处理异常代码包括：

1. Try - 使用异常的函数应该位于 "try" 代码块内。如果没有触发异常，则代码将照常继续执行。但是如果异常被触发，会抛出一个异常。
2. Throw - 里规定如何触发异常。每一个 "throw" 必须对应至少一个 "catch"。
3. Catch - "catch" 代码块会捕获异常，并创建一个包含异常信息的对象。

让我们触发一个异常：

    <?php
	//创建一个有异常处理的函数

