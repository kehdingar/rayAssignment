<?php

class DVD extends Product
{
    protected int $size = 0;
    private string $sizeUnit = "MB";
    public static string $displayName = "DVD-disk";

    public function __construct()
    {
        $this->formFields = [
            "size" => $this->sizeUnit
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
        return "Please, provide disk space in " . $this->sizeUnit;
    }

    public function getGeneratedFields(): string
    {
        return $this->generatedFields;
    }

    public static function getDisplayName(): string
    {
        return self::$displayName;
    }

    public function setSize($size)
    {
        $size == null ? $this->size = 0 : $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getSizeUnit(): string
    {
        return $this->sizeUnit;
    }
}
