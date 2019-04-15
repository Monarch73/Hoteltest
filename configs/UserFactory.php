<?php

final class UserFactory
{

    /**
     *
     * @var PDO Database connection
     */
    private $pdo = null;
    
    /**
     *
     * @var boolean User logged in?
     */
    public $validated = false;
    
    /**
     *
     * @var string Hotels EMailaddress
     */
    public $email;
    
    /**
     *
     * @var string Hotels Name
     */
    public $name;
    
    /**
     *
     * @var string Hotels Id
     */
    public $id_hotel;
    
    /**
     *
     * @var string Hotel Owners Name
     */
    public $owner;
    
    /**
     * 
     * @var string Hotel detailseite
     */
    public $hotel_detail_link;

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
        if (($stmt = $this->pdo->prepare("SELECT h.hotel_id, h.hotel_email, h.hotel_name, h.hotel_owner, h.hotel_detail_link FROM th_hotels h inner join th_hotel_passwords p on (p.hotel_id = h.hotel_id)  WHERE hotel_active=1 and h.hotel_email=:email and p.password=unhex(md5(:password))")))
        {
            $stmt->execute(array(':email'=>$username,':password'=>$password));
            if (($row = $stmt->fetch()))
            {
                $this->validated=true;
                $this->email = $row['hotel_email']; // $hotel_email;
                $this->id_hotel = $row['hotel_id']; //$hotel_id;
                $this->name = $row['hotel_name']; //$hotel_name;
                $this->owner = $row['hotel_owner']; // $hotel_owner
                $this->hotel_detail_link = $row['hotel_detail_link']; // hotel_detail_link
            }
        }
    }

    public function FindEmail($email)
    {
        if (($stmt = $this->pdo->prepare("SELECT h.hotel_id, h.hotel_name FROM th_hotels h WHERE h.hotel_email=? and hotel_active=1")))
        {
            $stmt->execute(array($email));
            if (($row = $stmt->fetch()))
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
        if (($stmt = $this->pdo->prepare("SELECT h.hotel_id, h.hotel_email, h.hotel_name, h.hotel_owner, h.hotel_detail_link FROM th_hotels h WHERE hotel_active=1 and h.hotel_id = ?")))
        {
            $stmt->execute(array($id));
            if (($row = $stmt->fetch()))
            {
                $this->validated=true;
                $this->email = $row['hotel_email'];
                $this->id_hotel = $row['hotel_id'];
                $this->name = $row['hotel_name'];
                $this->owner = $row['hotel_owner'];
                $this->owner = $row['hotel_detail_link'];
            }
            
            $stmt->closeCursor();
        }
    }

    public function SetPasswordLink()
    {
        if ($this->validated)
        {
            $code = $this->getToken(32);
            if (($stmt = $this->pdo->prepare("update th_hotel_passwords set chpwd_code = ?, chpwd_code_expires = unix_timestamp()+30*60 where hotel_id = ?")))
            {
                $stmt->execute(array($code, $this->id_hotel));
                $result = $code;
                $stmt->closeCursor();
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
        if (($stmt = $this->pdo->prepare("select hotel_id from th_hotel_passwords where unix_timestamp() < chpwd_code_expires and  chpwd_code = ? and hotel_id = ?")))
        {
            $stmt->execute(array( $token, $hotel_id ));
            if (($row = $stmt->fetch()))
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
        if (($stmt = $this->pdo->prepare("update th_hotel_passwords set chpwd_code = '', chpwd_code_expires=0, password=unhex(md5(?)) where hotel_id = ?")))
        {
            $stmt->execute(array($password, $hotel_id));
            $stmt->closeCursor();
        }
    }

    public function GetProzente()
    {
        if ($this->validated)
        {
            if (($stmt = $this->pdo->prepare("SELECT prozente_id,prozent_name,selected from th_hotel_prozente where hotel_id = ?")))
            {
                $stmt->execute(array($this->id_hotel));
                $result = array();
                while(($row = $stmt->fetch()))
                {
                    $result[] = array('prozent_id'=>$row['prozente_id'], 'prozent_name' => $row['prozent_name'], 'selected' => $row['selected']);
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

    /**
     * 
     * @return boolean true if worked, false if it didn't
     */
    public function InitProzente()
    {
        if (!$this->validated)
            return false;
        
        if (($stmt = $this->pdo->prepare("SELECT prozente_id,prozent_name from th_hotel_prozente where hotel_id = ?")))
        {
            $stmt->execute(array($this->id_hotel));
            if ($stmt->rowCount()< 1)
            {
                $stmt = $this->pdo->prepare("insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (?, '0%',0,0),(?, '5%',5,0),(?, '10%',10,0),(?, '15%',15,0),(?, '20%',20,0),(?, '25%',25,0),(?, '50%',50,0);");
                $stmt->execute(array($this->id_hotel,$this->id_hotel,$this->id_hotel,$this->id_hotel,$this->id_hotel,$this->id_hotel,$this->id_hotel));
                
            }
        }
    }

    
    /**
     * 
     * @param array $entity
     * @return boolean true on success, false when fauled
     */
    public function SetProzentByEntity($entity)
    {
        if (!$this->validated)
            return false;
        
        if (($stmt = $this->pdo->prepare("update th_hotel_prozente set selected = 0 where hotel_id = ?")))
        {
            $stmt->execute(array($this->id_hotel));
        }
        
        if (($stmt = $this->pdo->prepare("update th_hotel_prozente set selected = 1 where hotel_id = ? and prozente_id = ?")))
        {
            $stmt->execute(array($this->id_hotel, $entity['prozente_id']));
        }
        
        
        return true;
    }

    
    
    public function GetAktionen()
    {
        if ($this->validated)
        {
            if (($stmt = $this->pdo->prepare("SELECT aktion_id,aktion_name,selected from th_hotel_rabatt_aktion where hotel_id = ?")))
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
    
    public function GetAktionById($id)
    {
        $id = (int)$id;
        if (!$this->validated)
            return false;
        
        if (($stmt = $this->pdo->prepare("SELECT aktion_id,aktion_name,selected from th_hotel_rabatt_aktion where hotel_id = ? and aktion_id = ?")))
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


        return false;
    }
    
    /**
     * 
     * @param array $entity
     */
    public function SetAktionByEntity($entity)
    {
        if (!$this->validated)
            return false;
        
        if (($stmt = $this->pdo->prepare("update th_hotel_rabatt_aktion set selected = 0 where hotel_id = ?")))
        {
            $stmt->execute(array($this->id_hotel));
        }

        if (($stmt = $this->pdo->prepare("update th_hotel_rabatt_aktion set selected = 1 where hotel_id = ? and aktion_id = ?")))
        {
            $stmt->execute(array($this->id_hotel, $entity['aktion_id']));
        }
        
        return true;
    }
    
    /**
     * 
     * @return boolean true if success
     */
    public function InitAktionen()
    {
        if (!$this->validated)
            return false;

        if (($stmt = $this->pdo->prepare("SELECT aktion_id,aktion_name,selected from th_hotel_rabatt_aktion where hotel_id = ?")))
        {
            $stmt->execute(array($this->id_hotel));
            if ($stmt->rowCount()< 1)
            {
                $stmt = $this->pdo->prepare("insert into th_hotel_rabatt_aktion (hotel_id, aktion_name, selected) values (?, 'Auf die erste Übernachtung',0),(?, 'Auf alle Übernachtungen',0),(?, 'Auf alle Speisen',0),(?, 'Auf alle Getränke',0),(?, 'Auf die gesamte Rechnung',0);");
                $stmt->execute(array($this->id_hotel,$this->id_hotel,$this->id_hotel,$this->id_hotel,$this->id_hotel));
            }
        }
    }
    
    public function GetHotelData($id)
    {
        if (($stmt = $this->pdo->prepare("select * from th_hotels t inner join th_hotel_prozente p on (p.hotel_id = t.hotel_id and p.selected=1) inner join th_hotel_rabatt_aktion a on (a.hotel_id = p.hotel_id and a.selected=1) where t.hotel_id=?;")))
        {
            $stmt->execute(array($id));
            if(($row = $stmt->fetch()))
            {
                return $row;
            }
        }
        
        return false;
    }

    public function LoadSession()
    {
        if (!$this->validated)
            return false;

        
        $data = $this->GetHotelData($this->id_hotel);
        if ($data === false)
            return false;
        
        if (!isset($_SESSION['hotelpage'][1]))
        {
            //array( 'von' => $heuteMorgen, 'bis' => $heuteMorgen, 'prozente_id' => -1 );
            $_SESSION['hotelpage'][1]['von'] = $data['von'];
            $_SESSION['hotelpage'][1]['bis'] = $data['bis'];
            $_SESSION['hotelpage'][1]['prozente_id'] = $data['prozente_id'];
        }
        
        if (!isset($_SESSION['hotelpage'][2]))
        {
            //array('aktion' => -1)
            $_SESSION['hotelpage'][2]['aktion'] = $data['aktion_id'];
        }
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
}

if (isset($_SESSION['user']))
{
    $hotel_id = $_SESSION['user'];
    $user = UserFactory::Instance();
    $user->LoginById($hotel_id);
}

