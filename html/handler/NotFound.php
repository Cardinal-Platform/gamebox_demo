<?php

class NotFound
{
    public function index()
    {
        $this->show('header.html');
        $this->show('404.html');
        $this->show('footer.html');
    }
}