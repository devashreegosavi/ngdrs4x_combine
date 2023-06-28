<?php
namespace App\Model\Entity;

use Authentication\PasswordHasher\LegacyPasswordHasher; // Add this line
use Cake\ORM\Entity;

class User extends Entity
{
    // Code from bake.

    // Add this method
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new LegacyPasswordHasher())->hash($password);
        }
    }
}