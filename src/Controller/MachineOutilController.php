<?php

namespace App\Controller;

use App\Entity\MachineOutil;
use App\Form\MachineOutilType;
use App\Utils\GetErrorsFromForm;
use App\Repository\MachineOutilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**     
* @Route("/api/machineOutil", name="machineOutil")
*/
class MachineOutilController extends AbstractController
{

     /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, GetErrorsFromForm $getErrorsFromForm)
    {
        $machineOutil = new MachineOutil();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent(), true);
        /** On verifie si la propriété est envoyée dans le json si oui on hydrate l'objet 
         * sinon on passe à la suite */
        $form = $this->createForm(MachineOutilType::class, $machineOutil);
        $form->submit($donnees);
       
        
        if ($form->isValid()) {
            $machineOutil->setCreatedAt(new \DateTime);
            $machineOutil->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($machineOutil);
            $em->flush();
            return new JsonResponse('ok', 201);
        } else {
            $errors = $getErrorsFromForm->getErrors($form);
            $data = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $errors,
            ];
            return new JsonResponse($data, 400);
        }       
    }

    /**
     * @Route("/{id}", name="read", requirements={"id": "\d+"},  methods={"GET"})
     */
    public function read(MachineOutilRepository $machineOutilRepository, $id, SerializerInterface $serializer, MachineOutil $machineOutil )
    {   
        
        if ($this->getUser()->getId() != $machineOutil->getUser()->getId()){

            return new Response('Accès refusé', 403);
        }

        $read = $machineOutilRepository->findBy(array('id' => $id));
        
        if (!empty($read)) {
            return new JsonResponse($serializer->normalize(
                $read,
                'json',
                ['groups' => ['machineOutil', 'user']]
                
            ));
        } else {
            return new Response("La MachineOutil n'est pas en base de données  ", 404);
        }
    }

    /**
     * @Route("/{id}", name="update", methods={"PATCH"}, requirements={"id": "\d+"})
     *
     */
    public function update(MachineOutil $machineOutil, Request $request, GetErrorsFromForm $getErrorsFromForm)
    {
        
        if ($this->getUser()->getId() != $machineOutil->getUser()->getId()){

            return new Response('Accès refusé', 403);
        }
        
        $donnees = json_decode($request->getContent(), true);
       
        $form = $this->createForm(MachineOutilType::class, $machineOutil);
        
        $form->submit($donnees, false);
        
        if ($form->isValid()) {
   
            $em = $this->getDoctrine()->getManager();
            $em->persist($machineOutil);
            $em->flush();
            return new JsonResponse('ok', 200);
        } else {
            $errors = $getErrorsFromForm->getErrors($form);
            $data = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $errors,
            ];
            return new JsonResponse($data, 400);
        }
        
       
    }


    /**
     * @Route("/{id}", name="delete", requirements={"id": "\d+"}, methods={"DELETE"})
     */
    public function delete(MachineOutil $machineOutil)
    {
        
        if ($this->getUser()->getId() != $machineOutil->getUser()->getId()){

            return new Response('Accès refusé', 403);
        }
        
        $em = $this->getDoctrine()->getManager();

        $em->remove($machineOutil);
        $em->flush();

        // On retourne la confirmation
        return new Response('supression ok', 200);
    }
}
