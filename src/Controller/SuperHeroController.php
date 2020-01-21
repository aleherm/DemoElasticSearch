<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use App\Entity\SuperHero;
use App\SearchRepository\SuperHeroRepository;
use Symfony\Component\Routing\Annotation\Route;

class SuperHeroController extends AbstractController
{
    /**
     * @Route("/superhero", name="superhero")
     */
    public function index()
    {
        return $this->render('super_hero/index.html.twig', [
            'controller_name' => 'SuperHeroController',
        ]);
    }

    /**
     * @Route("/superhero/search", name="superhero_search")
     *
     * @param RepositoryManagerInterface $manager
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchSuperHero(RepositoryManagerInterface $manager, Request $request)
    {
        $query = $request->query->all();
        $search = isset($query['q']) && !empty($query['q']) ? $query['q'] : null;

        /** @var SuperHeroRepository $repository */
        $repository = $manager->getRepository(SuperHero::class);

        $superheroes = $repository->search($search);

        /** @var SuperHero $superhero */
        foreach ($superheroes as $superhero) {
            $data[] = [
                'name' => $superhero->getName(),
            ];
        }

        return new JsonResponse($data);
    }
}
