<?php
namespace App\Exception;

class ClientNotFoundException extends \Exception
{
protected $message = "Un client doit être associé à la commande.";
}