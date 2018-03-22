<?php
class HomeController extends app\core\Controller {
    
	public function __construct()
	{
		$perms = [
			'index' => ['public' => true, 'connect' => true],
			'login' => ['public' => true, 'connect' => false],
			'logConnect' => ['public' => true, 'connect' => false],
			'logout' => ['public' => false, 'connect' => true],
			'register' => ['public' => true, 'connect' => false]
		];
		$this->setPermissions($perms);
	}

    public function index() {
        $this->generateView();
    }

    public function login() {
        if (isset($_POST['loginID']) && isset($_POST['loginPassword'])) {
            if (true) { //TODO: Gestion de l'identifiant.
                try { //TODO: Changer l'initialisation par un appel DAO.
                    $member = new Member();
                    $member->setId(0001);
                    $member->setLogin($this->request->getParameter('loginID'));
                    $member->setMail("Trump@windaube.usa");
                    $member->setPassword($this->request->getParameter('loginPassword'));

                    $_SESSION['user'] = serialize($member);
                    header('Location: index.php?controller=user&action=index');
                }
                catch (Exception $exception) {
                    echo 'Parameter Problem';
                }
            }
            else {
                $this->generateView();
            }
        }
        else {
            $this->generateView();
        }
    }


    public function logConnect()
    {
        try
        {
            $login = $this->request->getParameter('loginID');
            $pwd = $this->request->getParameter('loginPassword');
            $dao = new MemberDAO();
            //TODO : ajouter user in db pour check
            $userId = UserService::checkCredential($dao, $login, $pwd);
            if(true)
            {
                UserService::setCurrentUser($userId);
                $this->generateView();
            }
            else
            {
                echo 'Mauvaise combinaison login/password' . PHP_EOL;
                header('Location: index.php?controller=home&action=login');
            }
        }
        catch (Exception $e)
        {
            echo 'error';
            $e->getMessage();
        }
    }


    public function register()
    {
        $this->generateView();
    }

    public function check()
    {
        $p = new Security();                /* objet pour verifier si le compte existe via le mail introduit  */
        $data = $p->m->read() ($_POST['mail']);
        if(!($data)) {
            $p->m->addMember($_POST['mail'], $_POST['login'], $_POST['password']);  /*un objet dao qui vient du constructeur securite */
            $this->generateView();
        }else echo 'compte avec le mail  !!!!' .$_POST['mail']. ' !!!!! est existant Veuillez définir un autre email svp';

    }

    public function initializeModel()
    {
        // TODO: Implement initialize() method.
    }

    public function logout() {
        if(UserService::isConnected()) {
			UserService::disconnect();
            //session_destroy();
        }
        header('Location: index.php/controller=home');
    }
}