<?php

    function create($class, $arttribute = [], $time = null)
    {
        return factory($class,$time)->create($arttribute);
    }   

    function make($class, $arttribute = [], $time = null)
    {
        return factory($class,$time)->make($arttribute);
    }   