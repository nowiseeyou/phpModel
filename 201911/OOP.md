## 面向对象知识（OOP） ##

### 类型运算符 instanceof ###

    <?php
	class MyClass {
		
	}

	class NotMyClass{
		
	}

	$a = new MyClass;

	var_dump($a instanceof MyClass);
	var_dump($a instanceof NotMyClass);

	
以上例程会输出：

    bool(true)
	bool(false)

instanceof 用于确定一个变量是不是某个类，继承类，接口的对象的实例。如果被检测的变量不是对象，instanceof 并不发出任何错误信息 而是返回 false 。不允许用来检测常量。

### 魔术方法 __construct() ###

构造方法声明private，防止直接创建对象，这样new Singleton() 会报错

	private function __construct() {
		echo "I am constructed";
	}

### 魔术方法 __clone() ###

当类的复制完成时，如果定义了`__clone()` 方法，则新创建的对象（复制生成的对象）中的`__clone()`方法会被调用，可用于修改属性的值（如果有必要的话）。私有化 `__clone` 可以防止克隆该类的对象。**注意**：clone的对象不执行__construct里的方法。

所以我们在防止单例模式的 $singleton 对象被 clone，有两种方法：

1.设置魔术方法`__clone()`；访问权限为private;
2.若：`__clone()` 为公用方法，则在函数中加上自定义错误。

    //防止用户复制对象实例
	public function __clone() {
		trigger_error("Clone is not allowed：",E_USER_ERROR);
	}

	关于 __clone() , PHP官方的文档： 
	Once the cloing is complete, if a __clone() method is defined, then the newly created object’s __clone() method will be called, to allow any necessary properties that need to be changed.
	
	克隆完成后，如果定义了__clone（）方法，则将调用新创建的对象的__clone（）方法，以允许需要更改任何必要的属性。
	
	
### 关键字 clone 和 赋值 ###

	class foo {
		public $bar = "php";
	}

	$foo = new foo();
	
	// 标识符赋值 (把 $a 赋值为 null ， 原来的 $foo 并不会变成 null,但通过 $a 能够修改$foo 的成员 $bar)
	$a = $foo;
	// 引用复制（把 $a 赋值为 null ，原来的 $foo 也会跟着变成 null）
	$b = &$foo;
	// 值赋值（赋值后互不影响，在计算机内存上的体现属于浅复制）
	$c = clone $foo;
	

### 对象复制 ###

在PHP中，对象间的赋值操作实际上是引用操作 （实际上，绝大部分编程语言都是如此！主要原因是内存以及性能的问题），比如：

    class myclass {
		public $data;
	}

	$obj1 = new myclass();

	$obj1->data = "aaa";
	$obj2 = $obj1;
	$obj2->data = "bbb";	 	//$obj1->data 的值也会变成 "bbb"

因为obj1，obj2 都是指向同一个内存区的引用，所以修改任何一个对象都会同时修改另外一个对象。

在有的时候，我们其实不希望这种 reference 式的赋值方式，我们希望能完全赋值一个对象，这时候就需要用到 PHP中的clone（对象复制）。

    class myclass {
		public $data;
	}

	$obj1 = new myclass();
	$obj1->data = "aaa";

	$obj2 = clone $obj1;
	$obj2->data = "bbb";  //$obj->data的值仍然为 "aaa"

因为 clone 的方式实际上是对整个对象的内存区域进行了一次复制并用新的对象变量指向新的内存，因此赋值后的对象和源对象相互之间是基本来说独立的。

### 浅复制 ###

PHP 的object clone 采用了浅复制（shallow copy）的方法，如果对象里的属性成员本身就是 reference 类型的，clone以后这些成员并没有被真正的复制，仍然是引用的。（实际上，其他大部分语言也是这样实现的，如果对C++的内存，拷贝，copyconstruct等概念比较熟悉，就很容易理解这个概念），举例说明：

    class myClass {
		public $data;
	}

	$sss = "aaa";
	$obj1 = new myClass();
	$obj1->data = &$s;	//注意这里是一个 reference
	
	$obj2 = clone $obj1;
	$obj2->data = "bbb"; //这时，$obj1->data 的值变成了 "bbb" 而不是 "aaa"!

	var_dump($obj1);
	var_dump($obj2);


我们再举一个更实用的例子来说明一下PHP clone这种浅复制带来的后果：

    class testClass {
		public $str_data;
		public $obj_data;
	}

	$dateTimeObj = new DateTime("2014-07-05",new DateTimeZone('UTC'));

	$obj1 = new testClass();
	$obj->str_data = "aaa";
	$obj->obj_data = $dateTimeObj;

	$obj2 = clone $obj1;

	var_dump($obj1);	// str_data:"aaa"  obj_data:"2014-07-15 00:00:00"
	var_dump($obj2);	// str_data:"aaa"  obj_data:"2014-07-15 00:00:00"
	

	$obj2->str_data = "bbb";
	$obj2->$obj_data->add(new DateInterval('P10D'));	//给$obj2->obj_date的时间增加了10天

	var_dump($obj1); 	//str_data:"aaa"	obj_data:"2014-07-15 00:00:00"
	var_dump($obj2); 	//str_data:"bbb"	obj_data:"2014-07-15 00:00:00"
	var_dump($dateTimeObj)	//2014-07-15 00:00:00


一般来讲，你用clone来复制对象，希望吧两个对象彻底分开，不希望他们之间有任何关联，但由于 clone 的 shallow copy特性，有时候会出现非你期望的结果。

### 深复制 ###

采用PHP中的 `__clone`方法把浅复制 转换为深复制（这个方法给 C++中的 copy constructor概念类似，但执行流程不一样）

    class testClass {
		public $str_data;
		public $obj_data;
	}

	public function __clone() {
		$this->obj_data = clone $this->obj_data;
	}

	$dateTimeObj = new DateTime("2014-07-05",new DateTimeZone("UTC"));

	$obj1 = new testClass()
	$obj1->str_data = "aaa";
	$obj1->obj_data = $dateTimeObj;

	$obj2 = clone $obj1;
	var_dump($obj1);	// str_data:"aaa" obj_data:"2014-07-05 00:00:00"
	var_dump($obj2); 	// str_data:"aaa" obj_data:"2014-07-05 00:00:00"
	$obj2->str_data = "bbb";
	$obj2->obj_data->add(new DateTimeZone("P10D"));

	var_dump($obj1);			// str_data:"aaa"  obj_data:"2014-07-05 00:00:00"
	var_dump($obj2);			// str_data:"aaa"  obj_data:"2014-07-15 00:00:00"
	var_dump($dateTimeObj);		// "2014-07-05 00:00:00"



	
