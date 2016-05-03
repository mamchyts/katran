<?php

use Phinx\Migration\AbstractMigration;
use Katran\Helper;

/**
* Migration template
* @see http://docs.phinx.org/en/latest/commands.html 
*/
class Migration0 extends AbstractMigration
{
    /**
     * Migrate Up.
     * @see http://docs.phinx.org/en/latest/migrations.html#the-up-method
     */
    public function up()
    {
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` enum('active','hidden') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `role` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `area` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'visitor',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tel` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `note` varchar(10000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `accounts` (`id`, `login`, `pass`, `salt`, `status`, `role`, `area`, `name`, `tel`, `note`, `cdate`) VALUES
    (1, 'simple_admin', '$2y$12$0ce89fba5fff1e89858cdOigkGZ8Gp6fUvOxtKqRWkvnWQAmtcig.', '', 'active', 'admin', 'admin', 'Admin', '', '', '2015-10-13 15:32:46');


CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` char(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` enum('active','hidden') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `title` char(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `descr` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` char(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_keywords` char(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` char(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `pages` (`id`, `url`, `status`, `title`, `descr`, `html`, `meta_title`, `meta_keywords`, `meta_description`, `cdate`) VALUES
    (1, 'index', 'active', 'Главная', '<h2 class="site-description">portfolio theme for creatives</h2>', '<h2 class="site-description">portfolio theme for creatives</h2>', 'Дизайн сайта-фотостуди от katran.by', 'сайт-фотостудия, дизайн сайта, фотостудия,', '', '2015-08-10 11:11:11'),
    (2, 'contacts', 'active', 'Контакты', '', '', 'Дизайн сайта-фотостуди от katran.by :: Контакты', 'сайт-фотостудия, дизайн сайта, фотостудия, наши контакты, карта', '', '2016-03-24 11:55:39');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;


-- Dumping structure for table photo.katran.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `key` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(20000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `other` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`key`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SQL;
        $query = $this->query($sql); // returns the result as an array
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}