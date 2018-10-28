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
     * @throws \ReflectionException
     */
    public function __construct(array $data = [])
    {
        // Get this class name.
        $class = get_class($this);

        // Create an AnnotationReader and get all of the annotations on properties of this class.
        $annotations = new AnnotationReader($class);
        $properties = $annotations->getPropertyAnnotations();

        // Initialize a collection of column => property names.
        $columnProperties = [];

        // Loop through each property annotation...
        foreach($properties as $property)
        {
            // Skip non-annotated properties!
            if($property === [])
                continue;

            // If the current property has a @ColumnNameAnnotation...
            if(array_key_exists("ColumnName", $property))
                // THEN add the column name and property name pairing to the collection!
                $columnProperties[$property["ColumnName"]][] = $property["var"]["name"];
            else
                // OTHERWISE add the property name to the collection, paired to itself!
                $columnProperties[$property["var"]["name"]][] = $property["var"]["name"];
        }

        // Loop through each key/value pair provided...
        foreach($data as $key => $value)
        {
            // IF the column name has a matching index in the collection...
            if(array_key_exists($key, $columnProperties))
            {
                // THEN set the current column's data on all properties annotated with this column name.
                foreach($columnProperties[$key] as $property)
                    $this->$property = $value;
            }
            else
            {
                // OTHERWISE no matching column => property pairing or @ColumnNameAnnotation was found!
                throw new ModelMissingPropertyException("Could not find a property '$key' of class '$class'.  ".
                    "Are you missing a '@ColumnNameAnnotation' on a property?");
            }
        }
    }

    /**
     * @return Collection
     * @throws \MVQN\Data\Exceptions\DatabaseConnectionException
     */
    public static function select(): Collection
    {
        $pdo = Database::connect();

        $sql = "SELECT * FROM option";

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

    public static function where(string $column, string $operator, string $value): Collection
    {
        $pdo = Database::connect();

        $sql = "SELECT * FROM option WHERE $column $operator $value";

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