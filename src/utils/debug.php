<?php

declare(strict_types=1);


//------------ set 0_ALL and false before prod. ---------------------------
error_reporting(E_ALL);
ini_set('display_errors', '1');

function dump($data)
{
    echo '</br><div class="cont" style="display: inline-block; padding: 0 20px; background: lightgray; border: 1px solid black;">
        <pre>';
    echo print_r($data, true);
    echo '<pre>
        </div></br></br><br>';
}