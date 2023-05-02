<?php
namespace ProductProcessing\Controller;

require "../../vendor/autoload.php";

use DataConfig\Model\Config\Crud;
use Product\Model\Book;
use Product\Model\DVD;

class ListProducts
{
    private $queryResults;
    private $crud;
    private $limit;
    private $offset;
    private $totalRows;

    public function __construct()
    {
        $this->crud = new Crud();
        $sql = "SELECT id FROM product";
        $totalRows = $this->crud->read($sql);
        $this->totalRows = count($totalRows);
    }

    public function queryProducts()
    {
        $book = new Book();
        $dvdDisc = new DVD();

        $weightUnit = $book->getWeightUnit();
        $sizeUnit = $dvdDisc->getSizeUnit();

        $query = "SELECT p.id,sku,name,p.price,CONCAT_WS(' $weightUnit',weight,'') weight,
                    CONCAT_WS(' $sizeUnit',size,'') size, CONCAT_WS('x',height,width,length) dimensions,type   
                    FROM product p 
                    LEFT JOIN book b 
                    ON b.product_id=p.id 
                    LEFT JOIN dvd_disc d 
                    ON d.product_id=p.id 
                    LEFT JOIN furniture f 
                    ON f.product_id=p.id 
                    ORDER BY p.id DESC";

        $results = $this->crud->read($query);
        return $this->queryResults = $results;
    }

    public function getTotalRows()
    {
        return $this->totalRows;
    }

    public function getProducts()
    {
        return $this->queryResults;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }
}
