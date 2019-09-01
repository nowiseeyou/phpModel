# PHP cookie #

cookie常用识别用户。

cookie 常用于识别用户。Cookie是一种服务器留在用户计算机上的小文件。每当同一台计算机通过浏览器请求页面时，这台计算机将会发送cookie。通过PHP，你能够创建并取回 cookie 的值。



# PHP session #

PHP session变量用于存储关于用户会话（session）的信息，或者更改用户会话（session）的设置，session变量存储单一用户信息，并且对于应用程序中的所有页面都是可用的。

## session变量 ##

你在计算机上操作某个应用程序时，你在打开她，做些更改，然后关闭她。很像一次对话（session）。计算机知道你是谁，她清楚您在何时打开和关闭应用程序，然而，在因特网上问题出现了：由于HTTP地址无法保持状态，Web服务器并不知道你是谁以及你做了什么。

PHP session 解决了这个问题，他通过在服务器上存储用户信息以便随后使用（比如用户名称，购买商品等）。然而，回话信息是临时的，在用户离开网站后将被删除，如果你要永久存储信息，可以吧数据存储在数据库中。

session 的工作机制是：为每个访客创建为一个唯一的id(UID),并基于这个UID来存储变量，UID存储在 cookie 中，或者通过URL 进行传导。

例：
	<?php
    	session_start()
		//存储 session 的数据
		$_SESSION['view'] = 1;

		//取出 session 数据
		$_SESSION['view'];

		//销毁
		unset($_SESSION['view']);
		//彻底销毁session		
		session_destory();


		