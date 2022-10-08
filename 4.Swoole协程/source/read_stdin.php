<?php

while(true) {
    $line = fgets(STDIN);
    if ($line) {
        echo $line, "123123";
    } else {
        break;
    }
}