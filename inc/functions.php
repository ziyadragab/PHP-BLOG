<?php

function validPage(int $page , int  $numberOfPages) {

    if($page>=1 and  $page<=$numberOfPages){
        return true;

    }else {
        $page=1;
        return false;

    }
}