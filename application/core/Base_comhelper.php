<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/25
 * Time: 11:17
 */

class  Base_Comhelper  extends CI_Controller {


    public function sendMail($title='',$to='',$message =''){

        $this->load->library('plugin/phpmailer/PHPMailer');
        $this->load->library('Mail');
        $this->load->library('Curl');
        $this->load->config('email',true);
        $emailConfig =$this->config->config['email'];

        $this->mail->sendEmail($this->phpmailer,$emailConfig,$title,$to,$message);
    }

    public function sendSms(){


    }

    /**
     * 把文件异步写入log中
     */
    public function writeMailLog(){



    }



    /**
     * 加载单个文件
     * @param $class  【类名】
     * @param string $directory 【应用程序目录名】
     */
    public static function loadAppClass($class ,$directory='interface'){

        $path = str_replace('\\', '/', APPPATH);

        if (file_exists($path.$directory.'/'.$class.'.php')){

            if (class_exists($class, FALSE) === false) {
                require_once($path . $directory .'/'. $class . '.php');
            }
        }

    }

    /**
     * @param $total
     * @param int $perPage
     * @param string $action
     * @return mixed
     */
    public function page($total,$perPage=15,$action=''){

        $this->load->library('pagination');
        $pagination = load_class('pagination');
        $this->load->config('pagination',true); // 引进文件，同时想要修改样式，pagination.php 中的class="pagination"
        $config = $this->config->config['pagination'];

        $this->load->helper('url');

        $host = $_SERVER['HTTP_HOST'];
        $config['base_url'] = $host.'/'.$action;

        $config['total_rows'] = $total;  // 后端接口或是数据库的数据条数。
        $config['per_page']   = $perPage;    //每一页显示的数据条数
        $pagination->initialize($config);
        return $pagination->create_links();
    }
}