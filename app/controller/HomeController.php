<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController{

	public function mount($controller) {

    	$controller->get('/', array($this, 'index'))
    			   ->bind('home');

    }

    public function index(Request $request, Application $app) {

    	return $app['twig']->render('hello.twig');

    }

}