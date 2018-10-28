<?php
declare(strict_types=1);

namespace MVQN\Data;
require_once __DIR__."/../../../vendor/autoload.php";


/**
 * Class DatabaseTests
 *
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 */
class DatabaseTests extends \PHPUnit\Framework\TestCase
{
    protected $pdo;

    protected function setUp()
    {
        $env = new \Dotenv\Dotenv(__DIR__."/../../../");
        $env->load();

        $this->pdo = Database::connect(
            getenv("POSTGRES_HOST"),
            (int)getenv("POSTGRES_PORT"),
            getenv("POSTGRES_DB"),
            getenv("POSTGRES_USER"),
            getenv("POSTGRES_PASSWORD"));
    }

    public function testConnect()
    {
        $this->assertNotNull($this->pdo);
    }


    public function testSelect()
    {
        $results = Database::select("option");
        var_dump($results);
    }

    public function testWhere()
    {
        $results = Database::where("option", "code = 'MAILER_PASSWORD'" );
        print_r($results);
    }




}