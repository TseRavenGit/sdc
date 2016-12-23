<?php
/*return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__ . '/Public',
        '__JS__' => __ROOT__ . '/Public/Home/js',
        '__CSS__' => __ROOT__ . '/Public/Home/css',
        '__IMAGE__' => __ROOT__ . '/Public/Home/img',
        '__DATA__' => __ROOT__ . '/Data/'
    ),

    //数据库配置信息
	'DB_TYPE'   => 'mysqli', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'sdc', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => '', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
);*/

$sdcConfig= require 'sdc_setting.php'; 

$config = array(
			//'配置项'=>'配置值'
			'TMPL_PARSE_STRING' => array(
		        '__PUBLIC__' => __ROOT__ . '/Public',
		        '__JS__' => __ROOT__ . '/Public/Home/js',
		        '__CSS__' => __ROOT__ . '/Public/Home/css',
		        '__IMAGE__' => __ROOT__ . '/Public/Home/img',
		        '__DATA__' => __ROOT__ . '/Data/'
		    ),

		    //数据库配置信息
			'DB_TYPE'   => 'mysqli', // 数据库类型
			'DB_HOST'   => 'localhost', // 服务器地址
			'DB_NAME'   => 'sdc', // 数据库名
			'DB_USER'   => 'root', // 用户名
			'DB_PWD'    => '123456', // 密码
			'DB_PORT'   => 3306, // 端口
			'DB_PREFIX' => '', // 数据库表前缀 
			'DB_CHARSET'=> 'utf8', // 字符集
			'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增sss


		); 

return array_merge($sdcConfig,$config);