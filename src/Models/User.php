<?php

namespace WGTOTW\Models;

/**
 * User model class.
 */
class User extends BaseModel
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $website;
    public $showEmail;
    public $isAdmin;
    
    
    public function __construct()
    {
        $this->setNullables(['website', 'isAdmin']);
        $this->setValidation([
            'username' => [
                [
                    'rule' => 'required',
                    'message' => 'Anv�ndarnamn m�ste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 25,
                    'message' => 'Anv�ndarnamnet f�r vara maximalt 25 tecken l�ngt.'
                ]
            ],
            'password' => [
                [
                    'rule' => 'required',
                    'message' => 'L�senord m�ste anges.'
                ],
                [
                    'rule' => 'minlength',
                    'value' => 8,
                    'message' => 'L�senordet m�ste vara minst 8 tecken l�ngt.'
                ]
            ],
            'email' => [
                [
                    'rule' => 'required',
                    'message' => 'E-postadress m�ste anges.'
                ],
                [
                    'rule' => 'email',
                    'message' => 'E-postadressen �r ogiltig.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 200,
                    'message' => 'E-postadressen f�r vara maximalt 200 tecken l�ng.'
                ]
            ],
            'website' => [
                [
                    'rule' => 'maxlength',
                    'value' => 500,
                    'message' => 'Webbadressen f�r vara maximalt 500 tecken l�ng.'
                ]
            ]
        ]);
    }
    
    
    /**
     * Get Gravatar for user.
     *
     * @param int       $size       Gravatar size.
     * @param string    $default    Default image type.
     *
     * @return string               URL to gravatar image.
     */
    public function getGravatar($size = 50, $default = 'retro')
    {
        return 'https://www.gravatar.com/avatar/' . md5(mb_strtolower(trim($this->email))) . "?s=$size&amp;d=$default";
    }
    
    
    /**
     * Hash the password (call this before saving to database).
     */
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
    
    
    /**
     * Verify hashed password.
     *
     * @param string $password  Password to verify against stored hash.
     *
     * @return bool             True if password matches, false otherwise.
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
}
