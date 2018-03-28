<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(UserRepository $userRepo)
    {
        // $userRepo est passé automatiquement en parametre par Symfony :
        // -> injection de dépendance. On n'a donc pas à instancier nous même
        // $userRepo effectuera ici un SELECT * FROM user ...
        $userList = $userRepo ->findAll();
        
        // $userList = $userRepo -> findBy (['RegisterDate' => new Datetime('now')], 'registerDate DESC', 10)
        
        return $this->render("admin/dashboard.html.twig", [
            'users' => $userList
        ]);
    }
    /**
     * @Route("/admin/user/delete/{id}", name="delete_user")
     */
    public function deleteUser(User $user, ObjectManager $manager)
    {
        $manager->remove ($user);
        $manager->flush();
        return $this->redirectToRoute('admin_dashboard');
    }
}
