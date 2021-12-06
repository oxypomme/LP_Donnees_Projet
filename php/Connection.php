<?php

namespace Nancy;

class Connection
{
  const DATABASE = 'nancy';

  /**
   * @var \MongoDB\Client
   */
  public object $db;

  public function __construct()
  {
    $this->db = (new \MongoDB\Client('mongodb://mongo'))->selectDatabase(self::DATABASE);
  }
}
