<?php
declare(strict_types=1);

namespace MVQN\Data\Models;

use MVQN\Annotations\AnnotationReader;
use MVQN\Collections\Collection;
use MVQN\Dynamics\AutoObject;
use MVQN\Data\Database;

use MVQN\Data\Exceptions\DatabaseConnectionException;
use MVQN\Data\Exceptions\ModelClassException;
use MVQN\Data\Exceptions\ModelMissingPropertyException;

/**
 * Class Model
 *
 * @package MVQN\UCRM\Data
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 * @final
 */
abstract class Model extends AutoObject
{
    // =================================================================================================================
    // PROPERTIES
    // =================================================================================================================

    /** @var array|null A cache for storing each Model's column => property pairings. */
    private static $columnPropertiesCache;

    /** @var array|null A cache for storing each Model's class => table name pairings. */
    private static $tableNameCache;

    // =================================================================================================================
    // CONSTRUCTOR
    // =================================================================================================================

    /**
     * Model constructor.
     *
     * @param array $data An associative array of column name => value pairs from the database.
     * @throws ModelClassException
     * @throws ModelMissingPropertyException
     * @throws \ReflectionException
     */
    public function __construct(array $data = [])
    {
        // Get this class name.
        $class = get_class($this);

        // IF the column => property cache has not yet been built, or does not exist for this class...
        if (self::$columnPropertiesCache === null || !array_key_exists($class, self::$columnPropertiesCache) ||
            self::$columnPropertiesCache[$class] === null)
            // THEN build it now!
            self::buildColumnPropertiesCache();

        // Loop through each column name => value pair provided...
        foreach($data as $name => $value)
        {
            // IF the column name has a matching index in the column => property cache for this class...
            if(array_key_exists($name, self::$columnPropertiesCache[$class]))
            {
                // THEN set the current column's value on all properties annotated with this column name.
                foreach(self::$columnPropertiesCache[$class][$name] as $propertyName)
                    $this->$propertyName = $value;
            }
            else
            {
                // OTHERWISE no matching column => property pairing or @ColumnNameAnnotation was found!
                throw new ModelMissingPropertyException("Could not find a property '$name' of class '$class'.  ".
                    "Are you missing a '@ColumnNameAnnotation' on a property?");
            }
        }
    }

    // =================================================================================================================
    // HELPERS
    // =================================================================================================================

    /**
     * Converts a CamelCase string to it's snake_case equivalent.
     *
     * @param string $camel The CamelCase string to convert.
     * @return string Return the snake_case equivalent.
     */
    private static function camel2snake(string $camel): string
    {
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $camel, $matches);

        if($matches !== null && count($matches) > 1 && count($matches[1]) > 1)
        {
            $nameParts = $matches[1];
            $nameParts = array_map("lcfirst", $nameParts);
            return implode("_", $nameParts);
        }
        else
        {
            return lcfirst($camel);
        }
    }

    /**
     * Converts a snake_case string to it's CamelCase equivalent.
     *
     * @param string $snake The snake_case string to convert.
     * @return string Return the CamelCase equivalent.
     */
    private static function snake2camel(string $snake): string
    {
        $nameParts = explode("_", $snake);
        $nameParts = array_map("ucfirst", $nameParts);
        return implode("", $nameParts);
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Builds a column => property cache for the calling class.
     *
     * @throws ModelClassException
     * @throws \ReflectionException
     */
    private static function buildColumnPropertiesCache()
    {
        // Get the calling child class, ensuring that the Model class was not used!
        $class = self::getStaticChildClass();

        // Create an AnnotationReader and get all of the annotations on properties of this class.
        $annotations = new AnnotationReader($class);
        $properties = $annotations->getPropertyAnnotations();

        // Initialize a collection of column => property names.
        self::$columnPropertiesCache[$class] = [];

        // Loop through each property annotation...
        foreach($properties as $property)
        {
            // Skip non-annotated properties!
            if($property === [])
                continue;

            // If the current property has a @ColumnNameAnnotation...
            if(array_key_exists("ColumnName", $property))
                // THEN add the column name and property name pairing to the collection!
                self::$columnPropertiesCache[$class][$property["ColumnName"]][] = $property["var"]["name"];
            else
                // OTHERWISE add the property name to the collection, paired to itself!
                self::$columnPropertiesCache[$class][$property["var"]["name"]][] = $property["var"]["name"];
        }
    }

    /**
     * Compares the provided name to the column => property cache to ensure that both column and property names can be
     * used in functions requiring only the column name.
     *
     * @param string $name The name of the column or property of which to lookup.
     * @return string|null Returns the column name for the column or property name specified.
     * @throws ModelClassException
     * @throws \ReflectionException
     */
    private static function getColumnName(string $name): ?string
    {
        // Get the calling child class, ensuring that the Model class was not used!
        $class = self::getStaticChildClass();

        // IF the column => property cache has not yet been built, or does not exist for this class...
        if (self::$columnPropertiesCache === null || !array_key_exists($class, self::$columnPropertiesCache) ||
            self::$columnPropertiesCache[$class] === null)
            // THEN build it now!
            self::buildColumnPropertiesCache();

        // IF the name exists as a column => property cache key...
        if(array_key_exists($name, self::$columnPropertiesCache[$class]))
            // THEN return the column name as is!
            return $name;

        // OTHERWISE, we need to loop through all of the column => property pairings in the cache...
        foreach(self::$columnPropertiesCache[$class] as $column => $properties)
        {
            // IF the current column name is associated with a property matching the name provided...
            if(in_array($name, $properties))
                // THEN return the current column name.
                return $column;
        }

        // Nothing was matched, return NULL!
        return null;
    }

    /**
     * @return string
     * @throws ModelClassException
     * @throws \ReflectionException
     */
    private static function getTableName(): string
    {
        // Get the calling child class, ensuring that the Model class was not used!
        $class = self::getStaticChildClass();

        // IF the class => table name cache has already been built for this class...
        if(self::$tableNameCache !== null && array_key_exists($class, self::$tableNameCache))
            // THEN return the cached table name!
            return self::$tableNameCache[$class];

        // Create an AnnotationReader and get all of the annotations on properties of this class.
        $annotations = new AnnotationReader($class);

        // IF the child class has a @TableNameAnnotation...
        if($annotations->hasClassAnnotation("TableName"))
        {
            // Get the table name from the @TableNameAnnotation.
            $tableName = $annotations->getClassAnnotation("TableName");

            // Cache the class => table name.
            self::$tableNameCache[$class] = $tableName;
        }
        else
        {
            // OTHERWISE, attempt some auto conversions...

            // Get the class name without the namespace.
            $short = $annotations->getReflectedClass()->getShortName();

            // Add the snake_case form of the class name to the cache.
            self::$tableNameCache[$class] = self::camel2snake($short);
        }

        // THEN simply return that as the table name!
        return self::$tableNameCache[$class];
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Gets the calling child class name or throws a ModelClassException if Model was used directly!
     *
     * @return string Returns the child class name.
     * @throws ModelClassException
     */
    private static function getStaticChildClass(): string
    {
        // Get the calling class.
        $class = get_called_class();

        // IF the calling class is Model...
        if($class === __CLASS__)
            // THEN throw an Exception!
            throw new ModelClassException("The Model class cannot be used directly, as it is abstract!");

        // OTHERWISE, it is a child class, so return the class name!
        return $class;
    }

    // =================================================================================================================
    // METHODS: QUERYING
    // =================================================================================================================

    /**
     * Selects all rows from the database as a Collection of Model class objects.
     *
     * @return Collection Returns a Collection of Model objects with populated data from the database.
     * @throws DatabaseConnectionException
     * @throws ModelClassException
     * @throws \ReflectionException
     */
    public static function select(): Collection
    {
        // Ensure the database is connected!
        $pdo = Database::connect();

        // Get the calling child class, ensuring that the Model class was not used!
        $class = self::getStaticChildClass();

        // Get the table name from either a @TableNameAnnotation or an automated conversion from the class name...
        $tableName = self::getTableName();

        // Build the SQL statement.
        $sql = "SELECT * FROM $tableName";

        // Fetch the results from the database.
        $results = $pdo->query($sql)->fetchAll();

        // Create a new Collection to store the converted objects.
        $collection = new Collection($class, []);

        // Loop through each result...
        foreach($results as $result)
        {
            // Create a new object and populate it's properties.
            $object = new $class($result);

            // Append the new object to the collection.
            $collection->push($object);
        }

        // Finally, return the Collection!
        return $collection;
    }

    /**
     * Selects only the matching rows from the database as a Collection of Model class objects.
     *
     * @param string $column The column name on which to compare.
     * @param string $operator The operator to use for comparison.
     * @param mixed $value The value on which to compare.
     * @return Collection Returns a Collection of Model objects with populated data from the database.
     * @throws DatabaseConnectionException
     * @throws ModelClassException
     * @throws ModelMissingPropertyException
     * @throws \ReflectionException
     */
    public static function where(string $column, string $operator, $value): Collection
    {
        // Ensure the database is connected!
        $pdo = Database::connect();

        // Get the calling child class, ensuring that the Model class was not used!
        $class = self::getStaticChildClass();

        // Get the table name from either a @TableNameAnnotation or an automated conversion from the class name...
        $tableName = self::getTableName();

        // Lookup the correct column name.
        $column = self::getColumnName($column);

        // IF no matching column name could be determined, THEN throw an Exception!
        if($column === null)
            throw new ModelMissingPropertyException("Could not find a property '$column' of class '$class'.  ".
                "Are you missing a '@ColumnNameAnnotation' on a property?");

        // Build the SQL statement.
        $sql = "SELECT * FROM $tableName WHERE $column $operator ".
            (gettype($value) === "string" ? "'$value'" : "$value");

        // Fetch the results from the database.
        $results = $pdo->query($sql)->fetchAll();

        // Create a new Collection to store the converted objects.
        $collection = new Collection($class, []);

        // Loop through each result...
        foreach($results as $result)
        {
            // Create a new object and populate it's properties.
            $object = new $class($result);

            // Append the new object to the collection.
            $collection->push($object);
        }

        // Finally, return the Collection!
        return $collection;
    }

}