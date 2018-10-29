<?php
declare(strict_types=1);

namespace MVQN\Data;
use MVQN\Data\Exceptions\ModelClassException;
use MVQN\Data\Models\Model;
use MVQN\UCRM\Data\Models\General;
use MVQN\UCRM\Data\Models\Option;
use MVQN\UCRM\Data\Models\User;
use MVQN\UCRM\Data\Models\UserGroup;

require_once __DIR__."/../../../../vendor/autoload.php";


/**
 * Class ModelTests
 *
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 */
class ModelTests extends \PHPUnit\Framework\TestCase
{
    protected const JSON_OPTIONS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    protected $pdo;

    protected function setUp()
    {
        $env = new \Dotenv\Dotenv(__DIR__."/../../../../");
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
        echo json_encode($results, self::JSON_OPTIONS)."\n";
        $this->assertGreaterThan(0, count($results));

        $results = Database::select("option", [ "code", "value"]);
        echo json_encode($results, self::JSON_OPTIONS)."\n";
        $this->assertGreaterThan(0, count($results));

        $results = Database::select("option", [ "code", "value"], "code");
        echo json_encode($results, self::JSON_OPTIONS)."\n";
        $this->assertGreaterThan(0, count($results));

        echo "\n";
    }

    public function testWhere()
    {
        $results = Database::where("option", "code = 'MAILER_PASSWORD'" );
        echo json_encode($results, self::JSON_OPTIONS)."\n";
        $this->assertCount(1, $results);

        $results = Database::where("option", "code = 'MAILER_PASSWORD'", [ "code", "value" ]);
        echo json_encode($results, self::JSON_OPTIONS)."\n";
        $this->assertCount(1, $results);

        $results = Database::where("option", "code = 'MAILER_PASSWORD'", [ "code", "value" ], "code");
        echo json_encode($results, self::JSON_OPTIONS)."\n";
        $this->assertCount(1, $results);

        echo "\n";
    }

    public function testModelAbstractionStatic()
    {
        $this->expectException(ModelClassException::class);

        $models = Model::select();
        echo $models."\n";
        $this->assertGreaterThan(0, count($models));
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
        // Has a @TableNameAnnotation specifying the table name.
        $options = Option::select();
        echo $options."\n";
        $this->assertGreaterThan(0, count($options));

        // Relies on automatic assumption of the table name, based on the class name.
        $generals = General::select();
        echo $generals."\n";
        $this->assertGreaterThan(0, count($generals));

        $groups = UserGroup::select();
        echo $groups."\n";
        $this->assertGreaterThan(0, count($groups));

        echo "\n";
    }

    public function testCreate()
    {
        //Model::create(__DIR__."/../../UCRM/Data/Models/", "MVQN\\UCRM\\Data\\Models", "user");

        /** @var User $user */
        $user = User::where("user_id", "=", 1)->first();

        // TODO: Figure out why citext columns always fail using WHERE!

        echo $user->getCreatedAt()->format("c")."\n";
        echo $user->getUsername()."\n";

        echo $user."\n";
    }



}