<?php

namespace fw\core;

class ReadingList
{
    public $stack = [];
    public $limit;

    public function __construct($limit){
        $this->limit = $limit;
        $this->stack = [];
    }

    public function setLimit($limit){
        $this->limit = $limit;
    }

    /** Pushes an item onto the top of the stack
     * @param $item
     * @return void
     */
    public function push($item){
        if(count($this->stack) < $this->limit){
            array_unshift($this->stack, $item);
        } else{
            throw new \RuntimeException('Stack is full!');
        }
    }

    /** Removes and returns the top item of the stack
     * @return mixed|null
     */
    public function pop(){
        if($this->isEmpty()){
            throw new \RuntimeException('Stack is empty!');
        } else{
            return array_shift($this->stack);
        }
    }

    /** Returns the top item without removing it
     * @return false|mixed
     */
    public function top(){
        return current($this->stack);
    }

    public function isEmpty(){
        return empty($this->stack);
    }

    public function getStack(){
        return $this->stack;
    }

}