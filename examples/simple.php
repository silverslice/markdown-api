<?php

require __DIR__ . '/../vendor/autoload.php';

$g = new Silverslice\MarkdownApi\Generator();
$g->generate('Silverslice\MarkdownApi\Generator')->output();