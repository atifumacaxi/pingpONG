<?php
namespace core;

/**
 * @package core
 */
class Database extends \PDO
{
    /**
     * Database host name.
     *
     * @var string
     * @static
     */
    private static $host = 'mysql.hostinger.com.br';
    
    /**
     * Database username.
     *
     * @var string
     * @static
     */
    private static $user = 'u369866392_admin';
    
    /**
     * Database user password.
     *
     * @var string
     * @static
     */
    private static $password = 'engenharia2015';
    
    /**
     * Database table name.
     *
     * @var string
     * @static
     */
    private static $database = 'u369866392_ongs';

    public function __construct()
    {
        parent::__construct(
            'mysql:host='.self::$host.';dbname='.self::$database,
            self::$user,
            self::$password
        );
    }
}

