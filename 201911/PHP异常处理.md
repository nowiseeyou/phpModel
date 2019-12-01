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
		function checkNum($num){
			if($number > 1){
				throw new Exception("变量值必须小于等于 1")；
			}
			return true；
		}
	
		try {
			checkNum(2);
			//如果抛出异常，以下文本不会输出
			echo "如果输出该内容，说明 $number 变量";
				
		}catch(Exception $e){ //捕获异常
			echo "Message:".$e->getMessage();
		}

上面代码将得到类似这样一个错误：
    
    Message:变量必须小于等于 1

#### 实例解释: ####

上面的代码抛出了一个异常，并捕获了它：
 
1. 创建 checkNum() 函数。它检测数字是否大于 1。如果是，则抛出一个异常。
2. 在 'try' 代码块中调用 checkNum() 函数。
3.  checkNum() 函数中的异常被抛出。
4.  "catch" 代码块接收到该异常，并创建一个包含异常信息的对象（$e）。
5.  通过从这个 exception 对象调用 $e->getMessage() , 输出来自该异常的错误信息。

然而，为了遵循 "每个 throw 必须对应一个 catch" 的原则，可以设置一个顶层的异常处理器来处理漏洞的错误。

### 创建一个自定义的 Exception 类 ###

创建自定义的异常处理程序非常简单。我们简单的创建了一个专门的类，当PHP中发生异常时，可调用其函数。该类必须是 exception 类的一个扩展。

这个自定义的 customException 类继承了 PHP 的 exception 类的所有属性，您可向其添加自定义的函数。

我们开始创建 customException 类：

    <?php
	class customException extends Exception{
		public function errorMessage(){
			//错误信息
			$errorMsg = . '错误行号' . $this->getLine() . ' in ' .$this->getFile() . '<b>' . $this->getMessage() . '</b> 不是一个合法的 E-Mail 地址'；
			return $errorMsg;
		}

	}

	$email = "someone@example...com";

	try{
		//检测邮箱
		if(filter_var($email,FILTER_VARIDATE_EMAIL) === false){
			//如果是个不合法的邮箱地址，抛出异常
			throw new customException($email);
		}
	}catch(customException $e){
		//display custom message
		echo $e->errorMessage();
	}
	


	
 


