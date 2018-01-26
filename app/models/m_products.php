<?php

/**
 * Handles all tasks related to retrieving and displaying products
 *
 * Class Products
 */
class Products
{
    private $Database;

    private $dbTable = 'products';

    function __construct()
    {
        global $Database;
        $this->Database = $Database;
    }

///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////*Setters & Getters*///////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Retrieves product information from database
     * @param int $id
     * @return array
     */
    public function get($id = null)
    {
        $data = [];
        if (is_array($id)) {
            //get products based on array of ids
        } else if ($id != null) {
            //get one specific product
            if ($stmt = $this->Database->prepare("SELECT 
            $this->dbTable.id,
            $this->dbTable.name,
            $this->dbTable.description,
            $this->dbTable.price,
            $this->dbTable.image,
            categories.name AS category_name
            FROM $this->dbTable, categories
            WHERE $this->dbTable.id = ? AND $this->dbTable.category_id = categories.id")) {

                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($prod_id, $prod_name, $prod_description,
                    $prod_price, $prod_image, $cat_name);
                $stmt->fetch();

                if ($stmt->num_rows > 0) {
                    $data = ['id' => $prod_id, 'name' => $prod_name, 'description' => $prod_description,
                        'price' => $prod_price, 'category_name' => $cat_name];
                }
                $stmt->close();
            }
        } else {
            //get all products
            if ($result = $this->Database->query("SELECT * FROM " . $this->dbTable . " ORDER BY name")) {
                while ($row = $result->fetch_array()) {
                    $data[] = [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'image' => $row['image']
                    ];
                }
            }
        }
        return $data;
    }

///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////*Create Page Elements*////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Create product table using info from database
     * @param int|null $cols
     * @param int|null $category
     * @return string
     */
    public function createProductTable($cols = 4, $category = null)
    {
        //get products
        if ($category != null) {
            //get products from specific category

        } else {
            $products = $this->get();
        }

        $data = '';

        //loop through each product
        if (!empty($products)) {
            $i = 1;
            foreach ($products as $product) {
                $data .= '<li';
                if ($i == $cols) {
                    $data .= ' class="last"';
                    $i = 0;
                }
                $data .= '><a href="' . SITE_PATH . 'product.php?id=' . $product['id'] . '">';
                $data .= '<img src="' . IMAGE_PATH . $product['image'] . '"alt="' . $product['name'] . '"><br>';
                $data .= '<strong>' . $product['name'] . '</strong></a><br/>$' . $product['price'];
                $data .= '<br><a class="button_sml" href="' . SITE_PATH . 'cart.php?id=' . $product['id'] . '">
                            Add to Cart</a></li>';
                $i++;
            }
        }
        return $data;
    }
}

