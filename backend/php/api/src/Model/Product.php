<?php

namespace Product\Model;

abstract class Product
{
    protected string $generatedFields = "";
    protected array $formFields = array();
    protected array $inputMapper = array(
        "integer" => "number",
        "string" => "text"
    );

    private static string $sku;
    private static string $name;
    private static float $price;
    private static string $type;
    private static int $prdocutId;
    protected array $preparedFormFieldData = array();

    public abstract function prepareFormFields(): array;

    public abstract function getdescriptionMessage(): string;

    public abstract static function getDisplayName(): string;


    protected function inputMapper($field): string
    {
        return $this->inputMapper[(gettype($this->$field))] ?? "";
    }

    public static function getChildren()
    {
        $types = array();
        foreach (get_declared_classes() as $type) {
            if (is_subclass_of($type, 'Product\\Model\\Product')) {
                $typeName = explode('\\', $type);
                $types[end($typeName)] = $type;
            }
        }

        return $types;
    }

    public static function setSku($sku)
    {
        self::$sku = $sku;
    }

    public static function getSku()
    {
        return self::$sku;
    }

    public static function setName($name)
    {
        self::$name = $name;
    }

    public static function getName(): string
    {
        return self::$name;
    }

    public static function setPrice($price)
    {
        if ($price == null) {
            self::$price = 0.00;
        } else {
            self::$price = $price;
        }
    }

    public static function getPrice(): int
    {
        return self::$price;
    }

    public static function setType($type)
    {
        self::$type = $type;
    }

    public static function getType(): string
    {
        return self::$type;
    }

    public static function getPrdocutId()
    {
        return self::$prdocutId;
    }

    public static function setPrdocutId($prdocutId)
    {
        $prdocutId == null ? self::$prdocutId = 0 : self::$prdocutId = $prdocutId;
    }

    public static function getTableMap()
    {
        $tableMap = [
            'DVD' => 'dvd_disc',
            'Book' => 'book',
            'Furniture' => 'furniture',
        ];
        return $tableMap;
    }

    public static function getFields()
    {
        return ['sku', 'name', 'price', 'type'];
    }
}
