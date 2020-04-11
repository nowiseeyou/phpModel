### PHP常用函数（F(x)） ###

- array_filter()  — 用回调函数过滤数组中的单元（非false情况下返回对应值）
- strtoupper()	— 转大写
- strtolower() — 转小写
- stripslashes() — 反引用一个引用字符串
- mb_strstr — 查找字符串在另一个字符串里的首次出现 返回查找字符开始到最后的字符
- range — 根据范围创建数组，包含指定的元素


#### PHP Filter 函数 ####

1. filter_has_var() — 检查是否存在指定输入类型的变量。
2. filter_id()	— 返回指定过滤器的 ID 号。
3. filter_input_array()  — 从脚本外部获取多项输入，并进行过滤。
4. filter_list() — 	返回包含所有得到支持的过滤器的一个数组。
5. filter_var_array() — 获取多个变量，并进行过滤。
6. filter_var() — 获取一个变量，并进行过滤。
7. array_unique — 移除数组中重复的值。
8. array_merge_recursive — 递归地合并一个或多个数组
9. array_key_exists — 检查数组里是否有指定的键名或索引
10. array_key_first — Gets the first key of an array
11. array_key_last — Gets the last key of an array
12. array_product — 计算数组中所有值的乘积
13. array_change_key_case — 将数组中的所有键名修改为全大写或小写
14. array_fill — 用给定的值填充数组
15. array_key_exists — 检查数组里是否有指定的键名或索引
16. array_count_values — 统计数组中所有的值
17. array_intersect_assoc — 带索引检查计算数组的交集
18. array_flip — 交换数组中的键和值
----------

- bccomp — 比较两个任意精度的数字 返回 int。
- bcsub — 2个任意精度数字的减法。
- array_key_exists — 检查数组里是否有指定的键名或索引 bool
- array_shift — 将数组开头的单元移出数组
- http_build_query — 生成 URL-encode 之后的请求字符串
- parse_str — 将字符串解析成多个变量
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
- list — 把数组中的值赋给一组变量

### 多维数组处理  ###
     https://www.awaimai.com/2064.html 

### PHP指针操作 ###
- end() - 将数组的内部指针指向最后一个单元
- key() - 从关联数组中取得键名
- each() - 返回数组中当前的键／值对并将数组指针向前移动一步
- prev() - 将数组的内部指针倒回一位
- reset() - 将数组的内部指针指向第一个单元
- next() - 将数组中的内部指针向前移动一位

