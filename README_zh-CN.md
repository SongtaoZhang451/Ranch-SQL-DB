# 牧场管理数据库系统

[English](README.md) | [简体中文](README_zh-CN.md)

## 项目概述

本项目是一个基于浏览器运行的牧场管理数据库应用，使用 **PHP**、**MySQL/MariaDB** 和 **XAMPP** 构建。

该系统提供了一个简洁的界面，用于查看和管理与牧场经营相关的记录，包括员工、牧场地块、设备、牛只、健康记录、财务交易以及各类关系表。

SQL 文件中包含的所有记录均为**虚构的演示数据**，仅用于教学和作品集展示。

## 主要功能

* 查看每个数据库表中的全部记录
* 在所选数据表的所有字段中进行搜索
* 添加新记录
* 编辑现有记录
* 经确认后删除记录
* 基于 Session 的登录与退出
* 基于角色的访问控制
* 对 POST 请求实施 CSRF 防护
* 使用 PDO 连接 MySQL 数据库
* 使用数据库约束、主键和外键

## 用户角色

应用中包含三种演示角色：

| 角色 | 权限 |
| --- | --- |
| `viewer` | 查看和搜索记录 |
| `manager` | 查看、搜索、添加和编辑记录 |
| `admin` | 完整的 CRUD 权限，包括删除记录 |

### 演示登录账户

| 用户名 | 密码 |
| --- | --- |
| `viewer` | `viewerpwd` |
| `manager` | `managerpwd` |
| `admin` | `adminpwd` |

这些账户为演示目的而硬编码，不应在生产环境中使用。

## 数据库结构

数据库名称为 `cbase`，共包含九个数据表：

| 数据表 | 用途 |
| --- | --- |
| `Employee` | 保存员工姓名、岗位、电话号码和入职日期 |
| `Pasture` | 保存牧场地块名称、面积和土壤类型 |
| `Equipment` | 保存设备类型、购买日期、设备状况及分配的牧场地块 |
| `Cattle` | 保存牛只品种、性别、出生日期、体重、状态和所在牧场地块 |
| `HealthRecord` | 保存牛只健康检查、体温、诊断和治疗记录 |
| `Transaction` | 保存与牛只相关的销售和采购交易 |
| `Treats` | 连接负责治疗牛只的员工与对应牛只 |
| `Manages` | 连接管理员工与其负责的牧场地块 |
| `Financial` | 连接牛只与相关财务交易 |

### 主要关系

* 一个牧场地块可以包含多头牛。
* 一个牧场地块可以配置多台设备。
* 一头牛可以拥有多条健康记录。
* 员工和牛只通过 `Treats` 表关联。
* 员工和牧场地块通过 `Manages` 表关联。
* 牛只和交易通过 `Financial` 表关联。

## 项目结构

```text
.
├── auth.php
├── config.php
├── create.sql
├── cbase.sql
├── db.php
├── delete.php
├── edit.php
├── footer.php
├── header.php
├── index.php
├── load.sql
├── login.php
├── logout.php
├── view.php
└── README.md
```

当前的 `header.php` 还引用了以下文件：

```text
assets/style.css
```

即使缺少该文件，应用仍可正常运行，但页面不会显示自定义样式。如果你拥有对应样式文件，请将其与 `assets` 目录一起添加到项目中。

## 文件说明

| 文件 | 说明 |
| --- | --- |
| `index.php` | 显示所有牧场数据库表的入口链接 |
| `login.php` | 处理演示用户登录 |
| `logout.php` | 结束当前用户 Session |
| `auth.php` | 实现角色权限检查和 CSRF 验证 |
| `config.php` | 保存本地数据库设置并启动 Session |
| `db.php` | 创建可复用的 PDO 数据库连接和搜索辅助函数 |
| `view.php` | 显示并搜索数据表记录 |
| `edit.php` | 添加新记录并更新现有记录 |
| `delete.php` | 删除记录，仅限管理员使用 |
| `header.php` | 共用的页面头部和导航栏 |
| `footer.php` | 共用的页面底部 |
| `create.sql` | 重新创建 `cbase` 数据库及其表结构 |
| `load.sql` | 导入原始虚构示例记录 |
| `cbase.sql` | 完整的 phpMyAdmin 导出文件，包含数据库结构和当前示例数据 |

## 环境要求

* Windows、macOS 或 Linux
* XAMPP 或其他 Apache/PHP/MySQL 运行环境
* PHP 8 或更高版本
* MySQL 或 MariaDB
* PDO MySQL 扩展
* Web 浏览器

项目所包含的完整 SQL 转储文件由 MariaDB 10.4.32 导出，使用 phpMyAdmin 5.2.1 和 PHP 8.2.12。

## 本地安装

### 1. 安装 XAMPP

安装 XAMPP 并打开 XAMPP Control Panel。

启动以下服务：

```text
Apache
MySQL
```

### 2. 将项目复制到 `htdocs`

将仓库文件夹放入：

```text
C:\xampp\htdocs\
```

例如：

```text
C:\xampp\htdocs\ranch-db
```

### 3. 打开 phpMyAdmin

在浏览器中访问：

```text
http://localhost/phpmyadmin/
```

## 数据库配置

### 方法 A：导入完整数据库转储文件

这是最简单的方法。

1. 打开 phpMyAdmin。
2. 选择 **Import** 选项卡。
3. 选择 `cbase.sql`。
4. 点击 **Import** 或 **Go**。

该文件包含数据库结构和当前的虚构示例记录。

### 方法 B：使用独立脚本重新创建数据库

使用此方法可以重新建立原始数据库结构和初始数据。

1. 打开 phpMyAdmin 的 **Import** 选项卡。
2. 导入 `create.sql`。
3. 完成后，再导入 `load.sql`。

请按以下顺序导入文件：

```text
create.sql
load.sql
```

使用此方法后，不要再导入 `cbase.sql`，否则可能会重新创建数据表或产生重复记录。

## 数据库连接设置

应用在 `config.php` 中使用以下本地 XAMPP 设置：

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cbase');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
```

XAMPP 默认的 MySQL `root` 账户通常使用空密码。如果你的本地 MySQL 配置不同，请修改 `DB_USER` 和 `DB_PASS`。

这里的数据库密码只用于让 PHP 应用访问所配置的 MySQL 账户。

## 运行应用

启动 Apache 和 MySQL，并导入数据库后，在浏览器中访问：

```text
http://localhost/ranch-db/login.php
```

请将 `ranch-db` 替换为项目在 `htdocs` 中的实际文件夹名称。

登录后，主页会显示以下数据表：

```text
Employee
Pasture
Equipment
Cattle
HealthRecord
Transaction
Treats
Manages
Financial
```

## 应用工作流程

```text
用户登录
   |
   v
系统分配 Session 角色
   |
   v
用户选择一个数据库表
   |
   v
PHP 通过 PDO 发送查询
   |
   v
MySQL 返回记录
   |
   v
浏览器显示搜索结果和用户被允许执行的操作
```

## 局限性与未来改进

本应用是一个教学演示项目，尚未达到生产环境使用标准。

可考虑的改进方向包括：

* 将用户账户保存在数据库中
* 替换硬编码的演示账户
* 加强表单输入验证
* 增加更详细的错误处理
* 添加完整的 CSS 界面
* 其他功能改进

## 声明

本仓库中的所有姓名、电话号码、牛只记录、健康记录和财务记录均为虚构的演示数据，不代表任何真实牧场或真实个人。

## 作者

**Shunzhi Yu**

**Songtao Zhang**
