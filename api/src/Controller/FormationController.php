<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[Route('/formations')]
class FormationController extends AbstractController
{
    public function __construct(
        private FormationRepository $repository,
        private SerializerInterface $serializer
    ) {}

    #[Route('', name: 'formations_list', methods: ['GET'])]
    #[OA\Get(
        path: '/formations',
        summary: 'List formations with pagination and filters',
        tags: ['Formations'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                description: 'Page number',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1)
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                description: 'Items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 10)
            ),
            new OA\Parameter(
                name: 'q',
                in: 'query',
                description: 'Search query (titre, organisme, ville)',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'departement',
                in: 'query',
                description: 'Filter by department code',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'modalite',
                in: 'query',
                description: 'Filter by modalite',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['presentiel', 'distanciel', 'hybride'])
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of formations',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'items',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Formation')
                        ),
                        new OA\Property(property: 'total', type: 'integer'),
                        new OA\Property(property: 'page', type: 'integer'),
                        new OA\Property(property: 'limit', type: 'integer'),
                        new OA\Property(property: 'pages', type: 'integer')
                    ]
                )
            )
        ]
    )]
    public function list(Request $request): JsonResponse
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = min(100, max(1, $request->query->getInt('limit', 10)));
        $search = $request->query->get('q');
        $departement = $request->query->get('departement');
        $modalite = $request->query->get('modalite');

        $result = $this->repository->findPaginated(
            $page,
            $limit,
            $search,
            $departement,
            $modalite
        );

        $json = $this->serializer->serialize($result, 'json', [
            'groups' => ['formation:read']
        ]);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'formation_show', methods: ['GET'])]
    #[OA\Get(
        path: '/formations/{id}',
        summary: 'Get formation details',
        tags: ['Formations'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Formation UUID',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Formation details',
                content: new OA\JsonContent(ref: '#/components/schemas/Formation')
            ),
            new OA\Response(
                response: 404,
                description: 'Formation not found'
            )
        ]
    )]
    public function show(Formation $formation): JsonResponse
    {
        $json = $this->serializer->serialize($formation, 'json', [
            'groups' => ['formation:read']
        ]);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}