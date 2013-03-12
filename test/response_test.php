<?php

  use Simplon\Border\Response;

  require __DIR__ . '/../vendor/autoload.php';

  (new Response())->sendJson(['name' => 'hansi']);