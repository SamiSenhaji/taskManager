<?php

namespace app\models\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_member")
 **/
class Member extends Entity
{
    /** @ORM\Column(type="string", unique=true, nullable=false) * */
    private $login;
    /** @ORM\Column(type="string") * */
    private $password;
    /** @ORM\Column(type="string") * */
    private $mail;
    /** @ORM\Column(type="integer") * */
    private $team;

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }
	
	public function setTeam($new_team)
    {
        $this->team = $new_team;
    }

    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team): void
    {
        $this->team = $team;
    }

}