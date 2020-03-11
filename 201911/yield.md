    https://segmentfault.com/a/1190000012457145

## 携程（yield） ##
	
	TODO: 暂时不知道怎么用！！！

    function getValues1() {
	    $valuesArray = [];
	    // 获取初始内存使用量
	    echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL."<br />";

	    for ($i = 1; $i <= 800000; $i++) {
	        $valuesArray[] = $i;
	        // 为了让我们能进行分析，所以我们测量一下内存使用量
	        if (($i % 200000) == 0) {
	            // 来 MB 为单位获取内存使用量
	            echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB'. PHP_EOL."<br />";
	        }
	    }
	    return $valuesArray;
	}

	$myValues = getValues1(); // 一旦我们调用函数将会在这里创建数组
	//var_dump($myValues);
	foreach ($myValues as $value) {}
	
	echo "<hr />";
	
	function getValues2() {
	    // 获取内存使用数据
	    echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL."<br />";
	    for ($i = 1; $i < 800000; $i++) {
	        yield $i;
	        // 做性能分析，因此可测量内存使用率
	        if (($i % 200000) == 0) {
	            // 内存使用以 MB 为单位
	            echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB'. PHP_EOL . "<br />";
	        }
	    }
	}

	$myValues = getValues2(); // 在循环之前都不会有动作
	
	foreach ($myValues as $value) {} // 开始生成数据
	
	echo "<br />";
	
	function gen_one_to_three()
	{
	    for ($i = 1; $i <= 3; $i++) {
	        // Note that $i is preserved between yields.
	        yield $i;
	    }
	}
	
	$generator = gen_one_to_three();
	foreach ($generator as $value) {
	    echo "$value\n";
	}

## 生成器 ##

    
	function xrange($start, $end) {
		for ($i = $start; $i <= $end; $i++){
			yield $i;
		}
	}

	foreach ( xrange(1,100000) as $num ) {
		echo $num . "<br />";
	}

**记住，一个函数中如果用了yield，他就是一个生成器，直接调用他是没有用的，不能等同于一个函数那样去执行！**
