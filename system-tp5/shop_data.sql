-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 07 月 20 日 07:29
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `shop_data`
--

-- --------------------------------------------------------

--
-- 表的结构 `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '班级主键',
  `name` varchar(100) DEFAULT NULL COMMENT '班级名称',
  `length` varchar(20) DEFAULT NULL COMMENT '学制',
  `price` int(11) DEFAULT NULL COMMENT '学费',
  `status` int(11) DEFAULT NULL COMMENT '是否启用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_delete` int(11) DEFAULT NULL COMMENT '允许删除',
  `student_id` int(11) DEFAULT NULL COMMENT '关联外键',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1053 ;

--
-- 转存表中的数据 `grade`
--

INSERT INTO `grade` (`id`, `name`, `length`, `price`, `status`, `create_time`, `update_time`, `delete_time`, `is_delete`, `student_id`) VALUES
(1, 'PHP开发工程师就业班', '6个月', 19800, 1, 1502242191, 1502335837, NULL, 1, NULL),
(2, '前端开发工程师提高班', '3个月', 6767, 1, 1502242191, 1502335837, NULL, 1, NULL),
(3, 'WEB开发全栈工程师班', '6个月', 28800, 1, 1502242191, 1502336083, NULL, 1, NULL),
(4, 'Java开发工程师提升班', '一年半', 3500, 1, 1502257693, 1502335837, NULL, 1, NULL),
(5, '平面设计高薪就业班', '6个月', 9800, 1, 1502334559, 1502335837, NULL, 1, NULL),
(1052, '花样滑冰速成班', '一年半', 500000, NULL, 1532058409, 2147483647, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(4) DEFAULT NULL COMMENT '性别',
  `age` tinyint(4) unsigned DEFAULT NULL COMMENT '年龄',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `status` int(11) DEFAULT NULL COMMENT '当前状态',
  `start_time` int(11) DEFAULT NULL COMMENT '入学时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_delete` int(11) DEFAULT NULL COMMENT '允许删除',
  `grade_id` int(11) DEFAULT NULL COMMENT '关联外键',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`id`, `name`, `sex`, `age`, `mobile`, `email`, `status`, `start_time`, `create_time`, `update_time`, `delete_time`, `is_delete`, `grade_id`) VALUES
(1, '杨过', 0, 67, '18966557788', 'yangguo@php.cn', 1, 149434560, 1502326725, 1502343973, NULL, 1, 1052),
(2, '小龙女', 0, 33, '13509897765', 'xiaolongnv@php.cn', 1, 1502326725, 1502326725, 1502343973, NULL, 1, 1),
(3, '尹志平', 1, 38, '17765336278', 'yizhiping@php.cn', 1, 1502326725, 1502326725, 1502343973, NULL, 1, 3),
(4, '老顽童', 1, 89, '15677281923', 'laowantong@php.cn', 1, 1502326725, 1502326725, 1502343973, NULL, 1, 2),
(5, '洪七公', 1, 78, '13389776234', 'hongqigong@php.cn', 1, 1502326725, 1502326725, 1502343973, NULL, 1, 2),
(6, '郭靖', 0, 26, '15766338726', 'guojin@php.cn', 1, 1502294400, 1502326725, 1502343973, NULL, 1, 1),
(7, '黄蓉', 0, 46, '18976227182', 'huangrong@php.cn', 0, 1502326725, 1502326725, 1502343973, NULL, 1, 1),
(8, '杨康', 1, 45, '13287009834', 'yangkang@php.cn', 0, 1502326725, 1502326725, 1502343973, NULL, 1, 3),
(9, '欧阳克', 1, 37, '13908772343', 'ouyangke@php.cn', 0, 1502326725, 1502326725, 1502343973, NULL, 1, 2),
(10, '张无忌', 1, 28, '15387298273', 'zhangwuji@php.cn', 1, 1502326725, 1502326725, 1502343973, NULL, 1, 2),
(11, '赵敏', 0, 26, '13987372937', 'zhaoming@php.cn', 1, 1502326725, 1502326725, 1502343973, NULL, 1, 3),
(12, '宋青书', 0, 22, '15806554328', 'songqinshu@php.cn', 1, 1494864000, 1502327784, 1502343973, NULL, 1, 2),
(13, '周芷若', 1, 20, '18977665544', 'zhouzhiruo@php.cn', 1, 1501948800, 1502343910, 1502343931, NULL, NULL, 5);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `degree` varchar(30) DEFAULT NULL COMMENT '学历',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `school` varchar(50) DEFAULT NULL COMMENT '毕业学校',
  `hiredate` int(11) DEFAULT NULL COMMENT '入职时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `is_delete` int(11) DEFAULT '1' COMMENT '允许删除',
  `status` int(11) DEFAULT NULL COMMENT '1启用0禁用',
  `grade_id` int(11) DEFAULT NULL COMMENT '外键',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1029 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `degree`, `mobile`, `school`, `hiredate`, `create_time`, `update_time`, `delete_time`, `is_delete`, `status`, `grade_id`) VALUES
(1, '朱老师', '1', '15705517878', '中国科技大学', 1420041000, 1502272302, 1502342345, NULL, 1, 1, 2),
(1028, '黄大美', '2', '13795882922', '家里蹲大学', 2147483647, 1532065197, 1532065197, NULL, 1, NULL, 1),
(3, '洪老师', '1', '18955139988', '安徽大学', 1486310400, 1502272302, 1502342345, NULL, 1, 1, 1),
(5, '张老师', '1', '15805512377', '安徽师范大学', 1461254400, 1502272302, 1502342345, NULL, 1, 1, 5),
(6, '范老师', '1', '18976765533', '安徽理工大学', 1501948800, 1502272302, 1502342345, NULL, 1, 1, 4);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `password` varchar(32) DEFAULT NULL COMMENT '用户密码',
  `email` varchar(255) DEFAULT NULL COMMENT '用户邮箱',
  `role` tinyint(2) unsigned DEFAULT '1' COMMENT '角色',
  `status` int(2) unsigned DEFAULT '1' COMMENT '状态:1启用0禁用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `login_time` int(11) unsigned DEFAULT NULL COMMENT '登录时间',
  `login_count` int(11) unsigned DEFAULT '0' COMMENT '登录次数',
  `is_delete` int(2) unsigned DEFAULT '0' COMMENT '是否删除1是0否',
  `token` varchar(200) NOT NULL,
  `introduction` varchar(200) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `role`, `status`, `create_time`, `update_time`, `delete_time`, `login_time`, `login_count`, `is_delete`, `token`, `introduction`, `avatar`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin123@php.cn', 1, 1, 1501493848, 1502340075, NULL, 1502339370, 20, 1, '8c3a3de78afe0734600f602813af764d', '这是管理员', 'https://fuss10.elemecdn.com/d/c0/56cfcdabba9fec97a3307b571ca8cjpeg.jpeg'),
(3, 'peter', 'e10adc3949ba59abbe56e057f20f883e', 'peter888@php.cn', 2, 1, 1501582576, 1502260457, NULL, 1502168741, 15, 1, 'd5b34a8c98187f3e5d0e90e7e25f5a62', '这是管理员', 'https://fuss10.elemecdn.com/d/c0/56cfcdabba9fec97a3307b571ca8cjpeg.jpeg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
