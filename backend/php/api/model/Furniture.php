<?php

class Furniture extends Product
{
    protected int $height = 0;
    protected int $width = 0;
    protected int $length = 0;
    private string $heightUnit = "CM";
    private string $widthUnit = "CM";
    private string $lengthUnit = "CM";
    private static string $displayName = "Furniture";

    public function __construct()
    {
        $this->formFields = [
            "height" => $this->heightUnit,
            "width" => $this->widthUnit,
            "length" => $this->lengthUnit
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
        return "Please, provide dimensions: HxWxL in " . $this->heightUnit;
    }

    public function getGeneratedFields(): string
    {
        return $this->generatedFields;
    }

    public static function getDisplayName(): string
    {
        return self::$displayName;
    }

    public function setHeight($height)
    {
        $height == null ? $this->height = 0 : $this->height = $height;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setWidth($width)
    {
        $width == null ? $this->width = 0 : $this->width = $width;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setLength($length)
    {
        $length == null ? $this->length = 0 : $this->length = $length;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
