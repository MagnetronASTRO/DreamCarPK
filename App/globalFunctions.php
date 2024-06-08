<?php

function my_log(mixed $error, bool $stop = false): void
{
    error_log(
        print_r($error, $stop)
    );
}