<?php

/**
 * Class Task
 */
class Task
{
    protected $taskId;
    protected $coroutine;
    protected $beforeFirstYield = true;
    protected $sendValue;

    /**
     * Task constructor.
     * @param $taskId
     * @param Generator $coroutine
     */
    public function __construct($taskId,Generator $coroutine)
    {
        $this->taskId = $taskId;
        $this->coroutine = $coroutine;
    }

    /**
     * 获取当前的 Task 的 ID
     *
     * @return mixed
     */
    public function getTaskId(){
        return $this->taskId;
    }

    /**
     * 判断 Task 执行完毕没有
     *
     * @return bool
     */
    public function isFinished() {
        return !$this->coroutine->valid();
    }

    /**
     * 设置下次要传给协程的值，比如 $id = (yield $xxx)，这个值就给了 $id 了
     *
     * @param $value
     */
    public function setSendValue($value){
        $this->sendValue = $value;
    }

    /**
     * 运行任务
     *
     * @return mixed
     */
    public function run(){
        if ( $this->beforeFirstYield) {
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        }
        else
        {
            //我们说过了 ， 用 send  去调用一个生成器
            $retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retval;
        }
    }

}