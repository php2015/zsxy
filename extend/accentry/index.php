<head>
    <style type="text/css">
        TR {
            height: 30;
        }

        TD {
            FONT-SIZE: 9pt;
        }

        SELECT {
            FONT-SIZE: 9pt
        }

        OPTION {
            COLOR: #5040aa;
            FONT-SIZE: 9pt
        }

        INPUT {
            FONT-SIZE: 9pt
        }
    </style>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var pathUrl = window.location.href.substring(0, window.location.href.lastIndexOf("/") + 1);
            $(".wsUrl").each(function () {
                $(this).attr("href", pathUrl + this.id + ".php");
                $(this).text(pathUrl + this.id + ".php");
            })
        });
    </script>
</head>
<body bgcolor="#FFFFFF">
<!--分账-->
<table width="600" border="1" cellspacing="0" cellpadding="3"
       bordercolordark="#FFFFFF" bordercolorlight="#333333"
       bgcolor="#F0F0FF" align="center">
    <tr bgcolor="#8070FF">
        <td colspan="2">
            <div align="center">
                <font color="#FFFF00"><b>用户开户</b></font>
            </div>
        </td>
    </tr>
    <tr>
        <td>开户短信</td>
        <td>
            <a class="wsUrl" id="openAccSms" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>会员注册开户</td>
        <td>
            <a class="wsUrl" id="memberRegist" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>会员信息查询</td>
        <td>
            <a class="wsUrl" id="queryMemberInfo" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>会员认证渠道查询</td>
        <td>
            <a class="wsUrl" id="queryMemberLevels" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>影印件上传</td>
        <td>
            <a class="wsUrl" id="examine" href="#" target="_blank"></a>
        </td>
    </tr>
</table>
<!--分账-->
<table width="600" border="1" cellspacing="0" cellpadding="3"
       bordercolordark="#FFFFFF" bordercolorlight="#333333"
       bgcolor="#F0F0FF" align="center">
    <tr bgcolor="#8070FF">
        <td colspan="2">
            <div align="center">
                <font color="#FFFF00"><b>分账交易</b></font>
            </div>
        </td>
    </tr>
    <tr>
        <td>综合网关</td>
        <td>
            <a class="wsUrl" id="pay" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>H5网关</td>
        <td>
            <a class="wsUrl" id="payh5" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>统一下单</td>
        <td>
            <a class="wsUrl" id="scanOrdPay" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>收款扫码</td>
        <td>
            <a class="wsUrl" id="pospay" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>微商线下</td>
        <td>
            <a class="wsUrl" id="onlinePay" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>分账确认</td>
        <td>
            <a class="wsUrl" id="unfreeze" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>退款</td>
        <td>
            <a class="wsUrl" id="accRefund" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>提现</td>
        <td>
            <a class="wsUrl" id="withdraw" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>单笔订单查询</td>
        <td>
            <a class="wsUrl" id="singleOrderQuery" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>单笔交易查询</td>
        <td>
            <a class="wsUrl" id="singleTradeQuery" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>账户余额查询</td>
        <td>
            <a class="wsUrl" id="accountBalanceQuery" href="#" target="_blank"></a>
        </td>
    </tr>
    <tr>
        <td>收支明细查询</td>
        <td>
            <a class="wsUrl" id="paymentDetailQuery" href="#" target="_blank"></a>
        </td>
    </tr> 
</table>
</body>