<?php

class IndexController extends Phalcon\Mvc\Controller {

	public function indexAction() {
        $sentences = array_reverse(Sentences::find(
            array(
                array(),
                "sort"  => array("_t" => -1),
                'limit' => 5,
            )
        ));
        $this->view->setVar('sentences', $sentences);
	}

    public function submitAction() {
        $now = $_SERVER['REQUEST_TIME'];
        $sentence = new Sentences();
        if (!isset($_REQUEST['text'])){
            die("text is empty");
        }
        $sentence->text = $_REQUEST['text'];
        $sentence->_t   = $now;
        if ($sentence->save() == false) {
            echo "Umh, We can't store sentence right now: \n";
            foreach ($sentence->getMessages() as $message) {
                echo $message, "\n";
            }   
        } else {
            echo json_encode(array(
                'text'=>$_REQUEST['text'],
                '_t'  =>$now,
            ));
        }   
    }
}
