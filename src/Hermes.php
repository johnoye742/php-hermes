<?php
namespace Johnoye742\PhpHermes;

class Hermes {
  public $hostname;
  public $port;
  public $hermes;

  public function __construct($hostname, $port) {
    $this -> hostname = $hostname;
    $this -> port = $port;
    $this -> hermes = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not connect");

      $socket = socket_connect($this -> hermes, $this -> hostname, $this -> port);
     

      if($socket === false)  {
        throw new \Exception("Could not connect to Hermes check that you specified the right info and the server is up");
        return false;
      }
  }

  /**
   * @param $key
   * @param $value
   * @method set
   * @return boolean
   */
  public function set(string $key, string $value) : boolean {
    // Message to be sent to hermes-server
    $message = "SET $key $value \n";

    // Write the message to the hermes-server and if successful return true
    if(socket_write($this -> hermes, $message, strlen($message))) return true;

    // Return false if not successful
    return false;
  }

  /**
   * @param $key
   * @method get
   * @return mixed
   */
  public function get(string $key) : mixed {
    // Message to be sent to hermes-server
    $message = "GET $key \n";

    // Write the message to the hermes-server and if successful return true
    if(socket_write($this -> hermes, $message, strlen($message))) return socket_read($this -> hermes, 1024);

    return false;
  }

  /**
   * @param $key
   * @param $value
   * @method arrayPush
   * @return mixed
   */
  public function arrayPush(string $key, string $value) : mixed {
    $message = "ARRAY_PUSH $key $value \n";

    if(socket_write($this -> hermes, $message, strlen($message))) {
      socket_read($this -> hermes, 1024);
      return true; 
    }
    
    return false;
  }

  /**
   * @param $key
   * @method arrayGet
   * @return mixed
   */
  public function arrayGet(string $key) : mixed {
    // Message to be sent to hermes-server
    $message = "ARRAY_GET $key \n";

    // Write the message to the hermes-server and if successful return true
    if(socket_write($this -> hermes, $message, strlen($message))) return json_decode(socket_read($this -> hermes, 1024));

    return false;
  }
}
