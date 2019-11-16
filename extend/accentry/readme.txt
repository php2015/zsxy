※运行环境※

php7.2

第一步；打开AccEntryConfig.php文件，设置请求参数信息并保存，请求参数信息有：ipsURL、merBillNo、date、merCode、accCode、AES_KEY、SHA256_PRIVATE_KEY、SHA256_PUBLIC_KEY、successURL、s2sURL。
各个请求参数用法，见接口文档。

第二步：运行index.php文件，点击各页面请求查看各接口定义参数。

第三步：体验分账流程，看效果等。

※业务处理注意事项※

请配置submitHttpClint.php文件、callBackResult.php文件，其中，submitHttpClint.php文件主要是处理同步返回接口，callBackResult.php主要是处理异步返回接口，在注释处写入业务处理逻辑代码，请结合自身情况谨慎编写。

※说明※

本demo仅仅为学习参考使用，请根据实际情况自行开发，把功能嵌入您的项目或平台中。