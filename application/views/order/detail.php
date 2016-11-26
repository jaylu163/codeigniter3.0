
<link rel="stylesheet" type="text/css" href="/static/css/index.css">
<body class="body_bg">
<!--公用头部-->

<!--公用头部-->
<div class="gx_mian">
    <div class="mbx_cs"><a href="">凯撒旅游</a> > <a href="">产品管理 </a> > <a href="">产品详情</a></div>
    <div class="bg_fff pad_bot50">
        <div class="step_name mar_lr50">
            <p>产品名称：北京出发：<?php echo $productName;?></p>
            <p class="price">结算总价：<span><i>¥</i>
                    <?php if(isset($orderInfo['orderBase'])){?>

                    <?php echo abs($orderInfo['orderBase']['settlePrice']);  }?>
                </span></p></div>
        <div class="basic_info">
            <h3>基本信息</h3>
            <?php if(isset($orderInfo['orderBase'])){?>
            <ul>
                <li>订单号：<?php echo $orderInfo['orderBase']['orderNumber'];?></li>
                <li>下单时间：<?php echo $orderInfo['orderBase']['payDate'];?></li>
                <li>出团日期：<?php echo $orderInfo['orderBase']['outDate'];?></li>
                <li>回团日期：<?php echo $orderInfo['orderBase']['returnDate'];?></li>
                <li>产品类型：跟团游</li>
                <li>供应商产品编号：<?php echo $productCode;?></li>
            </ul>
            <?php }?>
        </div>
        <div class="guest_info">
            <h3>客人信息</h3>
            <ul class="mar_bot10">
                <?php if(isset($orderInfo['orderBase'])){?>
                <li>联系人姓名：<?php echo $orderInfo['orderBase']['contactName'];?></li>
                <li>手机号：<?php echo $orderInfo['orderBase']['contactPhone'];?></li>
                <?php }?>
            </ul>
            <div class="public_table">
                <table>
                    <tr>
                        <th><span class="wd120">中文姓名</span></th>
                        <th><span class="wd150">出游证件姓/名</span></th>
                        <th><span class="wd100">类型</span></th>
                        <th><span class="wd100">性别</span></th>
                        <th><span class="wd120">出生日期</span></th>
                        <th><span class="wd100">证件类型</span></th>
                        <th><span class="wd200">证件号码</span></th>
                        <th><span class="wd100">证件有效期</span></th>
                        <th><span class="wd100">当前状态</span></th>
                    </tr>
                    <?php if(isset($orderInfo['customers'])){?>
                        <?php foreach($orderInfo['customers'] as $customer){?>
                            <?php
                            $sex = '';
                            $customerType= '';
                            $customerStatus ='';
                            if((isset($customer['sex'])&& $customer['sex'] )){
                                if(isset($order->sex) && is_array($order->sex)){
                                    if(isset($order->sex[$customer['sex']])){
                                        $sex = $order->sex[$customer['sex']];
                                    }
                                }
                            }

                            if(isset($customer['customerType']) && $customer['customerType']){
                                if(isset($order->customerType) && is_array($order->customerType)){
                                    if(isset($order->customerType[$customer['customerType']])){
                                        $customerType = $order->customerType[$customer['customerType']];
                                    }
                                }

                            }

                            if(isset($customer['customerStatus']) && $customer['customerStatus']){
                                if(isset($order->customerStatus) && is_array($order->customerStatus)){
                                    if(isset($order->customerStatus[$customer['customerStatus']])){
                                        $customerStatus = $order->customerStatus[$customer['customerStatus']];
                                    }
                                }

                            }

                            ?>
                        <tr>
                            <td><span class="wd120"><?php echo $customer['chineseName'];?></span></td>
                            <td><span class="wd150"><?php echo $customer['englishName'];?></span></td>
                            <td><span class="wd100"><?php echo $customerType;?></span></td>
                            <td><span class="wd100"><?php echo $sex;?></td>
                            <td><span class="wd120"><?php echo $customer['birth'];?></span></td>
                            <td><span class="wd100"><?php echo $customer['identityTypeName'];?></span></td>
                            <td><span class="wd200"><?php echo $customer['identityNumber'];?></span></td>
                            <td><span class="wd100"><?php echo date('Y-m-d',strtotime($customer['identityExpireDate']));?></span></td>
                            <td><span class="wd100"><?php echo $customerStatus;?></span></td>
                        </tr>
                        <?php }?>
                    <?php }?>

                </table>
            </div>
        </div>
        <div class="cost_info">
            <h3>费用信息</h3>
            <div class="public_table">
                <table>
                    <tr>
                        <th><span class="wd220">款项名称</span></th>
                        <th><span class="wd200">金额</span></th>
                        <th><span class="wd220">交易时间</span></th>
                        <th><span class="wd250">备注</span></th>
                        <th><span class="wd200">总计</span></th>
                    </tr>
                    <?php if(isset($orderInfo['paymentDetails'])){?>

                        <?php foreach($orderInfo['paymentDetails'] as $detail){?>
                            <tr>
                                <td><span class="wd220"><?php echo $detail['fundName'];?></span></td>
                                <td><span class="wd200"><?php echo $detail['fundMoney'];?></span></td>
                                <td><span class="wd220"><?php echo $detail['payDate'];?></span></td>
                                <td><span class="wd250"><?php echo $detail['remark'];?></span>
                                <td rowspan="<?php echo count($orderInfo['paymentDetails']);?>">
                                    <span class="wd200">
                                        <?php echo ($money>0)?'￥'.$money:0;?>
                                    </span>
                                </td>
                            </tr>

                        <?php }?>

                    <?php }?>


                </table>
            </div>
        </div>
    </div>
</div>
<!--公用底部-->

<!--公用底部-->
</body>
