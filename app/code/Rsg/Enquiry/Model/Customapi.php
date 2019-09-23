<?php
namespace Rsg\Enquiry\Model;
use Rsg\Enquiry\Api\CustomapiInterface; 
class Customapi implements CustomapiInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function name($name) {
        return "Hello, " . $name;
    }
}
