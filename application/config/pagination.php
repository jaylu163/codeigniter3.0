<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/11/2
 * Time: 14:29
 */
$config['base_url'] ='http://dj.caissa.com.cn';

//box
$config['full_tag_open'] = '<div class="page_info">';
$config['full_tag_close'] = '</div>';
//上一页
$config['prev_link'] = '';
$config['prev_tag_open'] = '<span class="pre">';
$config['prev_tag_close'] = '</span>';
//当前页
$config['cur_tag_open'] = '<span class="current">';
$config['cur_tag_close'] = '</span>';
//每一页
$config['num_tag_open'] = '<span class="num">';
$config['num_tag_close'] = '</span>';
//下一页
$config['next_tag_open'] = '<span class="next">';
$config['next_tag_close'] = '</span>';
//最后一页
$config['last_link'] = false;
//第一页
$config['first_link'] = false;
//上一页
$config['next_link']= '下一页';
//下一页
$config['prev_link']= '';

//$config['attributes'] = array('class' => 'myclass');//给所有<a>标签加上class

$config['uri_segment']=3;//分页的偏移量查询在那一段上面

$config['use_page_numbers'] = TRUE;
$config['query_string_segment'] = 'page';
$config['page_query_string'] = true;