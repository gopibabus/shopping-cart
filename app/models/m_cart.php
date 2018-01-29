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
     * Update the quantity of specific item in the cart
     *
     * @param int $id
     * @param int $num
     * @return null
     */
    public function update($id, $num)
    {
        if ($num == 0) {
            unset($_SESSION['cart'][$id]);

        } else {
            $_SESSION['cart'][$id] = $num;
        }
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

    /**
     * Return total number of items in the cart
     * @return int
     */
    public function getTotalItems()
    {
        $num = 0;
        if(isset($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $item){
                $num = $num +$item;
            }
        }
        return $num;
    }

    /**
     * Return total cost of all items in the cart
     * @return int
     */
    public function getTotalCost(){
        $num = '0.00';

        if(isset($_SESSION['cart'])){
            //if items to display

            //get products ids
            $ids = $this->getIds();

            //get product prices
            global $Products;
            $prices = $Products->getPrices($ids);

            //loop through, adding the cost of each item
            // X the number of items in the cart to $num each time

            foreach ($prices as $price) {
                $num += doubleval($price['price'] * $_SESSION['cart'][$price['id']]);
            }
        }
        return $num;
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
                $data .= '><div class="col1">' . $product['name'] . '</div>';
                $data .= '<div class="col2"><input name="product' . $product['id'] . '" value="' . $_SESSION['cart'][$product['id']] . '" ></div>';
                $data .= '<div class="col3">$' . $product['price'] . '</div>';
                $data .= '<div class="col4">$' . $product['price'] * $_SESSION['cart'][$product['id']] . '</div></li>';

                $total += $product['price'] * $_SESSION['cart'][$product['id']];
                $line++;

            }
            //add subtotal row
            $data .= '<li class="subtotal_row">
                        <div class="col1">SubTotal:</div>
                        <div class="col2">$' . $total . '</div>
                        </li>';

            //taxes
            if(SHOP_TAX > 0){
                $data .= '<li class="taxes_row"><div class="col1"> Tax('.(SHOP_TAX * 100).'%)</div>
                            <div class="col2">$'.number_format(SHOP_TAX * $total, 2).
                            '</div></li>';
            }

            //add total row
            $data .= '<li class="total_row">
                        <div class="col1">Total:</div>
                        <div class="col2">$' . $total . '</div>
                        </li>';
        } else {
            //no products to display
            $data .= '<li><strong>No items in the Cart!</strong></li>';

            //add subtotal row
            $data .= '<li class="subtotal_row">
                        <div class="col1">SubTotal:</div>
                        <div class="col2">$0.00:</div>
                        </li>';

            //taxes
            if(SHOP_TAX > 0){
                $data .= '<li class="taxes_row"><div class="col1"> Tax('.(SHOP_TAX * 100).'%)</div>
                            <div class="col2">$0.00</div></li>';
            }


            //add total row
            $data .= '<li class="total_row">
                        <div class="col1">Total:</div>
                        <div class="col2">$0.00:</div>
                        </li>';
        }
        return $data;
    }
}