<?php

//General set of custom functions to be used for this project helper fiel



function preprint($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function print_money($value){
    return money_format('$%i',$value);
}

function percentage($value){
    return round((float)$value * 100, 3) . '%';
}

function asset_url(){
    return base_url().'assets/';
}

function img_url(){
    return base_url().'assets/imgs/';
}