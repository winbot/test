<?php

namespace First\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FirstPageBundle:Default:index.html.twig');
    }
}
