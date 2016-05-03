<?php
/**
 * The file contains class Pages() extends DbImproved()
 */
namespace Common\Model;

use Katran\Url;
use Katran\Helper;
use Katran\Database\DbImproved;

/**
 * This class has methods for work with table 'pages'
 *
 * @package Model
 * @see     DbImproved()
 */
class Pages extends DbImproved
{
    // status
    const STATUS_ACTIVE  = 'active';
    const STATUS_BLOCKED = 'blocked';

    /**
     * Constructor set table
     *
     * @return  void
     * @version 2016-03-30
     * @access  public
     */
    public function __construct()
    {
        parent::setTable('pages');
    }


    /**
     * [getStatusHash description]
     * @return hash|array
     */
    public static function getStatusHash()
    {
        static $cache = null;
        if ($cache === null) {
            $cache = [
                self::STATUS_ACTIVE  => 'Активный',
                self::STATUS_BLOCKED => 'Заблокирован',
            ];
        }

        return $cache;
    }


    /**
     * [getStatus description]
     * @param  string $key [description]
     * @return string
     */
    public static function getStatus($key = '')
    {
        return self::getStatusHash()[$key];
    }


    /**
     * Function return meta data for html page
     *
     * @param   string   $url
     * @return  array|hash
     * @version 2013-03-24
     * @access  public
     */
    public function getPageMetaData($url = FALSE, $table = null, $key = 'url')
    {
        // set table if need
        if(empty($table))
            $table = parent::getTable();

        if((is_string($url) && (trim($url) !== '')) || ($table != 'pages')){
            $urlId = trim($url);
        }
        else{
            $url = new Url();
            $alias = $url->getParam('alias', false);

            if(!empty($alias))
                $urlId = $alias;
            else
                $urlId = 'index';
        }

        $sql = 'SELECT meta_title, meta_keywords, meta_description FROM `'.$table.'` WHERE `url` = ?';
        $row = $this->getRow($sql, [$urlId]);
        return $row;
    }


    /**
     * Function return page html from database table
     *
     * @param   string   $url
     * @return  string
     * @version 2013-03-24
     * @access  public
     */
    public function getPageHtml($url = FALSE)
    {
        if(is_string($url) && (trim($url) !== '')){
            $pageUrl = trim($url);
        }
        else{
            $url = new Url();
            $pageUrl = $url->getParam('page_url');
        }

        $sql = 'SELECT html FROM `'.parent::getTable().'` WHERE `url` = ?';
        return $this->getField($sql, [$pageUrl]);
    }
}