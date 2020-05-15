<?php

namespace Dex\Microblog\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $db = $this->getDI()->get('db');

        $sql = "";

        $result = $db->fetchOne($sql, \Phalcon\Db\Enum::FETCH_ASSOC);

        echo var_dump($result);
    }

    public function fourOhFourAction()
    {
        $this->view->title = 'Whoops!';
        return $this->view->pick('fourohfour');
    }
}
