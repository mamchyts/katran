<?php

use Phinx\Migration\AbstractMigration;
use Katran\Helper;

/**
* Migration template
* @see http://docs.phinx.org/en/latest/commands.html 
*/
class $className extends AbstractMigration
{
    /**
     * Migrate Up.
     * @see http://docs.phinx.org/en/latest/migrations.html#the-up-method
     */
    public function up()
    {
$sql = <<<SQL
ALTER TABLE `accounts`
    ADD COLUMN `salt` CHAR(255) NOT NULL DEFAULT '' AFTER `pass`,
    ADD UNIQUE INDEX `login` (`login`);
SQL;
        $query = $this->query($sql); // returns the result as an array

        $count = $this->execute('UPDATE accounts SET name = "note №'.mt_rand(0, 1000).'"'); // returns the number of affected rows
        $rows = $this->fetchAll('SELECT * FROM accounts'); // fetch an array of accounts
        $query = $this->query('SELECT * FROM accounts'); // returns the result as an array

        Helper::_d([$count, $query, $rows],1);
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
    }
}