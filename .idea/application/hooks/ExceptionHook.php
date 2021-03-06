<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/26
 * Time: 17:27
 */
class ExceptionHook{

    public $emailConfig  ;

    public function SetExceptionHandler(){

        set_exception_handler(array($this, 'HandleExceptions'));
    }

    /**
     * 加载配置文件
     * @param $filename
     * @param string $directory
     */
    public static function loadConfig($filename ,$directory='config'){

        $config = array();
        $path = str_replace('\\', '/', APPPATH);
        $file = $path.$directory.'/'.$filename.'.php';

        if (file_exists($file)){
            include_once($file);
            return $config;
        }

        return $config;
    }

    public function HandleExceptions($exception){
        $this->loader= & load_class('Loader', 'core');
        $this->loader->library('plugin/phpmailer/PHPMailer');
        $this->emailConfig = static::loadConfig('email');

        $msg = 'Exception of type \'' . get_class($exception) . '\' occurred with Message: ' . $exception->getMessage() . ' in File ' . $exception->getFile() . ' at Line ' . $exception->getLine();

        $msg .= "\r\n Backtrace \r\n";
        $msg .= $exception->getTraceAsString();

        $filename = 'sys_error_warning'.date('Y-m-d ').'.log';
        $pathName =APPPATH.'logs'.DIRECTORY_SEPARATOR.$filename;

        $isSendMail =$this->emailConfig['is_send_mail'];
        if($isSendMail){
            $this->sendMail($msg,$pathName);
        }

    }
    /**
     * 发邮件功能
     * @param $msg
     * @param $pathName
     */
    public  function sendMail($msg,$pathName){

        try {

            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            //'UTF-8';    //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->CharSet    = $this->emailConfig['charset'];
            $mail->SMTPAuth   = $this->emailConfig['auth'];  //开启认证
            $mail->Port       = $this->emailConfig['port'];
            $mail->Host       = $this->emailConfig['host'];
            $mail->Username   = $this->emailConfig['username'];
            $mail->Password   = $this->emailConfig['password'];

            $mail->From       = $this->emailConfig['from'];
            $mail->FromName   = $this->emailConfig['fromname'];
            $to = $this->emailConfig['to'];
            $mail->AddAddress($to);// 多个人发 再复制一个方法出来

            $mail->Subject  = '参团游错误警告';
            $mail->Body = $msg;

            //当邮件不支持html时备用显示，可以省略
            //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
            //$mail->WordWrap   = 80; // 设置每行字符串的长度
            //$mail->AddAttachment("f:/test.png");  $this->emailConfig['attachment'];//可以添加附件
            $mail->IsHTML(true);
            $flag = $mail->Send();

            if(!$flag){

                $errorMessage = $mail->ErrorInfo;
                $message = date('Y-m-d H:i:s').':'.$errorMessage;
                file_put_contents($pathName,$message,FILE_APPEND | LOCK_EX);

            }

        } catch (phpmailerException $e) {

            $errorMessage = $e->errorMessage();
            $message = date('Y-m').$errorMessage;

            file_put_contents($pathName,$message,FILE_APPEND | LOCK_EX);

        }
    }

}
