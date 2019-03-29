<?php

final class UserFactory
{

    private $con = null;
    public $validated = false;
    public $email;
    public $id_hotel;

    /**
     * Call this method to get singleton
     *
     * @return UserFactory
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new UserFactory();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->con = new mysqli('192.168.1.9','hoteltest','hoteltest','db462252800');
        if ($this->con->connect_error)
        {
            die("fehler mysqli config: ". $this->con->connect_error);
        }
    }

    public function Login($username, $password)
    {
        if ($stmt = $this->con->prepare("SELECT h.hotel_id, h.hotel_email FROM th_hotels h inner join th_hotel_passwords p on (p.hotel_id = h.hotel_id)  WHERE h.hotel_email=? and p.password=unhex(md5(?))"))
        {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->bind_result($hotel_id, $hotel_email);
            if ($stmt->fetch())
            {
                $this->validated=true;
                $this->email = $hotel_email;
                $this->id_hotel = $hotel_id;
            }
        }
    }
}




