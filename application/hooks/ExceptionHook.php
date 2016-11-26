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

        $msg  ='<p style="font-size:22px;margin:0;padding:0;position:relative;color: red;">出现严重异常了，赶紧来修复吧 ^-^...　◑︿◐ ╮(︶︿︶)╭ </p>';
        $msg .= '<p style="background-color: lightslategrey;font-size: 20px;font-style: normal;">Exception of type <strong>' . get_class($exception) . '</strong><br/> occurred with Message: <em style="color:red;">' . $exception->getMessage() . '</em><br/> <strong>in File</strong> ' . $exception->getFile() . '<br/> <strong>at Line</strong> ' . $exception->getLine();

        $msg .= "<br/> Backtrace :";
        $msg .= $exception->getTraceAsString().'</p>';

        $filename = 'sys_error_warning'.date('Y-m-d ').'.log';

        $pathName =APPPATH.'logs'.DIRECTORY_SEPARATOR.$filename;

        $isSendMail =$this->emailConfig['is_send_mail'];
        if($isSendMail){
            $this->sendMail($this->emailConfig,$msg,$pathName);
        }

    }
    /**
     * 发邮件功能
     * @param $msg
     * @param $pathName
     */
    public  function sendMail($emailConfig,$msg,$pathName){

        try {

            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            //'UTF-8';    //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->CharSet    = $emailConfig['charset'];
            $mail->SMTPAuth   = $emailConfig['auth'];  //开启认证
            $mail->Port       = $emailConfig['port'];
            $mail->Host       = $emailConfig['host'];
            $mail->Username   = $emailConfig['username'];
            $mail->Password   = $emailConfig['password'];

            $mail->From       = $emailConfig['from'];
            $mail->FromName   = $emailConfig['fromname'];
            $to = $this->emailConfig['to'];
            $mail->AddAddress($to);// 多个人发 再复制一个方法出来

            $mail->Subject  = $emailConfig['subject'];
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
