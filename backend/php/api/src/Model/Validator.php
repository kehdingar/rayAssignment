<?php

namespace Product\Model;

require "../../vendor/autoload.php";


use DataConfig\Model\Config\Crud;
use Product\Model\Book;
use Product\Model\DVD;
use Product\Model\Furniture;
use Product\Model\Product;
use Product\Model\Session;

new Book();
new Furniture();
new DVD();

class Validator
{
    private $data;
    private $crud;
    private $errors = [];
    private $no_error = false;

    private $validation_rules;

    // errror messages
    private $messages = [
        "required"  => "Please, submit required data",
        "number"    =>  "Please, provide the data of ",
        "invalidProdType" => "Invalid product type Please, provide the data of ",
        "duplicate" => "This value already exist"
    ];

    public function __construct($data, $validation_rules)
    {
        $this->crud = new Crud();
        $this->data = $data;
        $this->validation_rules = $validation_rules;
    }

    public function validate()
    {
        foreach ($this->validation_rules as $field => $rule) {
            $field_value = $this->getFieldValue($field);
            $rule = ucfirst($rule);
            $method_to_call = "validate$rule";

            $resultant_message = $this->$method_to_call($field_value, $field);

            if ($resultant_message) {
                $this->addError($resultant_message, $field);
            }
        }
    }

    public function getFieldValue($field)
    {
        return $this->data[$field];
    }

    public function validateRequired($value, $field)
    {
        return !empty($value) ? $this->no_error : $this->messages['required'];
    }

    public function validateNumber($value, $field)
    {
        if (!$value) {
            return $this->messages['required'];
        } else {
            try {
                $value = intval($value);
                if (!$value) {

                    return $this->messages['number'] . $field . " (number must be greater than 1)";
                }
                return preg_match("/^[0-9]*$/", $value) ? $this->no_error : $this->messages['number'] . $field . " (number must be greater than 1)";
            } catch (\Exception $e) {
                return preg_match("/^[0-9]*$/", $value) ? $this->no_error : $this->messages['required'] . $field . " (number must be greater than 1)";
            }
        }
    }

    public function validateType($value, $field)
    {
        if ($value == "") {
            return $this->messages['required'];
        }
        if (!in_array($value, array_keys(Product::getChildren()), true)) {
            return $this->messages['invalidProdType'] . "Product." . " [ $value ] is not valid ";
        }
    }

    public function validateSku($value, $field)
    {
        if ($value == "") {
            return $this->messages['required'];
        }

        $sku = Product::getSku();
        
        $query = "SELECT * FROM product WHERE sku='$sku'";
        $count = count($this->crud->read($query));
        if ($count) {
            return $this->messages['duplicate'];
        }
    }

    public function addError($resultant_message, $field)
    {
        $this->errors[$field] = $resultant_message;

        Session::set('errors', $this->errors);
    }

    public static function getErrorForField($field)
    {
        if (Session::exists('errors')) {
            $errors = Session::get('errors');

            if (key_exists($field, $errors)) {
                $error = $errors[$field];
                unset($_SESSION['errors'][$field]);
                return $error;
            }
        }
    }

    public function validates()
    {
        return empty($this->errors);
    }
}
