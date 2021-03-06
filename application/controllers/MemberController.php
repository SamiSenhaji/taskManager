<?php
namespace app\controllers;
use app\core\DependencyInjectionContainer;
use app\models\Entity\Member;

class MemberController extends \app\core\Controller
{
    private $member;

    public function initializeModel()
    {
        if ($this->request->existParameter('login')){
            $this->member->setLogin($this->request->getParameter('login'));
        }
        if ($this->request->existParameter('password')){
            $this->member->setPassword($this->request->getParameter('password'));
        }
        if ($this->request->existParameter('mail')){
            $this->member->setMail($this->request->getParameter('mail'));
        }
		if($this->request->existParameter('team')) {
			$this->member->setTeam(intval($this->request->getParameter('team')));
		}
    }

    public function __construct(DependencyInjectionContainer $dic)
    {
        parent::__construct($dic);

        $perms = [
            'index' => ['public' => true, 'connect' => true],
            'initializeModel' => ['public' => true, 'connect' => true],
            'save' => ['public' => true, 'connect' => true],
            'update' => ['public' => true, 'connect' => true],
            'read' => ['public' => true, 'connect' => true],
            'delete' => ['public' => true, 'connect' => true],
            'profil' => ['public' => true, 'connect' => true],
            'edit' => ['public' => true, 'connect' => true]
        ];
        $this->setPermissions($perms);
        $this->member = new member();
    }

    public function index()
    {
        $members = $this->entityManager->getRepository(get_class($this->member))->findAll();

        $this->generateView('index.twig', ['members' => $members]);
    }

    public function getMemberData($memberId)
    {
        $this->member = $this->entityManager->getRepository(get_class($this->member))->find($memberId);
        $memberData = $this->member->toArray();
        return ['member' => $memberData];
    }

    public function read()
    {
        $memberId = $this->request->getParameter('id');
        /*$member = $this->getMemberData($memberId);
        $this->generateView($member);*/

        $member = $this->entityManager->getRepository(get_class($this->model))->find($memberId);
        $this->generateView('read.twig', ['member' => $member,]);
    }

    /**
     * @throws \EXception
     */
    public function profil()
    {
        $memberId = $this->request->getParameter('id');
        $member = $this->entityManager->getRepository(get_class($this->member))->find($memberId);

        $this->generateView(
            'profil.twig',
            [
                'member' => $member,
            ]
        );
    }

    public function edit()
    {
        $memberId = $this->request->getParameter('id');
        $member = $this->getMemberData($memberId);
        $this->generateView($member);
    }


    public function update()
    {
        $memberId = $this->request->getParameter('id');
        $this->member = $this->entityManager->getRepository(get_class($this->member))->find($memberId);
        //$this->member = $this->initializeModel();
        $this->entityManager->flush();
        $this->generateView();
    }

    public function save()
    {
        $this->initializeModel();
        $this->entityManager->persist($this->member);
        $this->entityManager->flush();
        $this->generateView('save.twig');
    }

    public function delete()
    {
        $memberId = $this->request->getParameter('id');
        $this->member = $this->entityManager->getRepository(get_class($this->member))->find($memberId);
        $this->entityManager->remove($this->member);
        $this->entityManager->flush();
        $this->generateView();
    }
}