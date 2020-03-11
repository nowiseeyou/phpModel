<?php

/**
 * Class Scheduler
 */
class Scheduler
{
    /**
     * @var SplQueue
     */
    protected $taskQueue;
    /**
     * @var int
     */
    protected $tid = 0;

    /**
     * Scheduler constructor.
     */
    public function __construct()
    {
        /**
         * 原理就是 维护了一个队列
         * 从编程的角度来看 ，协程的思想本质上就是控制流的主动让出（yield） 和 恢复（resume）
         */
        $this->taskQueue = new SplQueue();
    }

    /**
     * 增加一个任务
     * @param Generator $task
     * @return int
     */
    public function addTask(Generator $task){
        $tid = $this->tid;
        $task = new Task($tid,$task);
        $this->taskQueue->enqueue($task);
        $this->tid++;
        return $tid;
    }

    /**
     * 把任务加入队列
     *
     * @param Task $task
     */
    public function schedule(Task $task){
        $this->taskQueue->enqueue($task);
    }

    /**
     * 运行调度器
     */
    public function run(){
        while (! $this->taskQueue->isEmpty()) {
            // 任务出队
            $task = $this->taskQueue->dequeue();
            $res = $task->run(); // 运行任务直到 yield

            if (!$task->isFinished()){
                $this->schedule($task); // 任务如果还没完全执行完毕，入队等待下次执行
            }
        }
    }
}