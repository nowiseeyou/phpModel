## RESTful ##

RESET(Representational State Transfer ,简称REST),指的是一组架构约束条件和原则。

符合REST设计风格的Web Api称为RESTful API,他从以下三个方面资源进行定义：

- 直观简短的资源地址：URL,例：http://example.com/resources/。
- 传输资源：Web服务接收与返回的互联网媒体类型，例：JSON,XML,YAM等。
- 对资源的操作：Web服务在该资源上所支持的一系列请求方法（POST，GET，PUT，DELETE）。

创建一个RESTful web service

- 创建一个RESTful Web service。
- 使用原生PHP，不依赖任何框架。
- URL模型需要遵循REST规则。
- RESTful service 接收与返回的格式可以是 JSON， XML。
- 根据不同情况相应对应的HTTP状态码。
- 演示请求头的使用。
- 使用REST 客户端来测试RESTful web service

## RESTful Webservice实例 ##

    <?php
	//RESTful 演示实例
	Class Site {
		private $sites = array(
			1=>"taobao",
			2=>"google",
			3=>"baidu",
			4=>"jd",
			5=>"sina"
		);

		public function getAllSite(){
			return $this->sites;
		}

		public function getSite(){
			$site = array($id => ($this->sites[$id]) ? $this->sites[$id] : $this->sites[1]);
		}
	}

	
