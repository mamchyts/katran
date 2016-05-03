<?php
/**
 * The file contains class Accounts() extends DbImproved()
 */
namespace Admin\Model;

use Katran\Model\Accounts as BaseAccounts;
use Katran\Helper;

/**
 * This class has methods for work with table 'accounts'
 *
 * @package Model
 * @see     DbImproved()
 */
class Accounts extends BaseAccounts
{
    // Available values for admin roles
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';

    /**
     * Constructor set table
     *
     * @return  void
     * @version 2016-03-30
     * @access  public
     */
    public function __construct()
    {
        parent::setTable('accounts');
    }


    /**
     * [getRoleHash description]
     * @return hash|array
     */
    public static function getRoleHash()
    {
        static $cache = null;
        if ($cache === null) {
            $cache = [
                self::ROLE_ADMIN => 'Администратор',
                self::ROLE_MANAGER => 'Менеджер',
            ];
        }

        return $cache;
    }


    /**
     * [getRole description]
     * @param  string $key [description]
     * @return string
     */
    public static function getRole($key = '')
    {
        return self::getRoleHash()[$key];
    }
}