<link rel="stylesheet" type="text/css" href="/static/css/index.css">
<body class="body_bg">
<!--公用头部-->

<!--公用头部-->
<div class="gx_mian">
    <div class="mbx_cs"><a href="">凯撒旅游</a> > <a href="">订单管理 </a> > <a href="">订单列表</a></div>
    <div class="sea_con">
        <form action="/order/orderlist" method="post">
            <ul>
                <li><label>订单号：</label><input type="text" name="order_id" value=""></li>
                <li><label>供应商产品编号：</label><input type="text" name="product_code" value=""></li>
                <li><label>产品名称：</label><input type="text" name="product_name" value=""></li>
                <li>
                    <label>下单日期：</label>
                    <input type="text" name="startOrderDate" value="">-
                    <input type="text" name="endOrderDate" value="">
                </li>
                <li>
                    <label>出团日期：</label>
                    <input type="text" name="startOutDate" value="">-
                    <input type="text" name="endOutDate" value="">
                </li>
            </ul>
        <p class="btn"><input type="submit" name="search" value="查询"></p>
        </form>
    </div>
    <div class="index_bot">

        <div class="public_table">
            <table>
                <tr>
                    <th><span class="wd45"><i></i></span></th>
                    <th><span class="wd120">订单编号</span></th>
                    <th><span class="wd120">供应商产品编号</span></th>
                    <th><span class="wd250">产品名称</span></th>
                    <th><span class="wd80">订单人数</span></th>
                    <th><span class="wd200">退订人数</span></th>
                    <th><span class="wd120">出团日期</span></th>
                    <th><span class="wd80">截团日期</span></th>
                    <th><span class="wd80">下单时间</span></th>
                    <th><span class="wd125">订单状态</span></th>
                    <th><span class="wd80">订单结算总价</span></th>
                    <th><span class="wd120">面签通知</span></th>
                    <th><span class="wd120">操作</span></th>
                </tr>
                <?php if($list['supplyOrderBases'] && $list['supplyOrderBases']){?>
                    <?php foreach ($list['supplyOrderBases'] as $orderBase){ ?>
                        <tr>
                        <td><span class="wd45"><i></i></span></td>
                        <td><span class="wd120"><?php echo $orderBase['orderNumber'];?></span></td>
                        <td><span class="wd120">demo....</span></td>
                        <td><span class="wd250">demo..</td>
                        <td><span class="wd80"><?php echo $orderBase['orderTotalNum'];?></span></td>
                        <td><span class="wd80"><?php echo $orderBase['quitNumber'];?></span></td>
                        <td><span class="wd120"><?php echo $orderBase['outDate'];?></span></td>
                        <td>
                            <span class="wd200"><?php echo $orderBase['closeDate'];?></span>
                        </td>
                        <td>
                            <span class="wd250"><?php echo $orderBase['payDate'];?></span>
                        </td>
                        <td>
                            <span class="wd80"><?php echo $orderBase['orderStatus'];?></span>
                        </td>
                        <td>
                            <span class="wd200"><?php echo $orderBase['settlePrice'];?></span>
                        </td>
                        <td><span class="wd120"><?php echo $orderBase['outDate'];?></span></td>
                        <td>
                            <span class="wd200">
                              <a>查看</a>&nbsp;
                              <a>修改</a>
                            </span>
                        </td>

                </tr>
                    <?php }?>
                <?php }?>

            </table>
        </div>
        <div class="page_box">

             <?php echo $pagination;?>

        </div>
    </div>
</div>

<!--公用底部-->

<!--公用底部-->
</body>


