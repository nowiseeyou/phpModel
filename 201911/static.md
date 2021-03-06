## STATIC ##

### 单例模式 （Singleton Pattern） ###

顾名思义，就是只有一个实例。作为对象的创建模式，单例模式确保某一个类只有一个实例，而且自行实例化并向整个系统提供这个实例。

#### 为什么使用单例模式 ####

1.PHP语言的本身局限性

php语言是一种解释型脚本语言，这种运行机制使得每个PHP页面被解释执行后，所有的相关资源都会被回收。也就是说，PHP在语言级别上没办法让某个对象常驻内存，这和asp.NET、Java等编译型是不同的，比如在java中单例会一直存在于整个应用程序的生命周期里，变量是跨页面级的，真正可以做到这个实例在应用程序生命周期的唯一性。然而在PHP中，所有的变量无论是全局变量还是类的静态成员，都是页面级的，每次页面被执行时，都会重新建立新的对象，都会在页面执行完毕后被清空，这样似乎PHP的单例模式就没有意义了，所以PHP单例模式只是针对单次页面级请求的时出现多个应用场景并需要共享同一对象资源时非常有意义的。

2.应用场景

一个应用中会存在大量的数据库操作，比如数过数据库句柄来连接数据库的这一行为，使用单例模式以避免大量的new操作，因为每一次new 操作都会消耗内存资源和系统资源。如果系统中需要有一个类来控制某些配置信息，那么使用单例模式可以很方便的实现。

#### 要点 ####

- 一个类只能有一个对象
- 必须是自行创建这个类的对象
- 要向整个系统提供这一个对象


#### 具体实现的重点 ####

- 单例模式的类只提供私有的构造函数，
- 类定义中含有一个该类的静态私有对象，
- 该类提供了一个静态的公有的函数用于创建或获取它本身的静态私有对象。

#### 代码实现 ####

    class Singleton {
		// 存放实例，私有静态变量
		private static $_instance = null;
		
		// 私有化构造方法
		private = function __construct() {
			echo "单例模式的实例被构造了";
		}

		// 私有化克隆方法
		private function __clone() {
			
		}

		//公有化获取实例方法
		public static function getInstance() {
			// 检测 实例化对象$_instance 是否存在 不存在则实例化
			if((self::$_instance instanceof Singleton) === false) {
				self::$_instance = new Singleton();
			}
			return self::$_instance;
		}
	}

	$singleton = singleton::getInstance();