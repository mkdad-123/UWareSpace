<?php

namespace App\DTOs;

class AdminRegisterDto
{
    public string $name;
    public string $email;
    public string $location;
    public string $password;

    public function __construct($request)
    {
        $this->name = $request->name;
        $this->email = $request->location;
        $this->password = $request->password;
        $this->location = $request->location;
    }

}
