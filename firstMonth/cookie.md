# PHP cookie #

cookie常用识别用户。

cookie 常用于识别用户。Cookie是一种服务器留在用户计算机上的小文件。每当同一台计算机通过浏览器请求页面时，这台计算机将会发送cookie。通过PHP，你能够创建并取回 cookie 的值。

## 创建Cookie ##

setcookie 函数用于设置cookie

注释：setcookie() 函数必须位于 <html> 标签之前。

语法：

    setcookie(name,value,expire,path,domain);

实例：

在下面的例子中，我们将创建名为 'user' 的cookie ,并赋值 'google'。我们也规定此cookie在一小时后过期：

    <?php
		
		setcookie("user","google",time()+3600);

	?>
	//HTML 标签之前
	<html>
	....

注释：在发送cookie时， cookie的值会自动进行URL编码，在取回时进行自动解码。（为了防止URL编码，请使用 setrawcookie()取而代之）


## 如何取回Cookie的值 ##

PHP 的$_COOKIE 变量用于取回cookie的值。

在下面的实例中，我们取回名为'user'的cookie的值，并把它显示在了页面上：

    <?php
		//输出 cookie 值
		echo $_COOKIE['user'];

		//查看所有 cookie
		print_r($_COOKIE);
		
	?>

## 删除COOKIE ##

当删除cookie时，你应当使用过期日期变更为过去的时间点。

删除实例：

    <?php
		//设置cookie 过期时间为过去的 1 小时
		setcookie("user","",time()-3600)
	?>