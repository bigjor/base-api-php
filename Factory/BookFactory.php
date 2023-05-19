<?php

class BookFactory {
  public static function findAll() {
    return [
      (object) array("title" => "Romeo y julieta", "pages" => 2),
      (object) array("title" => "Las drogas", "pages" => 3490)
    ];
  }
}