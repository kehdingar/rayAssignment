<?php

require_once "Product.php";

class Book extends Product
{
    protected int $weight = 0;
    private string $weightUnit = "Kg";
    private static string  $displayName = "Book";
    protected array $formFields = array();

    public function __construct()
    {
        $this->formFields = [
            "weight" => $this->weightUnit
        ];
    }

    public function prepareFormFields(): array
    {
        foreach($this->formFields as $field => $unit){
            $fieldData = array($field =>[
                'unit' => $unit,
                'type' => $this->inputMapper($field)
            ]);
            array_push($this->preparedFormFieldData,$fieldData);
        }
         return $this->preparedFormFieldData;
    }


    public function generatedFields(): string
    {
        // fieldGenerator() in Parent
        return $this->generatedFields = $this->fieldGenerator($this->formFields);
    }

    public function getdescriptionMessage(): string
    {
        return "Please, provide weight in " . $this->weightUnit;
    }

    public function getFormFields(): array
    {
        return $this->formFields;
    }

    public function getGeneratedFields(): string
    {
        return $this->generatedFields;
    }

    public static function getDisplayName(): string
    {
        return self::$displayName;
    }

    public function setWeight($weight)
    {
        $weight == null ? $this->weight = 0 : $this->weight = $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getWeightUnit(): string
    {
        return $this->weightUnit;
    }
}
