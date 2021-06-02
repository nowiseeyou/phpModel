## Hash 函数 ##

- hash_algos — 返回已注册哈希算法列表
- hash_copy — 拷贝哈希运行上下文
- hash_equals — 可防止时序攻击的字符串比较
- hash_file — 使用给定文件的内容生成哈希值
- hash_hkdf — 生成提供的密钥输入的HKDF密钥派生
- hash_hmac_algos — 返回适用于hash_hmac的已注册哈希算法列表
- hash_hmac_file — 使用 HMAC 方法给定 文件的内容生成带秘钥的哈希值
- hash_init — 初始化增量哈希运算上下文
- hash_pbkdf2 — 生成所提供密码的 PBKDF2 秘钥导出
- hash_update_file — 从文件向活跃的哈希运算上下文中填充数据
- hash_update_stream — 从打开的流向活跃的哈希运算上下文中填充数据
- hash — 生成哈希值