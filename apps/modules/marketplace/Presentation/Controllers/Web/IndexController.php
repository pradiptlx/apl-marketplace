<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function fourOhFourAction()
    {
        return $this->view->pick('fourohfour');
    }

}
