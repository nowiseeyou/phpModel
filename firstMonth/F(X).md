### PHP常用函数（F(x)） ###

- array_filter()  — 用回调函数过滤数组中的单元（非false情况下返回对应值）
- strtoupper()	— 转大写
- strtolower() — 转小写
- stripslashes() — 反引用一个引用字符串
- mb_strstr — 查找字符串在另一个字符串里的首次出现 返回查找字符开始到最后的字符
#### PHP Filter 函数 ####
1. filter_has_var() — 检查是否存在指定输入类型的变量。
2. filter_id()	— 返回指定过滤器的 ID 号。
3. filter_input_array()  — 从脚本外部获取多项输入，并进行过滤。
4. filter_list() — 	返回包含所有得到支持的过滤器的一个数组。
5. filter_var_array() — 获取多个变量，并进行过滤。
6. filter_var() — 获取一个变量，并进行过滤。

----------

- bccomp — 比较两个任意精度的数字 返回 int。
- bcsub — 2个任意精度数字的减法。
- array_key_exists — 检查数组里是否有指定的键名或索引 bool
- array_shift — 将数组开头的单元移出数组
- http_build_query — 生成 URL-encode 之后的请求字符串
- parse_str — 将字符串解析成多个变量
- array_merge() — 函数把一个或多个数组合并为一个数组。**注：**如果两个或更多个数组元素有相同的键名，则最后的元素会覆盖其他元素。