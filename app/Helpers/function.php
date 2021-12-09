<?php

function handlePriceDiscount($priceOld , $discount){
    return  $priceOld - ($priceOld * ($discount / 100)) ;
}

?>