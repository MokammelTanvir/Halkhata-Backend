<?php

namespace App\Repositories\Cart;

interface CartInterface
{
    public function getCartItems();
    public function addToCart($data);
    public function removeFromCart($id);
    public function incItemQty($id);
    public function decItemQty($id);
}
