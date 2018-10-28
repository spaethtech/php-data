<?php
declare(strict_types=1);

namespace MVQN\Data\Models;

use MVQN\Annotations\AnnotationReader;
use MVQN\Collections\Collection;
use MVQN\Dynamics\AutoObject;
use MVQN\Data\Database;
use MVQN\Data\Exceptions\ModelMissingPropertyException;

/**
 * Class DatabaseTable
 *
 * @package MVQN\UCRM\Data
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 * @final
 */
abstract class Model extends AutoObject
{
    /**
     * Model constructor.
     *
     * @param array $data An associative array of column name => column value pairs.
     * @throws ModelMissingPropertyException
     */
    public function __construct(array $data = [])
    {
        // Get this class name.
        $class = get_class($this);

        if (self::$columnPropertiesCache === null || !array_key_exists($class, self::$columnPropertiesCache) ||
            self::$columnPropertiesCache[$class] === null)
            self::buildColumnPropertiesCache();

        // Loop through each key/value pair provided...
        foreach($data as $key => $value)
        {
            // IF the column name has a matching index in the collection...
            if(array_key_exists($key, self::$columnPropertiesCache[$class]))
            {
                // THEN set the current column's data on all properties annotated with this column name.
                foreach(self::$columnPropertiesCache[$class][$key] as $propertyName)
                    $this->$propertyName = $value;
            }
            else
            {
                // OTHERWISE no matching column => property pairing or @ColumnNameAnnotation was found!
                throw new ModelMissingPropertyException("Could not find a property '$key' of class '$class'.  ".
                    "Are you missing a '@ColumnNameAnnotation' on a property?");
            }
        }
    }


    private static $columnPropertiesCache;

    private static function buildColumnPropertiesCache()
    {
        // Get this class name.
        $class = get_called_class();

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


    private static function verifyColumnName(string $columnName): ?string
    {
        // Get this class name.
        $class = get_called_class();

        if (self::$columnPropertiesCache === null || !array_key_exists($class, self::$columnPropertiesCache) ||
            self::$columnPropertiesCache[$class] === null)
            self::buildColumnPropertiesCache();

        if(array_key_exists($columnName, self::$columnPropertiesCache[$class]))
            return $columnName;

        foreach(self::$columnPropertiesCache[$class] as $column => $properties)
        {
            if(in_array($columnName, $properties))
                return $column;
        }

        return null;
    }

    /**
     * @return Collection
     * @throws \MVQN\Data\Exceptions\DatabaseConnectionException
     * @throws \ReflectionException
     */
    public static function select(): Collection
    {
        $pdo = Database::connect();

        $class = get_called_class();

        // Create an AnnotationReader and get all of the annotations on properties of this class.
        $annotations = new AnnotationReader($class);

        if($annotations->hasClassAnnotation("TableName"))
            $tableName = $annotations->getClassAnnotation("TableName");
        else
            $tableName = lcfirst($annotations->getReflectedClass()->getShortName());

        $sql = "SELECT * FROM $tableName";

        $results = $pdo->query($sql)->fetchAll();

        //$class = get_called_class();

        $collection = new Collection($class, []);

        foreach($results as $result)
        {
            $object = new $class($result);
            $collection->push($object);
        }

        return $collection;
    }

    public static function where(string $column, string $operator, $value): Collection
    {
        $pdo = Database::connect();

        $class = get_called_class();

        // Create an AnnotationReader and get all of the annotations on properties of this class.
        $annotations = new AnnotationReader($class);

        if($annotations->hasClassAnnotation("TableName"))
            $tableName = $annotations->getClassAnnotation("TableName");
        else
            $tableName = lcfirst($annotations->getReflectedClass()->getShortName());

        $column = self::verifyColumnName($column);

        $sql = "SELECT * FROM $tableName WHERE $column $operator ".
            (gettype($value) === "string" ? "'$value'" : "$value");

        $results = $pdo->query($sql)->fetchAll();

        $class = get_called_class();

        $collection = new Collection($class, []);

        foreach($results as $result)
        {
            $object = new $class($result);
            $collection->push($object);
        }

        return $collection;
    }

}