<?php
    function validate($record) 
    {
        $allowed = array(".", "-", "_", "@", " ");
        if(ctype_alnum(str_replace($allowed, '', $record))) {
            return true;
        }else{
            return false;
        }
    }
?>