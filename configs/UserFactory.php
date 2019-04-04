<?php

final class UserFactory
{

    private $con = null;
    public $validated = false;
    public $email;
    public $name;
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
        $this->con = new mysqli('192.168.1.8','hoteltest','hoteltest','db462252800');
        if ($this->con->connect_error)
        {
            die("fehler mysqli config: ". $this->con->connect_error);
        }
    }

    public function Login($username, $password)
    {
        if ($stmt = $this->con->prepare("SELECT h.hotel_id, h.hotel_email, h.hotel_name FROM th_hotels h inner join th_hotel_passwords p on (p.hotel_id = h.hotel_id)  WHERE h.hotel_email=? and p.password=unhex(md5(?))"))
        {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->bind_result($hotel_id, $hotel_email, $hotel_name);
            if ($stmt->fetch())
            {
                $this->validated=true;
                $this->email = $hotel_email;
                $this->id_hotel = $hotel_id;
                $this->name = $hotel_name;
            }
        }
    }

    public function FindEmail($email)
    {
        if ($stmt = $this->con->prepare("SELECT h.hotel_id, h.hotel_name FROM th_hotels h WHERE h.hotel_email=?"))
        {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($hotel_id, $hotel_name);
            if ($stmt->fetch())
            {
                return array('hotel_id'=>$hotel_id, 'hotel_name'=>$hotel_name);
            }
        }

        return false;
    }

    public function LoginById($id)
    {
        if ($stmt = $this->con->prepare("SELECT h.hotel_id, h.hotel_email, h.hotel_name FROM th_hotels h WHERE  h.hotel_id = ?"))
        {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($hotel_id, $hotel_email, $hotel_name);
            if ($stmt->fetch())
            {
                $this->validated=true;
                $this->email = $hotel_email;
                $this->id_hotel = $hotel_id;
                $this->name = $hotel_name;
            }
        }
    }

    public function SetPasswordLink()
    {
        if ($this->validated)
        {
            $code = $this->getToken(32);
            if ($stmt = $this->con->prepare("update th_hotel_passwords set chpwd_code = ?, chpwd_code_expires = unix_timestamp()+30*60 where hotel_id = ?"))
            {
                $stmt->bind_param("si", $code, $this->id_hotel);
                $stmt->execute();
                return $code;
            }
        }

        return false;
    }

    public function VerifyToken($hotel_id, $token)
    {
        if ($stmt = $this->con->prepare("select hotel_id from th_hotel_passwords where unix_timestamp() < chpwd_code_expires and  chpwd_code = ? and hotel_id = ?"))
        {
            $stmt->bind_param("si", $token, $hotel_id );
            $stmt->execute();
            $stmt->bind_result($hotel_id);
            if ($stmt->fetch())
            {
                return true;
            }
        }

        return false;
    }

    public function SetPassword($hotel_id, $password)
    {
        if ($stmt = $this->con->prepare("update th_hotel_passwords set chpwd_code = '', chpwd_code_expires=0, password=unhex(md5(?)) where hotel_id = ?"))
        {
            $stmt->bind_param("si",$password, $hotel_id);
            $stmt->execute();
        }
    }

    public function GetProzente()
    {
        if ($this->validated)
        {
            if ($stmt = $this->con->prepare("SELECT prozente_id,prozent_name from th_hotel_prozente where hotel_id = ?"))
            {
                $stmt->bind_param("i",$this->id_hotel);
                $stmt->execute();
                $stmt->bind_result($prozent_id, $prozent_name);
                $result = array();
                while($row=$stmt->fetch())
                {
                    $result[] = array('prozent_id'=>$prozent_id, 'prozent_name'=>$prozent_name);
                }

                return $result;
            }
        }

        return false;
    }

    public function GetAktionen()
    {
        if ($this->validated)
        {
            if ($stmt = $this->con->prepare("SELECT aktion_id,aktion_name,selected from th_hotel_rabatt_aktion where hotel_id = ?"))
            {
                $stmt->bind_param("i",$this->id_hotel);
                $stmt->execute();
                $stmt->bind_result($aktion_id,$aktion_name,$selected);
                $result = array();
                while($stmt->fetch())
                {
                    $result[] = array(
                        'aktion_id' => $aktion_id,
                        'aktion_name' => $aktion_name,
                        'aktion_selected' => $selected
                        );
                }

                return $result;
            }
        }

        return false;
    }

    private function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    private function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
        }
        return $token;
    }
}

if (isset($_SESSION['user']))
{
    $tmpUser = unserialize($_SESSION['user']);
    $user = UserFactory::Instance();
    $user->LoginById($tmpUser->id_hotel);
}




