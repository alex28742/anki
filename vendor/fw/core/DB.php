<?php

namespace fw\core;
use fw\libs\Helper;
use RedBeanPHP\R;
class DB
{
    protected $setup; // connection credentials

    public function __construct(){
        $showErrors = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO:: ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->setup = require APP . "/config/config_db.php";
        R::setup($this->setup['dsn'], $this->setup['user'], $this->setup['pass'], $showErrors);
    }

    /** Dispenses a new bean for a table
     * @param string $table table name
     * @return array|\RedBeanPHP\OODBBean
     */
    public static function dispense($table){
        return R::dispense($table);
    }

    /** Stores a bean
     * @param object $bean
     * @return int|string id of the stored record
     * @throws \RedBeanPHP\RedException\SQL
     */
    public static function store($bean){
        return R::store($bean);
    }

    /** Loads a bean by primary key
     * @param string $table table to load from
     * @param int $id primary key
     * @return \RedBeanPHP\OODBBean
     */
    public static function load($table, $id){
        return R::load($table, $id);
    }

    /** Loads beans by an array of primary keys
     * @param string $table
     * @param array $ids
     * @return array
     */
    public static function loadAll($table, $ids = []){
        return R::loadAll($table, $ids);
    }

    /** Finds beans matching a SQL condition
     * @param string $table
     * @param string $condition e.g. "`age` > ? ORDER BY ... DESC"
     * @param array $params bound values, in the same order as the condition
     * @return array
     */
    public static function find($table, $condition, $params){
        return R::find($table, $condition, $params);
    }

    /** Like find(), but limited to a single bean
     * @param string $table
     * @param string $condition
     * @param array $param
     * @return \RedBeanPHP\OODBBean|NULL
     */
    public static function findOne($table, $condition, $param){
        return R::findOne($table, $condition, $param);
    }

    /** All rows of a table, optionally sorted (e.g. "ORDER BY `name` ASC")
     * @param string $table
     * @param string $order optional
     * @return array
     */
    public static function findAll($table, $order = null){
        return R::findAll($table, $order);
    }

    /** Cursor-based lookup for one row at a time: while($user = $users->next())
     * @param string $table
     * @param string $order optional
     * @return \RedBeanPHP\BeanCollection
     */
    public static function findCollection($table, $order = null){
        return R::findCollection($table, $order);
    }

    /** Finds beans by field values. Returns an array of beans, or an empty array
     * @param $table
     * @param array $desired fields to match, e.g. ['name' => 'petya vasechkin', ...]
     * @param string $order optional, e.g. ORDER BY 'age' ASC
     * @return array
     */
    public static function findLike($table, $desired = null, $order = null){
        return R::findLike($table, $desired, $order);
    }


    /** Returns an existing matching bean, or creates and returns a new one
     * @param string $table
     * @param array $fields e.g. ['name' => 'masyk', 'age' => 4]
     * @return \RedBeanPHP\OODBBean
     */
    public static function findOrCreate($table, $fields = []){
        return R::findOrCreate($table, $fields);
    }

    /** Row count, optionally filtered
     * @param $table
     * @param string $condition optional, e.g. 'WHERE `name`=?'
     * @param array $params optional, e.g. ['robert']
     * @return int
     */
    public static function count($table, $condition = "", $params = ""){
        return R::count($table,$condition, $params);
    }

    /** Deletes a single bean
     * @param $bean
     * @return void
     */
    public static function trash($bean){
        R::trash($bean);
    }

    /** Deletes several beans
     * @param $beans
     * @return void
     */
    public static function trashAll($beans){
        R::trash($beans);
    }

    /** Deletes every row of a table
     * @param $table
     * @return void
     */
    public static function wipe($table){
        R::wipe($table);
    }

    /** Converts beans to plain arrays
     * @param $beans
     * @return array
     */
    public static function exportAll($beans){
        return R::exportAll($beans);
    }

    /** Runs an arbitrary SQL query
     * @param $sql
     * @param $bindings
     * @return array|int|null
     */
    public static function exec($sql, $bindings = []){
        return R::exec($sql, $bindings);
    }


}
