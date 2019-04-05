<?php

final class UserFactory
{

    private $pdo = null;
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
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ERRMODE_EXCEPTION => 1
        ];
        
        $this->pdo = new PDO('mysql:host=192.168.1.8;dbname=db462252800', 'hoteltest', 'hoteltest', $options);
    }

    public function Login($username, $password)
    {
        if ($stmt = $this->pdo->prepare("SELECT h.hotel_id, h.hotel_email, h.hotel_name FROM th_hotels h inner join th_hotel_passwords p on (p.hotel_id = h.hotel_id)  WHERE h.hotel_email=:email")) // and p.password=unhex(md5(:password))"))
        {
            $stmt->execute(array(':email'=>$username));
            $x = $stmt->rowCount();
            if ($row = $stmt->fetch())
            {
                $this->validated=true;
                $this->email = $row['hotel_email']; // $hotel_email;
                $this->id_hotel = $row['hotel_id']; //$hotel_id;
                $this->name = $row['hotel_name']; //$hotel_name;
            }
        }
    }

    public function FindEmail($email)
    {
        if ($stmt = $this->pdo->prepare("SELECT h.hotel_id, h.hotel_name FROM th_hotels h WHERE h.hotel_email=?"))
        {
            $stmt->execute(array($email));
            if ($row = $stmt->fetch())
            {
                $result = array('hotel_id'=> $row['hotel_id'], 'hotel_name'=>$row['hotel_name']);
            }
            
            $stmt->closeCursor();
        }
        if (isset($result))
        {
            return $result;
        }
        
        return false;
    }

    public function LoginById($id)
    {
        if ($stmt = $this->pdo->prepare("SELECT h.hotel_id, h.hotel_email, h.hotel_name FROM th_hotels h WHERE  h.hotel_id = ?"))
        {
            $stmt->execute(array($id));
            if ($row = $stmt->fetch())
            {
                $this->validated=true;
                $this->email = $row['hotel_email'];
                $this->id_hotel = $row['hotel_id'];
                $this->name = $row['hotel_name'];
            }
            
            $stmt->closeCursor();
        }
    }

    public function SetPasswordLink()
    {
        if ($this->validated)
        {
            $code = $this->getToken(32);
            if ($stmt = $this->pdo->prepare("update th_hotel_passwords set chpwd_code = ?, chpwd_code_expires = unix_timestamp()+30*60 where hotel_id = ?"))
            {
                $stmt->execute(array($code, $this->id_hotel));
                $result = $code;
                $stmt->close();
            }
        }
        if (isset($result))
        {
            return $result;
        }
        
        return false;
    }

    public function VerifyToken($hotel_id, $token)
    {
        if ($stmt = $this->pdo->prepare("select hotel_id from th_hotel_passwords where unix_timestamp() < chpwd_code_expires and  chpwd_code = ? and hotel_id = ?"))
        {
            $stmt->execute(array( $token, $hotel_id ));
            if ($row = $stmt->fetch())
            {
                $result = true;
            }
            
            $stmt->closeCursor();
        }

        if (isset($result))
        {
            return $result;
        }
        
        return false;
    }

    public function SetPassword($hotel_id, $password)
    {
        if ($stmt = $this->pdo->prepare("update th_hotel_passwords set chpwd_code = '', chpwd_code_expires=0, password=unhex(md5(?)) where hotel_id = ?"))
        {
            $stmt->execute(array($password, $hotel_id));
            $stmt->close();
        }
    }

    public function GetProzente()
    {
        if ($this->validated)
        {
            if ($stmt = $this->pdo->prepare("SELECT prozente_id,prozent_name from th_hotel_prozente where hotel_id = ?"))
            {
                $stmt->execute(array($this->id_hotel));
                $result = array();
                while($row = $stmt->fetch())
                {
                    $result[] = array('prozent_id'=>$row['prozente_id'], 'prozent_name' => $row['prozent_name']);
                }

                $stmt->closeCursor();
            }
        }

        if (isset($result))
        {
            return $result;
        }
        
        return false;
    }
    
    public function GetProzentById($id)
    {
        $id = (int)$id;
        if ($this->validated)
        {
            if (($stmt = $this->pdo->prepare("SELECT prozente_id,prozent_name from th_hotel_prozente where hotel_id = ? and prozente_id = ?")))
            {
                $stmt->execute(array($this->id_hotel, $id));
                if (($row = $stmt->fetch()))
                {
                    $result = array('prozent_id'=>$row['prozente_id'], 'prozent_name' => $row['prozent_name']);
                }
                
                $stmt->closeCursor();
            }
        }
        
        if (isset($result))
        {
            return $result;
        }
        
        return false;
    }

    public function GetAktionen()
    {
        if ($this->validated)
        {
            if ($stmt = $this->pdo->prepare("SELECT aktion_id,aktion_name,selected from th_hotel_rabatt_aktion where hotel_id = ?"))
            {
                $stmt->execute(array($this->id_hotel));
                $result = array();
                while($row = $stmt->fetch())
                {
                    $result[] = array(
                        'aktion_id' => $row['aktion_id'],
                        'aktion_name' => $row['aktion_name'],
                        'aktion_selected' => $row['selected']
                        );
                }
                $stmt->closeCursor();
                return $result;
            }
        }

        return false;
    }
    
    public  function GetAktionById($id)
    {
        $id = (int)$id;
        if ($this->validated)
        {
            if ($stmt = $this->pdo->prepare("SELECT aktion_id,aktion_name,selected from th_hotel_rabatt_aktion where hotel_id = ? and aktion_id = ?"))
            {
                $stmt->execute(array($this->id_hotel, $id));
                if(($row = $stmt->fetch()))
                {
                    $result = array(
                        'aktion_id' => $row['aktion_id'],
                        'aktion_name' => $row['aktion_name'],
                        'aktion_selected' => $row['selected']
                        );
                }
                $stmt->closeCursor();
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
    $hotel_id = $_SESSION['user'];
    $user = UserFactory::Instance();
    $user->LoginById($hotel_id);
}

