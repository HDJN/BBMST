/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50713
 Source Host           : localhost
 Source Database       : bbmst

 Target Server Type    : MySQL
 Target Server Version : 50713
 File Encoding         : utf-8

 Date: 08/04/2016 16:25:45 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `realname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lastlogin` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `loginip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `level` tinyint(1) DEFAULT '1',
  `timeadd` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `isdel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `admin`
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES ('1', 'admin', '607cd5696f4c2ba5f90143e09fef3d93', '管理员', '1470294526', '127.0.0.1', '1', null, '0'), ('2', 'ceshi', '607cd5696f4c2ba5f90143e09fef3d93', '测试成员1', '1470295605', '127.0.0.1', '2', '1469008388', '0'), ('3', 'ceshi2', '607cd5696f4c2ba5f90143e09fef3d93', '测试账号2', '1469028603', '127.0.0.1', '1', '1469009100', '0'), ('4', 'ceshi3', '607cd5696f4c2ba5f90143e09fef3d93', '测试账号2', '1469009108', '', '2', '1469009108', '0'), ('5', 'ceshi4', '607cd5696f4c2ba5f90143e09fef3d93', '测试账号3', '1469009180', '', '2', '1469009180', '0');
COMMIT;

-- ----------------------------
--  Table structure for `admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `adminid` int(8) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `data` text,
  `timeadd` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `admin_log`
-- ----------------------------
BEGIN;
INSERT INTO `admin_log` VALUES ('1', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"11\",\"ip\":\"127.0.0.1\"}', '1469014663'), ('2', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"123\",\"ip\":\"127.0.0.1\"}', '1469014737'), ('3', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"123\",\"ip\":\"127.0.0.1\"}', '1469014740'), ('4', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"123\",\"ip\":\"127.0.0.1\"}', '1469014742'), ('5', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"123\",\"ip\":\"127.0.0.1\"}', '1469014779'), ('6', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"123\",\"ip\":\"127.0.0.1\"}', '1469014781'), ('7', '2', 'loginfail', '{\"username\":\"ceshi\",\"password\":\"123\",\"ip\":\"127.0.0.1\"}', '1469014784'), ('8', '1', 'login', '{\"ip\":\"127.0.0.1\"}', '1469159520'), ('9', '1', 'loginfail', '{\"username\":\"admin\",\"password\":\"abc123\",\"ip\":\"127.0.0.1\"}', '1469181726'), ('10', '1', 'login', '{\"ip\":\"127.0.0.1\"}', '1469181734'), ('11', '1', 'login', '{\"ip\":\"127.0.0.1\"}', '1469181759'), ('12', '1', 'login', '{\"ip\":\"127.0.0.1\"}', '1469422801'), ('13', '1', 'loginfail', '{\"username\":\"admin\",\"password\":\"abc123\",\"ip\":\"127.0.0.1\"}', '1470293833'), ('14', '1', 'loginfail', '{\"username\":\"admin\",\"password\":\"abc123\",\"ip\":\"127.0.0.1\"}', '1470293840'), ('15', '1', 'login', '{\"ip\":\"127.0.0.1\"}', '1470294286'), ('16', '1', 'login', '{\"ip\":\"127.0.0.1\"}', '1470294526'), ('17', '2', 'login', '{\"ip\":\"127.0.0.1\"}', '1470294704'), ('18', '2', 'login', '{\"ip\":\"127.0.0.1\"}', '1470295605');
COMMIT;

-- ----------------------------
--  Table structure for `brand`
-- ----------------------------
DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `branden` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `founder` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `foundtime` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cradle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `story` text CHARACTER SET utf8,
  `suffix` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `timeadd` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `timeupdate` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `isdel` tinyint(1) DEFAULT '0',
  `trans` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `brand`
-- ----------------------------
BEGIN;
INSERT INTO `brand` VALUES ('1', '安娜苏', 'Anna Sui', 'http://www.annasui.com', '安娜苏', '1980', '美国', '/data/images/brand/147029350316.png', '<p></p><p>身为第三代华裔移民的安娜苏(AnnaSui)1955年生于美国底特律，父亲是建筑结构工程师，母亲是专职家庭主妇。学生时代，安娜苏(AnnaSui)常从杂志里将一些图片剪下来收藏，并将未来的梦想设定在时装设计上。<br>上世纪70年代，安娜苏(AnnaSui)到纽约帕森斯设计学院学服装设计，但她只上了一年，第二年就辍学了。她的理由是学校的课程非常无聊，而且浪费时间。出校门以后，安娜苏(AnnaSui)到一家女装公司做助理。虽然这家公司一年半以后关闭了，但安娜苏(AnnaSui)却因此熟悉了布料市场，她知道到哪里可以找到最好的材料，以及什么是最好的价钱。<br>之后5年里，安娜苏(AnnaSui)“跳槽”了多家公司，学习了各种各样的服装设计和布料知识。1980年，她制作了4款服装，并展示在服装店里。不久，她从著名的梅西和布朗明黛尔百货公司获得了订单，“安娜苏(AnnaSui)”这个品牌开始建立声誉。<br>到上世纪80年代，时装设计界遇到了重大变革，那就是无论在正式宴会还是在其他场合，人们不再从头到脚穿同一个设计师设计的服饰。不久，时装界又开始流行复古风。安娜苏(AnnaSui)意识到她的机会来了：“我马上感觉到，这是我最拿手的设计，我相信我会走运的。”<br>1991年安娜苏(AnnaSui)首次公开发布时装秀，并在纽约开设了第一家精品店。1996年，安娜苏(AnnaSui)在东京设立亚洲第一家精品店，并在日本掀起紫色旋风。精明的日本人从安娜苏(AnnaSui)的风格中看到了商机，伊势丹集团最终与安娜苏(AnnaSui)达成协议，授权艾伦比亚公司研制安娜苏(AnnaSui)品牌化妆品。1998年，安娜苏(AnnaSui)化妆品正式在日本诞生。<br>安娜苏(AnnaSui)的产品具有极强的迷惑力，无论服装、配件还是彩妆，都能让人感觉到一种抢眼的、近乎妖艳的色彩震撼。时尚界因此叫她“纽约的魔法师”。她最擅长从纷乱的艺术形态里寻找灵感，作品尽显摇滚乐派的古怪与颓废。在崇尚简约主义的今天，安娜苏(AnnaSui)逆潮流而上，设计中充满浓浓的复古色彩和绚丽奢华的气息。不过安娜苏(AnnaSui)服装华丽却不失实用性，它可以让时尚的都市女性发挥自己的无限创意，随心组合，以展现独特的个性魅力。<br>安娜苏(AnnaSui)的时装洋溢着浓浓的复古气息和绚丽奢华的独特气质，大胆而略带叛逆，刺绣、花边、烫钻、绣珠、毛皮等一切华丽的装饰主义都集于她的设计之中，形成了她独特的巫女般迷幻魔力的风格。<br>从彩妆开始，安娜苏(AnnaSui)又在近年陆续推出了香水、保养品等产品，产品线越来越完整。除了紫黑色，安娜苏(AnnaSui)产品的色彩也越来越多样化，如蜜果系列保养品、金色包装的底妆系列、美白系列商品等。不过安娜苏(AnnaSui)对紫色的偏爱仍随处可见，她在彩妆与服装上大量运用紫、红、黑色，整个专柜也是浓郁的深紫色，一切宛如沉浸在紫色的浪漫之中。<br>安娜苏(AnnaSui)的产品包装也通常以她最喜爱的蔷薇花为主题，神秘的紫色搭配全黑花纹，并含有天然花香。安娜苏(AnnaSui)本人认为，这些充满趣味和迷人色调的彩妆系列，不管是化妆品还是容器都很可爱。她说：“我相信把它们一一收集排列，也会成为一种时尚。”</p><p><br></p>', 'annasui', '1470195769', '1470293509', '0', '1'), ('2', '雅姿', 'Artistry', 'http://www.amway.com.cn/product/artistry/', '', '1968', '美国', '/data/images/brand/14702935394.png', '<p>&nbsp;&nbsp;&nbsp;ARTISTRY，中文译作“雅姿”，由其英文原意“艺术技巧”，延展出“典雅高贵、顾盼生姿”的品牌内涵。迈入新世纪，为赋予品牌更富时代感的特性，安利推出全新的雅姿品牌标志，在承继其高雅时尚的品牌内涵的基础上，展露雅姿富于时代感、更具魅力的品牌个性与形象。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新的雅姿标志由英文ARTISTRY、钻石星光图形和品牌标语组成。英文ARTISTRY笔画纤细，设计简约，灵动的笔触充分体现雅姿简洁、时尚的品牌理念。崭新的钻石星光图形，将原有的菱形钻石标志加以延伸，八条不规则向外放射的金色射线，寓意雅姿的魅力如钻石散发的璀璨光芒，将美丽推广到更多、更广的层面，让更多的人一起感受雅姿，分享美丽。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌标语BeautifulPossibilities(中文译意“美丽皆有可能”)与整体设计相辅相成，传神地诠释了雅姿实现美丽的无限可能，让更多追求美丽的人们实现梦想，分享美容话题，分享美丽分秒。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>', 'artistry', '1470195769', '1470293542', '0', '1'), ('3', '雅芳', 'AVON', 'http://www.avon.com.cn', '大卫·麦可尼', '1886', '美国', '/data/images/brand/147029357630.jpg', '<p>&nbsp;&nbsp;1886年，\"雅芳之父\"大卫·麦可尼(DavidMcConnell)从一瓶随书附送的香笺中受到启发，创造了第一支小圆点香水以及同系列四款香水，“加州香芬公司”(theCaliforniaPerfumeCompany)由此诞生。出于对伟大诗人莎士比亚的仰慕，1939年,麦可尼先生以莎翁故乡一条名为\"AVON\"的河流重新为公司命名。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1940年，在美国妇女还没有选举权的社会环境下，艾碧太太充当起雅芳的美丽先锋，开始乘搭火车或者马车挨家挨户地销售香水。艾碧太太还鼓舞更多的女性加入销售行列，服务地区很快扩展到美国东北部，成为全球直销事业和女性事业的典范。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;这120年以来，雅芳一直恪守\"信任、尊重、信念、谦逊和高标准\"的雅芳价值观，致力于塑造女性独特的美丽，开启全球数百万女性的事业之门。如今的雅芳，已发展成为颇具规模的美容品跨国公司：拥有43000名员工，2005年销售总收入高达80亿美元，通过超过500万名独立的营业代表向全球100多个国家和地区的女性提供两万多种产品，包括著名的雅芳色彩系列、雅芳新活系列、雅芳柔肤系列、雅芳肌肤管理系列、维亮专业美发系列、雅芳草本家族系列、雅芳健康产品和全新品牌Mark系列，以及种类繁多的流行珠宝饰品。为了确保雅芳产品在世界的领先地位，全球雅芳在美国新泽西沙芬(SUFFERN)和日本东京设立了新产品的研发机构。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;而作为一家具有高度社会责任感的的企业，雅芳为妇女的健康与福利所作的努力，尤其在防治乳癌上的突出贡献深获社会各界的肯定。1955年，雅芳全球基金会正式成为一家经授权的公共慈善机构，以改善女性和她们家庭成员的生活为宗旨。时至今日，在提高女性经济发展机会及促进妇女身心健康上，雅芳做出了巨大的努力，体现了雅芳对女性的关爱和独特的行善潜力。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;全球雅芳声誉及奖项</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2006年</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*2006年3月，雅芳(中国)有限公司的\"雅芳直销模式\"被经济观察研究院等机构联合授予\"2005年度商业标杆\"称号。中国雅芳是唯一获此殊荣的直销企业。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*2006年1月，美国新闻周刊(Newsweek)中文月刊评出2005全球最强企业排行榜。在家用产品行业的评选中，雅芳凭借其优秀的表现名列第七位。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2005年</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*雅芳(中国)限公司由于在雇员职业生涯规划发展、企业文化建立弘扬等方面所作出卓越贡献，入选由亚太人力资源研究协会(APHRRA)、财智杂志(中国)限公司共同评选出的\"2005中国人力资源年度奖之--十大行业百佳雇主企业奖\"；</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*雅芳凭借各项卓越的表现再度跻身由美国《商业周刊》(BusinessWeek)与全球著名的品牌咨询公司〝Interbrand〞共同评比的\"全球最有价值的100大品牌\"，并且是唯一入选的直销公司。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*在欧洲最大型、涉及范围最广的消费者调查中，雅芳荣登\"最值得信赖护肤品牌\"排行榜榜首，已连续四年获此殊荣。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*雅芳\"Today-今日香水\"荣获香水界的\"奧斯卡金像奖\"--2005美国FIFI香水大赏\"年度最佳女香\"大奖。这是继雅芳\"黑色小洋装\"\"地球女人\"之后，再度于2005年荣获该奖项的产品。此奖项是至今已成立31年的香氛基金会所表彰的最高奖项，是给予香水业在创造性成就方面的极高荣誉。&nbsp;&nbsp;&nbsp;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*2000年至2005年，雅芳已连续6年被美国著名的《商业道德》杂志评选为\"全美最佳企业公民\"。<br>&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*已成立50周年的企业声誉权威评估机构--雅芳是其自1955年创立以来每年都上榜的71家公司之一。2005年排名：278。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*《金融时报》(FinancialTimes)全球500强\"全球最大的公司列表中，2005年雅芳名列第287位。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*《纽约日报》(Newsday)2005年公布的纽约市企业100强中，雅芳排名第24位。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*雅芳因市场营销方面的特殊成就被评为2005年度关联奖金奖(2005AnnualGoldenLinkAwards)的年度跨国企业。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*在《上班妈妈》杂志2005年百大上班妈妈最佳雇主名单中，雅芳高居第九位。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*Inova健康系统基金会授予雅芳全球基金会创新奖，表彰雅芳创立Avon-Inova关注乳癌网络，为女性特别是位于北弗吉尼亚缺少医疗服务的地区女性提供乳癌相关的知识普及、早期扫描检测、临床治疗和援助服务等。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*2001年至2005年，雅芳凭借其强大的实力和良好的品牌形象，连续入选美国极具权威的商业杂志《商业周刊》(BusinessWeek)全球\"最有价值的品牌\"100强的评比，排名不断上升。</p><p>&nbsp;&nbsp;</p>', 'avon', '1470195769', '1470293578', '0', '1');
COMMIT;

-- ----------------------------
--  Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tag` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `brand` int(8) DEFAULT '0',
  `viewnum` int(8) DEFAULT '0',
  `timeadd` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `timeupdate` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `contents` text CHARACTER SET utf8,
  `status` tinyint(1) DEFAULT '0',
  `isdel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `product`
-- ----------------------------
BEGIN;
INSERT INTO `product` VALUES ('1', 'Product_001', '/data/images/product/147029178970.jpg', 'ttt,ttt,ttt,', '2', '10', '1468390313', '1469016347', '<p>测试产品说明～～～</p><p>测试试用说明～～～</p><p>测试产品说明～～～</p><p>测试试用说明～～～</p><p>测试产品说明～～～</p><p>测试试用说明～～～</p>', '1', '0'), ('2', 'Product_002', '/data/images/product/147029178970.jpg', 'tag_1,tag_2,tag_3', '1', '100', '1468390373', '1470291936', '<p>产品说明</p>', '0', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
