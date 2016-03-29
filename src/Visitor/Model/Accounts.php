<?php
/**
 * The file contains class Accounts() extends DbImproved()
 */
namespace Site\Visitor\Model;

use Katran\Database\DbImproved;

/**
 * This class has methods for work with table 'accounts'
 *
 * @package Model
 * @see     DbImproved()
 */
class Accounts extends DbImproved
{
    /**
     * Constructor set table
     *
     * @return  void
     * @version 2013-03-21
     * @access  public
     */
    public function __construct()
    {
        $this->table = 'accounts';
    }
}