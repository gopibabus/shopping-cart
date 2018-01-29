<?php

/**
 * Handle all tasks related to showing or modifying the number of items in cart
 *
 * The cart keeps tracks of user selected items using a session variable, $_SESSION['cart']
 *
 * The session variable holds an array that contains the ids and the number selected products in the cart.
 * $SESSION['cart']['product_id'] = number of specific items in the cart
 *
 * Class Cart
 */
class Cart
{

    public function __construct()
    {

    }

///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////*Setters & Getters for Cart*/////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return an array of all product info for items in the cart
     * @return array|null
     */
    public function get()
    {
        if (isset($_SESSION['cart'])) {
            //get all product ids of items in the cart
            $ids = $this->getIds();

            //use list to get product info
            global $Products;
            return $Products->get($ids);
        }
        return null;
    }

    /**
     * Return all product ids in cart
     *
     * @return array|null
     */
    public function getIds()
    {
        if (isset($_SESSION['cart'])) {
            return array_keys($_SESSION['cart']);
        }
        return null;
    }

    /**
     * Adds item to the cart
     *
     * @param int $id
     * @param int $num
     * @return null
     */
    public function add($id, $num = 1)
    {

        //setup or retrieve cart
        $cart = [];
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        }

        //check to see item that needed to be added is already in the cart

        if (isset($cart[$id])) {
            //if item is in the cart
            $cart[$id] = $cart[$id] + $num;
        } else {
            //if item is not in the cart
            $cart[$id] = $num;
        }
        $_SESSION['cart'] = $cart;
    }

    /**
     * Empty all items from the cart
     *
     * @return null
     */
    public function emptyCart()
    {
        unset($_SESSION['cart']);
    }

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////*Create Page Parts*////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


    /**
     * Return list item for each product in the cart
     *
     * @return string
     */
    public function createCart()
    {
        //get products currently in the cart
        $products = $this->get();

        $data = '';

        $total = 0;

        $data .= '<li class="header_row">
                    <div class="col1">Product Name:</div>
                    <div class="col2">Quantity:</div>
                    <div class="col3">Product Price:</div>
                    <div class="col4">Total Price:</div>
                    </li>';
        if ($products != '') {
            //products to display
            $line = 1;
            foreach ($products as $product) {
                //create new item in the cart
                $data .= '<li ';
                if ($line % 2 == 0) {
                    $data .= ' class="alt"';
                }
                $data .= '><div class="col1">' .$product['name'].'</div>';
                $data .= '<div class="col2"><input name="product'.$product['id'].'" value="'.$_SESSION['cart'][$product['id']].'" ></div>';
                $data .= '<div class="col3">$'.$product['price'].'</div>';
                $data .= '<div class="col4">$'.$product['price'] * $_SESSION['cart'][$product['id']].'</div></li>';

                $total += $product['price'] * $_SESSION['cart'][$product['id']];
                $line++;

            }
            //add subtotal row
            $data .= '<li class="subtotal_row">
                        <div class="col1">SubTotal:</div>
                        <div class="col2">$'.$total.'</div>
                        </li>';
            //add total row
            $data .= '<li class="total_row">
                        <div class="col1">Total:</div>
                        <div class="col2">$'.$total.'</div>
                        </li>';
        } else {
            //no products to display
            $data .= '<li><strong>No items in the Cart!</strong></li>';

            //add subtotal row
            $data .= '<li class="subtotal_row">
                        <div class="col1">SubTotal:</div>
                        <div class="col2">$0.00:</div>
                        </li>';
            //add total row
            $data .= '<li class="total_row">
                        <div class="col1">Total:</div>
                        <div class="col2">$0.00:</div>
                        </li>';
        }
        return $data;
    }
}