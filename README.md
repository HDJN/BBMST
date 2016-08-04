# BBMST
======
初级后台管理系统模板(Basic Background Management System Template)
<br><br>

程序构成：
------

#####php程序
laravel(https://github.com/laravel/laravel)
#####html模板
jquery(https://github.com/jquery/jquery)<br>
bootstrap(https://github.com/twbs/bootstrap)<br>
summernote(https://github.com/summernote/summernote)<br>



主要功能：
------

#####模板页面

前端使用bootstrap，自适应布局，全面支持各类型设备。<br>
已预设功能如下：<br>
列表页，添加／编辑页样式<br>
分页样式<br>
提示信息UI交互<br>
上传图片UI交互<br>
搜索UI交互<br>
过滤UI交互<br>
删除，编辑等按钮UI交互<br>

#####程序功能

后端数据处理全程试用PDOStatemen，防止注入。<br>
已预设功能如下：<br>
数据列表<br>
添加数据<br>
更新数据<br>
删除数据<br>
注册登录<br>
权限验证<br>
图片上传<br>


附注：
------
虽然名义上用了Laravel，但实际上为了便于移植，并未使用太多框架内的功能。这样可以很简单的将整个程序移植到CI或TP等其他框架下。<br>
pdo的数据库操作类仅封装了基本办法。复杂的情况请自行更改。貌似有点麻烦。<br>
还有最重要的一点。。。。出了问题我都不负责。。。。。

测试账号：
------
登录ID：admin<br>
密码：abc123
