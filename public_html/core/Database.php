<?php
namespace core;

/**
 * @author Leonardo Rocha <leonardo.lsrocha@gmail.com>
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
    private static $user = 'u331295231_party';
    
    /**
     * Database user password.
     *
     * @var string
     * @static
     */
    private static $password = '123456';
    
    /**
     * Database table name.
     *
     * @var string
     * @static
     */
    private static $database = 'u331295231_party';

    public function __construct()
    {
        parent::__construct(
            'mysql:host='.self::$host.';dbname='.self::$database,
            self::$user,
            self::$password
        );
    }
}

