# 绘智童程 - 无屏编程启蒙系统

基于STM32H7的无屏编程启蒙系统管理后台，支持LNMP环境部署。

## 系统要求

- **操作系统**: Linux (Ubuntu 20.04+ / CentOS 7+)
- **Web服务器**: Nginx 1.18+
- **PHP**: 8.1+ (推荐8.2)
- **数据库**: MySQL 8.0+ / MariaDB 10.5+
- **PHP扩展**: PDO, PDO_MySQL, JSON, Mbstring, OpenSSL, Curl, GD

## 快速部署

### 1. 安装LNMP环境

#### Ubuntu/Debian:
```bash
# 更新系统
sudo apt update && sudo apt upgrade -y

# 安装Nginx
sudo apt install nginx -y

# 安装PHP 8.1
sudo apt install php8.1-fpm php8.1-mysql php8.1-curl php8.1-gd php8.1-mbstring php8.1-xml php8.1-zip -y

# 安装MySQL
sudo apt install mysql-server -y

# 启动服务
sudo systemctl start nginx php8.1-fpm mysql
sudo systemctl enable nginx php8.1-fpm mysql
```

#### CentOS/RHEL:
```bash
# 安装EPEL和Remi仓库
sudo yum install epel-release -y
sudo yum install https://rpms.remirepo.net/enterprise/remi-release-8.rpm -y

# 安装PHP 8.1
sudo yum install php php-fpm php-mysqlnd php-pdo php-gd php-mbstring php-xml php-json -y

# 安装Nginx
sudo yum install nginx -y

# 安装MySQL
sudo yum install mysql-server -y

# 启动服务
sudo systemctl start nginx php-fpm mysqld
sudo systemctl enable nginx php-fpm mysqld
```

### 2. 配置数据库

```bash
# 登录MySQL
sudo mysql -u root -p

# 创建数据库
CREATE DATABASE huizhitongcheng CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 创建用户（可选，或使用root）
CREATE USER 'hztc_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON huizhitongcheng.* TO 'hztc_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. 导入数据库

```bash
# 导入表结构
mysql -u root -p huizhitongcheng < database/migrations/001_create_users_table.sql

# 导入测试数据（可选）
mysql -u root -p huizhitongcheng < database/seeds/001_insert_sample_data.sql
```

### 4. 部署项目

```bash
# 克隆或复制项目到Web目录
sudo cp -r /path/to/绘智童程-lnmp /var/www/huizhitongcheng

# 设置权限
sudo chown -R www-data:www-data /var/www/huizhitongcheng
sudo chmod -R 755 /var/www/huizhitongcheng
sudo chmod -R 777 /var/www/huizhitongcheng/storage
sudo chmod -R 777 /var/www/huizhitongcheng/public/uploads
```

### 5. 配置Nginx

```bash
# 复制Nginx配置
sudo cp nginx.conf /etc/nginx/sites-available/huizhitongcheng

# 创建软链接
sudo ln -s /etc/nginx/sites-available/huizhitongcheng /etc/nginx/sites-enabled/

# 测试配置
sudo nginx -t

# 重启Nginx
sudo systemctl restart nginx
```

### 6. 配置PHP

编辑 `/etc/php/8.1/fpm/php.ini` (根据实际路径调整):

```ini
upload_max_filesize = 20M
post_max_size = 25M
max_execution_time = 300
memory_limit = 256M
date.timezone = Asia/Shanghai
```

重启PHP-FPM:
```bash
sudo systemctl restart php8.1-fpm
```

## 访问系统

- **URL**: `http://huizhitongcheng.local` (根据配置的域名)
- **默认管理员账号**: admin
- **默认密码**: admin123

**⚠️ 首次登录后请立即修改默认密码！**

## 项目结构

```
绘智童程-lnmp/
├── public/                 # Web根目录（Nginx指向这里）
│   ├── index.php          # 入口文件
│   ├── assets/            # 静态资源
│   └── uploads/           # 上传文件
├── app/                   # 应用代码
│   ├── config/            # 配置文件
│   ├── controllers/       # 控制器
│   ├── models/            # 模型
│   ├── views/             # 视图模板
│   └── core/              # 核心框架类
├── database/              # 数据库相关
│   ├── migrations/        # 数据库迁移
│   └── seeds/             # 测试数据
├── storage/               # 存储目录
│   ├── logs/              # 日志
│   └── cache/             # 缓存
├── nginx.conf             # Nginx配置示例
└── README.md              # 项目说明
```

## 配置文件

编辑 `app/config/config.php` 修改以下配置:

```php
// 数据库配置
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'huizhitongcheng');
define('DB_USER', 'root');
define('DB_PASS', '');

// 站点URL
define('SITE_URL', 'http://your-domain.com');
```

## 功能模块

1. **数据概览**: 系统数据统计和图表展示
2. **课程管理**: 课程的增删改查
3. **学员管理**: 学员信息管理
4. **设备管理**: 编程设备状态监控
5. **课时计划**: 课程安排和计划
6. **资源库**: 教学资源管理
7. **编程卡片**: 编程指令卡片管理
8. **学习分析**: 学习数据统计分析
9. **系统设置**: 系统参数配置

## 安全建议

1. 修改默认管理员密码
2. 使用HTTPS协议
3. 定期备份数据库
4. 限制文件上传类型和大小
5. 配置防火墙规则
6. 定期更新系统和依赖

## 备份与恢复

### 备份数据库
```bash
mysqldump -u root -p huizhitongcheng > backup_$(date +%Y%m%d).sql
```

### 恢复数据库
```bash
mysql -u root -p huizhitongcheng < backup_20240622.sql
```

### 备份文件
```bash
tar -czvf huizhitongcheng_backup_$(date +%Y%m%d).tar.gz /var/www/huizhitongcheng
```

## 常见问题

### 1. 数据库连接失败
检查 `app/config/config.php` 中的数据库配置是否正确。

### 2. 404错误
确保Nginx配置正确，且指向 `public` 目录。

### 3. 文件上传失败
检查 `public/uploads` 目录权限，确保Web服务器有写入权限。

### 4. 页面样式丢失
检查 `ASSETS_URL` 配置是否正确。

## 技术支持

如有问题，请联系开发团队或提交Issue。

## 许可证

版权所有 © 2024 绘智童程