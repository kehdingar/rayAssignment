<?php

require_once "./../model/Product.php";
require_once "./../model/DVD.php";
require_once "./../model/Book.php";
require_once "./../model/Furniture.php";
include_once "./../model/config/Crud.php";

class ProductController
{
    private Product $type;
    private $crud;
    private array $validation_data = array();
    private array $validationRules = array();
    private array $productData = array();
    private array $bookData = array();
    private array $furnitureData = array();
    private array $dvdDiscData = array();
    private array $productIds = array();


    public function __construct()
    {
        $this->crud = new Crud;
    }

    public function setType(Product $type)
    {
        return $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getProductHTML()
    {
        return $this->type->generatedFields();
    }

    public function getDescriptionMessage()
    {
        return $this->type->getDescriptionMessage();
    }

    public function addProduct($data)
    {
        $validator = $this->validationBootstrap($data);
        $validator->validate();

        if ($validator->validates()) {
            // insert product in database
            $lastId = $this->crud->create($this->productData, 'product');
            $productType = Product::getType();
            $queryMethod = "create$productType";
            $this->$queryMethod($lastId);

            // message for front end
            $response = "success";
            echo json_encode($response);
        } else {
            $response = $_SESSION;
            echo json_encode($response);
        }
    }


    public function validationBootstrap($data)
    {
        // associative array values match second part of camel case validation method names in Validator.php
        $this->validationRules = [
            'type' => 'type',
            'sku' => 'sku',
            'name' => 'required',
            'price' => 'number'
        ];

        Product::setType($data['type']);
        Product::setName($data['name']);
        Product::setSku($data['sku']);
        Product::setPrice(json_decode($data['price']), true);

        // associative array keys matching database columns
        $this->productData = [
            'sku' => Product::getSku(),
            'name' => Product::getName(),
            'price' => Product::getPrice(),
            'type' => Product::getType(),
        ];

        $this->validation_data = $this->productData;

        // checking and calling the appropriate method for the product type that extends Product class
        if (Product::getType() != '' && in_array(Product::getType(), Product::getChildren())) {
            $type = Product::getType();
            $this->setType(new $type);

            // set up and call appropirate method
            $productMethodToCall = "add$type";
            $productTypeData = $this->$productMethodToCall($data);

            $this->validation_data += $productTypeData;
        }

        $validator = new Validator($this->validation_data, $this->validationRules);
        return $validator;
    }

    public function addBook($data)
    {
        $book = new Book();

        $book->setWeight(json_decode($data['weight']), true);

        $this->bookData += ['weight' => $book->getWeight()];

        $this->validationRules += ['weight' => 'number'];

        return $this->bookData;
    }

    public function addDVD($data)
    {
        $dvdDisc = new DVD();

        //
        $dvdDisc->setSize(json_decode($data['size']), true);

        $this->dvdDiscData += ['size' => $dvdDisc->getSize()];

        $this->validationRules += ['size' => 'number'];

        return $this->dvdDiscData;
    }

    public function addFurniture($data)
    {
        $furniture = new Furniture();

        $furniture->setHeight(json_decode($data['height']), true);
        $furniture->setWidth(json_decode($data['width']), true);
        $furniture->setLength(json_decode($data['length']), true);

        $this->furnitureData += ['height' => $furniture->getHeight()];
        $this->furnitureData += ['width' => $furniture->getWidth()];
        $this->furnitureData += ['length' => $furniture->getLength()];

        $this->validationRules += ['height' => 'number'];
        $this->validationRules += ['width' => 'number'];
        $this->validationRules += ['length' => 'number'];

        return $this->furnitureData;
    }


    public function createBook($productId)
    {
        $this->bookData += ['product_id' => $productId];
        $this->crud->create($this->bookData, 'book');
    }

    public function createDVD($productId)
    {
        $this->dvdDiscData += ['product_id' => $productId];
        $this->crud->create($this->dvdDiscData, 'dvd_disc');
    }

    public function createFurniture($productId)
    {
        $this->furnitureData += ['product_id' => $productId];
        $this->crud->create($this->furnitureData, 'furniture');
    }

    public function setProductIds(array $productIds)
    {
        $this->productIds = $productIds;
    }

    public function getProductIds()
    {
        return $this->productIds;
    }

    public function deleteProduct()
    {
        foreach ($this->getProductIds() as $key => $id) {

            $sql = "DELETE FROM product WHERE id = $id";
            $this->crud->delete($sql);
        }
    }
}
