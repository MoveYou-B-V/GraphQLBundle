<?php

namespace Overblog\GraphBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GraphController extends Controller
{
    public function endpointAction(Request $request)
    {
        $req = $this->get('overblog_graph.request_parser')->parse($request);
        $res = $this->get('overblog_graph.request_executor')->execute($req, []);

        return new JsonResponse($res->toArray(), 200);
    }
}
