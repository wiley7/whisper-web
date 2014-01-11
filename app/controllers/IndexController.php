<?php

class IndexController extends Phalcon\Mvc\Controller {

	public function indexAction() {
        $sentences = array_reverse(Sentences::find(
            array(
                array(),
                "sort"  => array("_t" => -1),
                'limit' => 6,
            )
        ));
        $this->view->setVar('sentences', $sentences);
        $this->view->setVar('editable', false);
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
                'id'      => $sentence->_id,
            ));
        }   
    }

    public function listAction() {
        $sentences = array_reverse(Sentences::find(
            array(
                array(),
                "sort"  => array("_t" => -1),
            )
        ));
        $this->view->setVar('sentences', $sentences);
        $this->view->setVar('editable', true);
    }

    // 给赞，记录赞
    public function goodAction() {
    }

    // 给bad就直接删除
    public function delAction() {
        if(!isset($_REQUEST['sid'])){
            echo json_encode($_REQUEST);
            return;
        }
        $id = $_REQUEST['sid'];
        $ret = array();
        $sen= Sentences::findById(new MongoId($id));
        if ($sen->delete() == false){
            $ret['s'] = "error";
        }else{
            $ret['s'] = "ok";
        }
        echo json_encode($ret);
    }

    public function exportAction() {
        $start_t = strtotime(date("Ymd"));
        $end_t = $start_t + 86400;
        $sentences = array_reverse(Sentences::find(
            array(
                array(
                    "_t"=>array(
                        '$gt'=>$start_t,
                        '$lt'=>$end_t,
                    ),
                ),
                'sort'=>array('_t'=>-1),
            )
        ));
        $this->view->setVar('sentences', $sentences);
    }
}
