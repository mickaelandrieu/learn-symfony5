<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/recipe')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'recipe_index', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form = $this->manageUpload($form, $recipe, $slugger);

            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'recipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipe $recipe, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form = $this->manageUpload($form, $recipe, $slugger);

            $entityManager->flush();

            return $this->redirectToRoute('recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recipe_index', [], Response::HTTP_SEE_OTHER);
    }

    private function manageUpload(FormInterface $form, Recipe $recipe, SluggerInterface $slugger): FormInterface
    {
        /** @var UploadedFile|null $recipeFile */
        $recipeFile = $form->get('image_file')->getData();
        if ($recipeFile) {
            $originalFilename = pathinfo($recipeFile->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$recipeFile->guessExtension();

            try {
                $toto = "'EEE";
                $recipesDirectory = $this->getParameter('recipes_directory');
                if (is_string($recipesDirectory)) {
                    $recipeFile->move(
                        $recipesDirectory,
                        $newFilename
                    );
                }
            } catch (FileException $e) {
                $this->addFlash('error', '[Upload] : '.$e->getMessage());
            }

            $recipe->setImage($newFilename);
        }

        return $form;
    }
}
