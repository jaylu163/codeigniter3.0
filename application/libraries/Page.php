<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Page
{

    /**
     +----------------------------------------------------------
     * 分页起始行数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    public $firstRow	;

    /**
     +----------------------------------------------------------
     * 列表每页显示行数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    public $listRows	;

    /**
     +----------------------------------------------------------
     * 页数跳转时要带的参数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $parameter  ;

    /**
     +----------------------------------------------------------
     * 分页总页面数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $totalPages  ;

    /**
     +----------------------------------------------------------
     * 总行数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $totalRows  ;

    /**
     +----------------------------------------------------------
     * 当前页数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    public $nowPage    ;

    /**
     +----------------------------------------------------------
     * 分页的栏的总页数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $coolPages   ;

    /**
     +----------------------------------------------------------
     * 分页栏每页显示的页数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $rollPage   ;
    protected $url   ;



    /**
     +----------------------------------------------------------
     * 分页记录名称
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */

	// 分页显示定制
    //protected $config   =	array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页');
    //protected $config   =	array('header'=>'条记录','prev'=>'&lt;','next'=>'&gt;','first'=>'&lt;&lt;','last'=>'&gt;&gt;');
	protected $config    =	array('header'=>'条记录','prev'=>'&lt;','next'=>'&gt;','first'=>'第一页','last'=>'最后一页');
	protected $chinese   =	array(1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六',7=>'七',8=>'八',9=>'九');

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $firstRow  起始记录位置
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($params)
    {
    	$totalRows = $params['totalRows'];
    	$listRows = $params['pageSize'];
    	$nowPage = $params['currentPage'];
    	$url = '';
    	$parameter='page';
    	
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        $this->rollPage = 4;
        $this->listRows = !empty($listRows)?$listRows:10;
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        $this->url = $url;	
        //$this->nowPage  = !empty($_GET[$parameter])?$_GET[$parameter]:1;
        $this->nowPage = $nowPage;
		$this->goto = 0; //是否跳转
		$this->unset_page = 0;//是否去除分页参数

        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
		$this->limit = $this->firstRow.",".$this->listRows;
    }
	public function setConfig($name,$value) {
		if(isset($this->config[$name])) {
			$this->config[$name]	=	$value;
		}
	}

    private function getAjaxFuntion($ajax_function_name,$pagenum){
       if(strlen($ajax_function_name)==0)return"";
       return " onclick='".$ajax_function_name."(".$pagenum.");return false;'";
    }
    /**
     +----------------------------------------------------------
     * 分页显示
     * 用于在页面显示的分页栏的输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function show($isArray=false,$ajax_function_name=''){
        if(0 == $this->totalRows) return;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
		$url  =  $this->url?$this->url:$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
		$parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            if($this->unset_page)unset($params[$this->pageName]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
		
		/*
		   <a class="pageon" href="#">上一页</a>
		   <a class="state" href="#">1</a>
		   <strong href="#">2</strong>
		   <a href="#">3</a>
		   <a href="#">4</a>
		   <a class="pagedown" href="#">下一页</a>
		*/

        if ($upRow>0){
            $upPage="<a class='pageon' href='".$url."$upRow' ".$this->getAjaxFuntion($ajax_function_name,$upRow).">上一页</a>";
        }else{
            $upPage="<span>上一页</span>";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a class='pagedown' href='".$url."$downRow' ".$this->getAjaxFuntion($ajax_function_name,$downRow).">下一页</a>";
        }else{
            $downPage="<span>下一页</span>";
        }

        // 1 2 3 4 5
        $linkPage = "";
		$startRollPage = ($this->nowPage-ceil($this->rollPage/2))>1?($this->nowPage-ceil($this->rollPage/2)):1;
		if($startRollPage==2){
			$startRollPage = 1;
		}
		$endRollPage = ($startRollPage+$this->rollPage)<$this->totalPages?($startRollPage+$this->rollPage):$this->totalPages;
		if($endRollPage == ($this->totalPages-1)){
			$endRollPage = $this->totalPages;
		}
		for($page=$startRollPage;$page<=$endRollPage;$page++){
			if($page!=$this->nowPage){
				 $linkPage .= "<a href='".$url."$page' ".$this->getAjaxFuntion($ajax_function_name,$page).">".$page."</a>";
			}else{
				if($this->totalPages != 1){
                    $linkPage .= '<strong>'.$page.'</strong>';
                }
			}
		}

		if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $startRollPage - 1;
			$prePage = "<a href='".$url."$preRow' ".$this->getAjaxFuntion($ajax_function_name,$preRow).">...</a>";
            $theFirst = "<a href='".$url."1' ".$this->getAjaxFuntion($ajax_function_name,1).">1</a>";
        }

        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $endRollPage+1;
            $theEndRow = $this->totalPages;
			
			if($nextRow<$this->totalPages){
				$nextPage = "<a class='pagedown' href='".$url."$nextRow' ".$this->getAjaxFuntion($ajax_function_name,$nextRow).">...<b></b></a>";
				$theEnd = "<a class='pagedown' href='".$url."$theEndRow' ".$this->getAjaxFuntion($ajax_function_name,$theEndRow)." >".$this->totalPages."</a>";
			}
        }

		//$pageStr = $theFirst.' '.$upPage.' '.$linkPage.' '.$downPage.' '.$theEnd;
		

		$pageStr = $upPage.' '.$theFirst.' '.$prePage.' '.$linkPage.' '.$nextPage.' '.$theEnd.' '.$downPage;
        if($this->goto && $this->totalPages>1){
        	$pageStr .= "&nbsp;<script>function jumppages(){var jumppage=Math.abs(parseInt(document.getElementById('jumppage').value));if(jumppage>0) return jumppage;else return 1;}</script>跳到<span><form method='get' onsubmit='return false;'><input type='text' name='page' value='".$this->nowPage."' class='gotoinput' id='jumppage' onkey>页&nbsp;&nbsp;<input type='button' value='' class='gotosubmit'  style='cursor:pointer'   onclick='window.location.href=\"".$url."\"+jumppages();'/></form></span>";
        }

        if($isArray) {
            $pageArray['totalRows'] =   $this->totalRows;
            $pageArray['upPage']    =   $url."$upRow";
            $pageArray['downPage']  =   $url."$downRow";
            $pageArray['totalPages']=   $this->totalPages;
            $pageArray['firstPage'] =   $url."1";
            $pageArray['endPage']   =   $url."$theEndRow";
            $pageArray['nextPages'] =   $url."$nextRow";
            $pageArray['prePages']  =   $url."$preRow";
            $pageArray['linkPages'] =   $linkPage;
			$pageArray['nowPage'] =   $this->nowPage;
        	return $pageArray;
        }

        return $pageStr;
    }

	 public function show2($isArray=false,$ajax_function_name=''){
        if(0 == $this->totalRows) return;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
		$url  =  $this->url?$this->url:$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'&':"?").$this->parameter;
		$parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            if($this->unset_page)unset($params[$this->pageName]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
		
		/*
		   <a class="pageon" href="#">上一页</a>
		   <a class="state" href="#">1</a>
		   <strong href="#">2</strong>
		   <a href="#">3</a>
		   <a href="#">4</a>
		   <a class="pagedown" href="#">下一页</a>
		*/
        if ($upRow>0){
            $upPage="<a class=\"pageup\" href=\"".$url."$upRow\" ".$this->getAjaxFuntion($ajax_function_name,$upRow)." title=\"上一页\"><em></em>上一页</a>";
        }else{
            $upPage='<a class="pageup pageup-dis" href="javascript:void(0)" title="上一页"><em></em>上一页</a>';
        }
        if ($downRow <= $this->totalPages){
			$downPage="<a class=\"pagedown\" href=\"".$url."$downRow\" ".$this->getAjaxFuntion($ajax_function_name,$downRow)." title=\"下一页\">下一页<em></em></a>";
        }else{
            $downPage="<a class=\"pagedown pagedown-dis\" href=\"javascript:void(0)\" title=\"下一页\">下一页<em></em></a>";
        }

        // 1 2 3 4 5
        $linkPage = "";
		$startRollPage = ($this->nowPage-ceil($this->rollPage/2))>1?($this->nowPage-ceil($this->rollPage/2)):1;
		if($startRollPage==2){
			$startRollPage = 1;
		}
		$endRollPage = ($startRollPage+$this->rollPage)<$this->totalPages?($startRollPage+$this->rollPage):$this->totalPages;
		if($endRollPage == ($this->totalPages-1)){
			$endRollPage = $this->totalPages;
		}
		for($page=$startRollPage;$page<=$endRollPage;$page++){
			if($page!=$this->nowPage){
				 $linkPage .= "<a class='on' href='".$url."$page' ".$this->getAjaxFuntion($ajax_function_name,$page).">".$page."</a>";
			}else{
				if($this->totalPages != 1){
                    $linkPage .= '<a class="current" href="javascript:void(0)">'.$page.'</a>';
                }
			}
		}

		if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $startRollPage - 1;
			$prePage = "<span>...</span>";
            $theFirst = "<a href='".$url."1' ".$this->getAjaxFuntion($ajax_function_name,1).">1</a>";
        }

        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $endRollPage+1;
            $theEndRow = $this->totalPages;
			
			if($nextRow<$this->totalPages){
				$nextPage = "<span>...</span>";
				$theEnd = "<a class='pagedown' href='".$url."$theEndRow' ".$this->getAjaxFuntion($ajax_function_name,$theEndRow)." >".$this->totalPages."</a>";
			}
        }

		//$pageStr = $theFirst.' '.$upPage.' '.$linkPage.' '.$downPage.' '.$theEnd;
		$pageStr = $upPage.' '.$theFirst.' '.$prePage.' '.$linkPage.' '.$nextPage.' '.$theEnd.' '.$downPage;
        if($this->goto && $this->totalPages>1){
        	$pageStr .= "&nbsp;<script>function jumppages(){var jumppage=Math.abs(parseInt(document.getElementById('jumppage').value));if(jumppage>0) return jumppage;else return 1;}</script>跳到<span><form method='get' onsubmit='return false;'><input type='text' name='page' value='".$this->nowPage."' class='gotoinput' id='jumppage' onkey>页&nbsp;&nbsp;<input type='button' value='' class='gotosubmit'  style='cursor:pointer'   onclick='window.location.href=\"".$url."\"+jumppages();'/></form></span>";
        }

        if($isArray) {
            $pageArray['totalRows'] =   $this->totalRows;
            $pageArray['upPage']    =   $url."$upRow";
            $pageArray['downPage']  =   $url."$downRow";
            $pageArray['totalPages']=   $this->totalPages;
            $pageArray['firstPage'] =   $url."1";
            $pageArray['endPage']   =   $url."$theEndRow";
            $pageArray['nextPages'] =   $url."$nextRow";
            $pageArray['prePages']  =   $url."$preRow";
            $pageArray['linkPages'] =   $linkPage;
			$pageArray['nowPage'] =   $this->nowPage;
        	return $pageArray;
        }

        return $pageStr;
    }

	public function show3($query_string='')
	{
        if(0 == $this->totalRows) return;
        $nowCoolPage = ceil($this->nowPage/$this->rollPage);
		$url  =  $this->url;

        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<a class=\"pageup\" href=\"".$url."${upRow}${query_string}\" title=\"上一页\"><em></em>上一页</a>";
        }else{
            $upPage='<a class="pageup pageup-dis" href="javascript:void(0)" title="上一页"><em></em>上一页</a>';
        }
        if ($downRow <= $this->totalPages){
			$downPage="<a class=\"pagedown\" href=\"".$url."${downRow}${query_string}\" title=\"下一页\">下一页<em></em></a>";
        }else{
            $downPage="<a class=\"pagedown pagedown-dis\" href=\"javascript:void(0)\" title=\"下一页\">下一页<em></em></a>";
        }
        // 1 2 3 4 5
        $linkPage = "";
		$startRollPage = ($this->nowPage-ceil($this->rollPage/2))>1?($this->nowPage-ceil($this->rollPage/2)):1;
		if($startRollPage==2){
			$startRollPage = 1;
		}
		$endRollPage = ($startRollPage+$this->rollPage)<$this->totalPages?($startRollPage+$this->rollPage):$this->totalPages;
		if($endRollPage == ($this->totalPages-1)){
			$endRollPage = $this->totalPages;
		}
		for($page=$startRollPage;$page<=$endRollPage;$page++){
			if($page!=$this->nowPage){
				 $linkPage .= "<a href='".$url."${page}${query_string}'>".$page."</a>";
			}else{
				if($this->totalPages != 1){
                    $linkPage .= '<a class="current" href="javascript:void(0)">'.$page.'</a>';
                }
			}
		}
		if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $startRollPage - 1;
			$prePage = "<span>...</span>";
            $theFirst = "<a href='".$url."1${query_string}'>1</a>";
        }

        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $endRollPage+1;
            $theEndRow = $this->totalPages;
			
			if($nextRow<$this->totalPages){
				$nextPage = "<span>...</span>";
				$theEnd = "<a class='pagedown' href='".$url."${theEndRow}${query_string}'>".$this->totalPages."</a>";
			}
        }
		$pageStr = $upPage.' '.$theFirst.' '.$prePage.' '.$linkPage.' '.$nextPage.' '.$theEnd.' '.$downPage;
        return $pageStr;
    }





    public function show4($isArray=false,$ajax_function_name=''){
        if(0 == $this->totalRows) return;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $this->url?$this->url:$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'&':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            if($this->unset_page)unset($params[$this->pageName]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        
        /*
           <a class="pageon" href="#">上一页</a>
           <a class="state" href="#">1</a>
           <strong href="#">2</strong>
           <a href="#">3</a>
           <a href="#">4</a>
           <a class="pagedown" href="#">下一页</a>

           <p class="contentright_tab_p">
                    <div class="num">{:$page_str}</div>
                    <a class="login_Paging">上一页</a>
                    <a class="login_Paging_s">1</a>
                    <a class="login_Paging_s">2</a>
                    <a class="login_Paging_s">3</a>
                    <a class="login_Paging">下一页</a>
                    </p>
        */
        if ($upRow>0){
            $upPage="<a class=\"login_Paging\" href=\"".$url."$upRow\" ".$this->getAjaxFuntion($ajax_function_name,$upRow)." title=\"上一页\"><em></em>上一页</a>";
        }else{
            $upPage='<a class="login_Paging" href="javascript:void(0)" title="上一页"><em></em>上一页</a>';
        }
        if ($downRow <= $this->totalPages){
            $downPage="<a class=\"login_Paging\" href=\"".$url."$downRow\" ".$this->getAjaxFuntion($ajax_function_name,$downRow)." title=\"下一页\">下一页<em></em></a>";
        }else{
            $downPage="<a class=\"login_Paging\" href=\"javascript:void(0)\" title=\"下一页\">下一页<em></em></a>";
        }

        // 1 2 3 4 5
        $linkPage = "";
        $startRollPage = ($this->nowPage-ceil($this->rollPage/2))>1?($this->nowPage-ceil($this->rollPage/2)):1;
        if($startRollPage==2){
            $startRollPage = 1;
        }
        $endRollPage = ($startRollPage+$this->rollPage)<$this->totalPages?($startRollPage+$this->rollPage):$this->totalPages;
        if($endRollPage == ($this->totalPages-1)){
            $endRollPage = $this->totalPages;
        }
        for($page=$startRollPage;$page<=$endRollPage;$page++){
            if($page!=$this->nowPage){
                 $linkPage .= "<a class='login_Paging_s' href='".$url."$page' ".$this->getAjaxFuntion($ajax_function_name,$page).">".$page."</a>";
            }else{
                if($this->totalPages != 1){
                    $linkPage .= '<a class="login_Paging_s" href="javascript:void(0)">'.$page.'</a>';
                }
            }
        }
        
        if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $startRollPage - 1;
            $prePage = "<span>...</span>";
            $theFirst = "<a href='".$url."1' ".$this->getAjaxFuntion($ajax_function_name,1).">1</a>";
        }
        
        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $endRollPage+1;
            $theEndRow = $this->totalPages;
            
            if($nextRow<$this->totalPages){
                $nextPage = "<span>...</span>";
                $theEnd = "<a class='pagedown' href='".$url."$theEndRow' ".$this->getAjaxFuntion($ajax_function_name,$theEndRow)." >".$this->totalPages."</a>";
            }else{
            	$theEnd = '';
            	$nextPage = '';
            }
        }
        
        //$pageStr = $theFirst.' '.$upPage.' '.$linkPage.' '.$downPage.' '.$theEnd;

        $pageStr = $upPage.' '.$theFirst.' '.$prePage.' '.$linkPage.' '.$nextPage.' '.$theEnd.' '.$downPage;
        if($this->goto && $this->totalPages>1){
            $pageStr .= "&nbsp;<script>function jumppages(){var jumppage=Math.abs(parseInt(document.getElementById('jumppage').value));if(jumppage>0) return jumppage;else return 1;}</script>跳到<span><form method='get' onsubmit='return false;'><input type='text' name='page' value='".$this->nowPage."' class='gotoinput' id='jumppage' onkey>页&nbsp;&nbsp;<input type='button' value='' class='gotosubmit'  style='cursor:pointer'   onclick='window.location.href=\"".$url."\"+jumppages();'/></form></span>";
        }
        
        if($isArray) {
            $pageArray['totalRows'] =   $this->totalRows;
            $pageArray['upPage']    =   $url."$upRow";
            $pageArray['downPage']  =   $url."$downRow";
            $pageArray['totalPages']=   $this->totalPages;
            $pageArray['firstPage'] =   $url."1";
            $pageArray['endPage']   =   $url."$theEndRow";
            $pageArray['nextPages'] =   $url."$nextRow";
            $pageArray['prePages']  =   $url."$preRow";
            $pageArray['linkPages'] =   $linkPage;
            $pageArray['nowPage'] =   $this->nowPage;
            return $pageArray;
        }
      
        return $pageStr;
    }

}
