<?php

    function create($class, $arttribute = [])
    {
        return factory($class)->create($arttribute);
    }   

    function make($class, $arttribute = [])
    {
        return factory($class)->make($arttribute);
    }   