<?php

namespace App\Controller;

use App\DataTables\OrganismoTableType;
use App\Entity\Organismo;
use App\Form\OrganismoType;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/organismo")
 */
class OrganismoController extends AbstractController
{
    /**
     * Variable auxiliar para crear datatables
     *
     * @var [DataTableFactory]
     */
    protected $datatableFactory;

    public function __construct(DataTableFactory $dataTableFactory)
    {
        $this->datatableFactory = $dataTableFactory;
    }

    /**
     * Route encargado de armar grilla de organismos
     * @Route("/", name="organismo_index")
     */
    public function index(Request $request): Response
    {
        $table = $this->datatableFactory->createFromType(OrganismoTableType::class, array())->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('organismo/index.html.twig', ['datatable' => $table]);
    }

    /**
     * @Route("/new", name="organismo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $organismo = new Organismo();
        $form = $this->createForm(OrganismoType::class, $organismo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organismo);
            $entityManager->flush();

            return $this->redirectToRoute('organismo_index');
        }

        return $this->render('organismo/new.html.twig', [
            'organismo' => $organismo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organismo_show", methods={"GET"})
     */
    public function show(Organismo $organismo): Response
    {
        return $this->render('organismo/show.html.twig', [
            'organismo' => $organismo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="organismo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Organismo $organismo): Response
    {
        $form = $this->createForm(OrganismoType::class, $organismo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('organismo_index');
        }

        return $this->render('organismo/edit.html.twig', [
            'organismo' => $organismo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organismo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Organismo $organismo): Response
    {
        if ($this->isCsrfTokenValid('delete' . $organismo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($organismo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('organismo_index');
    }
}
