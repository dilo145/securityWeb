<?php
require 'vendor/autoload.php'; // Include this only if Symfony components are needed

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

// Create a password hasher instance
$factory = new PasswordHasherFactory([
    'common' => ['algorithm' => 'bcrypt'],
]);

$passwordHasher = $factory->getPasswordHasher('common');

// Replace 'your-plain-password' with the desired password
$hashedPassword = $passwordHasher->hash('secret');

echo "Hashed password: $hashedPassword\n";
