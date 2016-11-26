<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/12
 * Time: 13:09
 */

class Mail  {


    /**
     * 发邮件功能
     * @param $msg
     * @param $pathName
     * @param array $emailConfig
     */
    public  function sendEmail(PHPMailer $mail,$emailConfig=array(),$msg='',$pathName=''){

        try {

            //$mail = new PHPMailer(true);
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
            $to = $emailConfig['to'];
            $mail->AddAddress($to);// 多个人发 再复制一个方法出来

            $mail->Subject  = $emailConfig['subject'];
            $mail->Body = $msg;

            //当邮件不支持html时备用显示，可以省略
            //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
            //$mail->WordWrap   = 80; // 设置每行字符串的长度
            //$mail->AddAttachment("f:/test.png");  $this->emailConfig['attachment'];//可以添加附件
            $mail->IsHTML(true);
            $flag = $mail->Send();

            if(empty($pathName)){

                $filename = 'business_error_warning'.date('Y-m-d ').'.log';
                $pathName = APPPATH.'logs'.DIRECTORY_SEPARATOR.$filename;

            }
            if(!$flag){

                $errorMessage = $mail->ErrorInfo;
                $message = date('Y-m-d H:i:s').':'.$errorMessage;
                file_put_contents($pathName,$message,FILE_APPEND | LOCK_EX);

            }

            if(!$flag){

                $errorMessage = $mail->ErrorInfo;
                $message = date('Y-m-d H:i:s').':'.$errorMessage;
                file_put_contents($pathName,$message,FILE_APPEND | LOCK_EX);

            }
        } catch (phpmailerException $e) {

            $errorMessage = $e->errorMessage();
            $message = date('Y-m-d H:i:s').$errorMessage;

            file_put_contents($pathName,$message,FILE_APPEND | LOCK_EX);

        }
    }
}