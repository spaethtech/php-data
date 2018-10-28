<?php
declare(strict_types=1);

namespace MVQN\Data;
use MVQN\UCRM\Data\Models\General;
use MVQN\UCRM\Data\Models\Option;

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
        echo json_encode($results);
        $this->assertGreaterThan(0, count($results));
    }

    public function testWhere()
    {
        $results = Database::where("option", "code = 'MAILER_PASSWORD'" );
        echo json_encode($results);
        $this->assertCount(1, $results);
    }


    public function testColumnNameAnnotation()
    {
        $options = Option::select();
        echo $options."\n";
        $this->assertGreaterThan(0, count($options));

        $generals = General::select();
        echo $generals."\n";
        $this->assertGreaterThan(0, count($generals));



        echo "\n";
    }

    public function testTableNameAnnotation()
    {
        $options = Option::select();
        echo $options."\n";
        $this->assertGreaterThan(0, count($options));

        $generals = General::select();
        echo $generals."\n";
        $this->assertGreaterThan(0, count($generals));

        echo "\n";
    }


}