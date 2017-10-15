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
                    'message' => 'Användarnamn måste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 25,
                    'message' => 'Användarnamnet får vara maximalt 25 tecken långt.'
                ]
            ],
            'password' => [
                [
                    'rule' => 'required',
                    'message' => 'Lösenord måste anges.'
                ],
                [
                    'rule' => 'minlength',
                    'value' => 8,
                    'message' => 'Lösenordet måste vara minst 8 tecken långt.'
                ]
            ],
            'email' => [
                [
                    'rule' => 'required',
                    'message' => 'E-postadress måste anges.'
                ],
                [
                    'rule' => 'email',
                    'message' => 'E-postadressen är ogiltig.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 200,
                    'message' => 'E-postadressen får vara maximalt 200 tecken lång.'
                ]
            ],
            'website' => [
                [
                    'rule' => 'maxlength',
                    'value' => 500,
                    'message' => 'Webbadressen får vara maximalt 500 tecken lång.'
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
