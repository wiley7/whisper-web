<?php

class IndexController extends Phalcon\Mvc\Controller {

	public function indexAction() {
        $sentences = array_reverse(Sentences::find(
            array(
                array(),
                "sort"  => array("_t" => -1),
                'limit' => 8,
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
        $text = $_REQUEST['text'];
        if ("sp " == substr($text, 0, 3)){
            $text    = substr($text, 3);
            $sentence->special = 1;
        }
        $sentence->_t   = $now;
        $sentence->text = $text;
        if ($sentence->save() == false) {
            echo "Umh, We can't store sentence right now: \n";
            foreach ($sentence->getMessages() as $message) {
                echo $message, "\n";
            }   
        } else {
            echo json_encode(array(
                'text'    => $text,
                '_t'      => $now,
                'special' => $sentence->special,
            ));
        }   
    }
}
