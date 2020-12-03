<?php

namespace App;

interface View
{
    public function render(?array $datavie = null, ?string $template = null);
    // public function json();
}
