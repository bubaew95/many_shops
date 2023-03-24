<?php

namespace App\Controller;

use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    public function __construct(
        private readonly PaginatorInterface $paginator,
        private readonly string $template
    ) {}

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        return parent::render($this->template . "/{$view}", $parameters, $response);
    }

    /**
     * @param  Request       $request
     * @param  QueryBuilder  $queryBuilder
     *
     * @return PaginationInterface
     */
    protected function paginator(Request $request, QueryBuilder $queryBuilder): PaginationInterface
    {
        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->get('show') ?? 20
        );

        $pagination->setCustomParameters([
            'align'         => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size'          => 'small',  # small|large (for template: twitter_bootstrap_v4_pagination)
            'style'         => 'bottom',
            'span_class'    => 'whatevesr',
        ]);

        return $pagination;
    }
}