#### PHP Filter 函数 ####

1. filter_has_var() — 检查是否存在指定输入类型的变量。
2. filter_id()	— 返回指定过滤器的 ID 号。
3. filter_input_array()  — 从脚本外部获取多项输入，并进行过滤。
4. filter_list() — 	返回包含所有得到支持的过滤器的一个数组。
5. filter_var_array() — 获取多个变量，并进行过滤。
6. filter_var() — 获取一个变量，并进行过滤。
7. filter_input — 获取一个输入变量，并对其进行过滤。


#### Array ####
- array_filter()  — 用回调函数过滤数组中的单元（非false情况下返回对应值）
- range — 根据范围创建数组，包含指定的元素
- array_unique — 移除数组中重复的值。
- array_merge_recursive — 递归地合并一个或多个数组
- array_key_exists — 检查数组里是否有指定的键名或索引
- array_key_first — Gets the first key of an array
- array_key_last — Gets the last key of an array
- array_product — 计算数组中所有值的乘积
- array_change_key_case — 将数组中的所有键名修改为全大写或小写
- array_fill — 用给定的值填充数组
- array_key_exists — 检查数组里是否有指定的键名或索引
- array_count_values — 统计数组中所有的值
- array_intersect_assoc — 带索引检查计算数组的交集
- array_flip — 交换数组中的键和值
- array_combine — 创建一个数组，用一个数组的值作为键名，另一个数组的值作为其值
- array_key_exists — 检查数组里是否有指定的键名或索引 bool
- array_shift — 将数组开头的单元移出数组
- array_merge() — 函数把一个或多个数组合并为一个数组。**注：**如果两个或更多个数组元素有相同的键名，则最后的元素会覆盖其他元素
- array_column — 返回数组中指定的一列
- array_unshift — 在数组开头插入一个或多个单元
- array_shift() - 将数组开头的单元移出数组
- array_push() - 将一个或多个单元压入数组的末尾（入栈）
- array_pop() - 弹出数组最后一个单元（出栈）
- preg_replace — 执行一个正则表达式的搜索和替换
- array_map — 为数组的每个元素应用回调函数
- array_walk — 使用用户自定义函数对数组中的每个元素做回调处理
- array_unique — 移除数组中重复的值
- array_rand _ 从数组中取出一个或多个随机键
- list — 把数组中的值赋给一组变量
- ksort — 对数组按照键名正向排序
- krsort — 对数组按照键名逆向排序
- get_object_vars — 返回由对象属性组成的关联数组
- array_diff — 比较两个（或更多个）数组的值，并返回差集
- array_intersect() 函数用于比较两个（或更多个）数组的键值，并返回交集


### 多维数组处理  ###

     https://www.awaimai.com/2064.html 

### PHP指针操作 ###
- end() - 将数组的内部指针指向最后一个单元
- key() - 从关联数组中取得键名
- each() - 返回数组中当前的键／值对并将数组指针向前移动一步
- prev() - 将数组的内部指针倒回一位
- reset() - 将数组的内部指针指向第一个单元
- next() - 将数组中的内部指针向前移动一位

### 字符串函数（string） ###

- implode — 将一个一维数组的值转化为字符串
- explode — 使用一个字符串分割另一个字符串
- stripos — 查找字符串首次出现的位置（不区分大小写）
- bin2hex — 函数把包含数据的二进制字符串转换为十六进制值
- hex2bin — 转换十六进制字符串为二进制字符串
- strlen — 获取字符串长度
- str_shuffle — 随机打乱一个字符串
- htmlspecialchars_decode — 将特殊的 HTML 实体转换回普通字符
- htmlspecialchars — 将特殊字符转换为 HTML 实体
- str_repeat — 重复一个字符串
- strip_tags — 从字符串中去除 HTML 和 PHP 标记
- str_word_count — 返回字符串中单词的使用情况
- strtolower — 将字符串转化为小写
- strtouper — 将字符串转化为答谢
- str_split — 将字符串转换为数组
- strtoupper()	— 转大写
- strtolower() — 转小写
- stripslashes() — 反引用一个引用字符串
- chr() — 返回指定的字符 （与 ord() 互补）
- ord() — 转换一个字符串第一个字节为 0-255 之间的值
- stripslashes() — 反引用一个引用字符串
- mb_strstr — 查找字符串在另一个字符串里的首次出现 返回查找字符开始到最后的字符


### 程序控制 ###

- goto

### 程序执行函数 ###

- shell_exec(string $cmd) :string ： 通过shell 环境执行命令。并且将完整的输出以字符串的方式返回。
- instanceof 用于确定一个 PHP 变量是否属于某一类 class 的实例。
- declare 结构用来设定一段代码的执行指令 （暂时没搞懂）
- get_loaded_extensions() — 返回所有编译并加载模块名的 array


### 函数处理 函数 ###

- call_user_func — 把第一个参数作为回调函数调用。

### PHP 选项/信息 函数 ###

- get_defined_constants — 返回所有常量的关联数组，键是常量名，值是常量值


		# 设置应该报告何种PHP 错误
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


### 密码散列算法 ###

- password_get_info : 返回指定散列（hash）的相关信息
- password_hash : 创建密码的散列（hash）
- password_need_rehash :检测散列值是否匹配指定的选项
- password_verify : 验证密码是否和散列值匹配