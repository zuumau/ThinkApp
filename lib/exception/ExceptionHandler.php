<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/4/28
 * Time: 11:28
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{

    private $code;
    private $msg;
    private $errorCode;
    // 需要返回客户端当前请求的 URL 路径

    // 在 config.php 文件中设置 异常处理handle类
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            // 如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }
        else {
            if (config('app_debug'))
            {
                // return default error page
                return parent::render($e);
            }
            else {
                $this->code = 500;
                $this->msg = '服务器内部错误的拉';
                $this->errorCode = 999;
                $this->recordErrorLog($e);            // 调用日志记录方法
            }
        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e) {   // 记录日志方法
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}