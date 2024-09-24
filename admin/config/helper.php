<?php

// fungsi sanitize
function sanitize($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    
    return $data;
}