<?php

namespace dwp\core;

abstract class Model
{
    // useful types for schema
    const TYPE_STRING   = 'string';
    const TYPE_INTEGER  = 'int';
    const TYPE_UINTEGER = 'uint';
    const TYPE_DECIMAL  = 'dec';
    const TYPE_DATE     = 'date';
    const TYPE_JSON     = 'json';

    protected $schema = [
    ];

    private $values = [
    ];

    public static function tablename()
    {
        $class = get_called_class();
        if(defined($class.'::TABLENAME'))
        {
            return $class::TABLENAME;
        }
        return null;
    }

    public static function find(/* TODO: Add Arguments */)
    {
        // TODO: Implement the find
    }

    public static function findOne(/* TODO: Add Arguments */)
    {
        // TODO: Implement the find
        //       Easy implementation of this method is, calling find() and reduce the array to one item or null
    }


    public function __construct($values)
    {
        // TODO: Write values using the magic methods
    }

    public function __set($key, $value)
    {
        // TODO: Check is the key in the schema?
        //       If set the new value to the $this->values array
    }

    public function __get($key)
    {
        // TODO: Check is the key in the schema?
        //       If so return the value in values if not exists return default value from schema or null
    }

    public function __destruct()
    {
        // TODO: Free memory here
    }

    public function insert()
    {
        // TODO: Implement insert
    }

    public function update()
    {
        // TODO: Implement update
    }

    public function destroy()
    {
        // TODO: Implement destroy / delete
    }
}