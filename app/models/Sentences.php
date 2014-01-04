<?php
/**
 * Sentences.php
 * 2014-01-04
 *
 * Developed by yewei <yewei@playcrab.com>
 * Copyright (c) 2014 Playcrab Corp.
 *
 * Desc:
 */

class Sentences extends Phalcon\Mvc\Collection {
    public function initialize() {
        $this->setConnectionService('mongo');
        $this->useImplicitObjectIds(false);// 不强制使用自动的mongoid
    }

    // 该返回值作为collection的名字，无则使用类名小写
    public function getSource() {
        return "sentence";
    }
}
