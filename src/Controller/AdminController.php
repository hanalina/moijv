<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
    
    /**
     * @Route("/admin/user/add", name="add_user")
     * @Route("/admin/user/edit/{id}", name="edit_user")
     */
    public function editUser(Request $request, ObjectManager $manager, User $user = null)
    {
        if($user === null){
            $user = new User();
        }
        $formUser = $this->createForm(UserType::class, $user)
                ->add('Envoyer', SubmitType::class);
        
        
        $formUser->handleRequest($request); // declenche la gestion du formulaire
        
        if ($formUser->isSubmitted() && $formUser->isValid()){
            //enregistrement de notre utilisateur
            $user->setRegistrationDate(new \DateTime('now'));
            $user->setRoles('ROLE_USER');
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_dashboard');
        }
        
        return $this->render('admin/edit_user.html.twig',[
            'form' => $formUser ->createView()
        ]);
    }
}
