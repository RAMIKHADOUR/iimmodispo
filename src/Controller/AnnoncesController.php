<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Controller\AnnoncesController;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;


class AnnoncesController extends AbstractController
{

    /**
     * This function display all Annonces
     *
     * @param AnnoncesRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/annonces', name: 'app_annonces', methods:['GET'])]
    public function index(AnnoncesRepository $repository,
    PaginatorInterface $paginator,
    Request $request): Response
    {
        $annonces= $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),10
        );

        return $this->render('pages/annonces/index.html.twig', [
           'annonces'=>$annonces
        ]);
    }


    /**
     * Creation une annonce
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
#[Route('/annonces/new',name:'annonces_new', methods:['GET'])]
    public function new(Request $request ,
    EntityManagerInterface $manager): Response
    {
        $annonces = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonces);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $annonces = $form ->getData();
            $manager->persist($annonces);
            $manager->flush();

            $this->addFlash('success', 'Successfully submitted');
            return $this -> redirectToRoute ('app_annonces');
            
}

    return $this->render('pages/annonces/new.html.twig',[
        'form'=>$form->createView()
    ]);
}


#[Route('/annonces/edition/{id}',name:'annonces_edit',methods :['GET','POST'])]
public function edit(AnnoncesRepository $repository ,
int $id,Request $request,
EntityManagerInterface $manager ):Response
{
   $annonces = $repository->findOneBy(['id'=>$id]);
    $form = $this->createForm(AnnoncesType::class, $annonces);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $annonces = $form ->getData();
        $manager->persist($annonces);
        $manager->flush();
        $this->addFlash('success', 'Successfully Modified');
        return $this -> redirectToRoute ('app_annonces');
    }
    return $this->render('pages/annonces/edit.html.twig',[
        'form'=>$form->createView()
]);
}

#[Route('/annonces/suppression/{id}',name:'annonces_delete',methods :['GET'])]
public function delete(EntityManagerInterface $manager ,
Annonces $annonces):Response
{
    $manager ->remove($annonces);
    $manager->flush();
    $this->addFlash('success', 'Successfully deleted');
    return $this -> redirectToRoute ('app_annonces');

}
}