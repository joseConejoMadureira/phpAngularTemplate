<?php

namespace src\Dao;

use LogsW;
use PDO;
use PDOException;
use src\Model\Product;

class DaoProduct
{
    public $connection;
    function __construct()
    {
        $this->connection = ConnectionPDO::getInstance();
    }


    public function read()
    {
        $sql = "SELECT * FROM PRODUCTS";

        try {
            return $this->connection->query($sql)
                ->fetchAll(PDO::FETCH_CLASS, Product::class);
        } catch (PDOException $e) {

            LogsW::write($e);
            return 'error read products';
        }
    }
    public function create(Product $product)
    {
        $statement = "
        INSERT INTO products 
            ( name, price)
        VALUES
            (:name, :price);";

        try {

            return $this->connection->prepare($statement)
                ->execute(array(
                    'name' => $product->name,
                    'price' => $product->price
                ));
        } catch (PDOException $e) {

            LogsW::write($e);
            return 'error read products';
        }
    }
    public function readById($id)
    {
        $sql = "SELECT * FROM PRODUCTS WHERE ID=" . $id;


        try {

            return $result =  $this->connection->query($sql)
                ->fetchObject();
        } catch (PDOException $e) {

            LogsW::write($e);
            return 'error read products';
        }
    }
    public function delete($id)
    {
        $sql = "DELETE FROM PRODUCTS WHERE id=" . $id;
        try {

            return $result =  $this->connection->query($sql)
                ->rowCount();
        } catch (PDOException $e) {

            LogsW::write($e);
            return 'error read products';
        }
    }
    public function update($id, Product $product)
    {

        $statement = 'UPDATE PRODUCTS '
            . 'SET name = :name, '
            . 'price = :price '
            . 'WHERE id = :id';

        try {

            $stmt = $this->connection->prepare($statement);
            $stmt->bindValue('name', $product->name);
            $stmt->bindValue('price', $product->price);
            $stmt->bindValue('id', $product->id);
   
            $stmt->execute();

        } catch (PDOException $e) {

            LogsW::write($e);
            return 'error read products';
        }
    }
}
