<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/6
 * Time: 15:51
 */

class Fields_validation {

     public $load ;
     public function __construct(){

         self::$instance =& $this;
         // Assign all the class objects that were instantiated by the
         // bootstrap file (CodeIgniter.php) to local class variables
         // so that CI can run as one big super object.
         foreach (is_loaded() as $var => $class)
         {
             $this->$var =& load_class($class);
         }

         $this->load =& load_class('Loader', 'core');
         $this->load->initialize();
     }

    //  校验数组
     public static $config = array(
         array(
             'field' => 'username',
             'label' => 'Username',
             'rules' => 'required'
         ),
         array(
             'field' => 'password',
             'label' => 'Password',
             'rules' => 'required',
             'errors' => array(
                 'required' => 'You must provide a %s.',
             ),
         ),
         array(
             'field' => 'passconf',
             'label' => 'Password Confirmation',
             'rules' => 'required'
         ),
         array(
             'field' => 'email',
             'label' => 'Email',
             'rules' => 'required'
         )
     );
}