<?php

// Template functions
function __(string $text)
{
    echo(htmlspecialchars($text));
}