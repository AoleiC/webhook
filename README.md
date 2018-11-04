# webhook
配合nginx，搭建一个简单易用的webhook

# 环境安装
```
// ubuntu 16.04 安装 php7.0
sudo apt-get install php7.0-cgi php7.0-fpm

// ubuntu 14.04 安装 php5.6
sudo apt-get install php5.6-cgi php5.6-fpm

// ubuntu 安装 nginx
sudo apt-get install nginx

// 在index.php 文件的目录下添加文件 console.log，权限设置为 777
chmod 777 -R /data/webhook/console.log 

```

# Nginx 配置示例 修改 /etc/nginx/sites-available的 default 文件
```
server {
	listen 18000;     # 监听端口

	root /data/webhook;
	index index.php;
	server_name _;    # 或者换成域名、IP

	location ~ \.php$ {
    try_files $uri = 404;
		fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
    fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
		fastcgi_index index.php;
		include fastcgi_params;
	}

	location / {
		try_files $uri $uri/ /index.php$is_args$args;	
        }
}

```
# 测试 浏览器请求
```
http://[域名或IP]:18000/?token=7b6a7a9c8066859f69ee5019b3675869&type=aliyun_code
```


