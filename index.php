<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOKU Payment Page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="https://staging.doku.com/doku-js/assets/css/doku.css"/>
</head>
<body>

<section class="default-width"><!-- start content -->

    <div class="head padd-default"><!-- start head -->
        <div class="left-head fleft">
            <img src="https://staging.doku.com/doku-js/assets/images/logo-merchant1.png" alt="" />
        </div>
        <div class="clear"></div>
    </div><!-- end head -->
            <div class="line"></div>
    <div class="content-payment-channel padd-default"><!-- start content payment channel -->
        <form action="payment/payment.php" method="post" name="frmTester">
	    <div> <!-- mandiri clickpay -->
	    <div class="styled-input" align='CENTER'>
		PLEASE CHOOSE "FORM TYPE"
            </div>
	    <input type="button" value="FULL" class="default-btn" onclick="submitForm();"">
	    <input type="button" value="INLINE" class="default-btn" onclick="submitForm1();"">
        </div><!-- mandiri clickpay -->
        </form>
    </div><!-- end content payment channel -->

</section><!-- end content -->

<div class="footer">
    <div class="">Copyright DOKU 2016</div>
</div>
<script type="text/javascript">
    function submitForm(){
                    frmTester.action = './full/';
        frmTester.submit();
    }
        function submitForm1(){
                    frmTester.action = './inline/';
        frmTester.submit();
    }
</script>
</body>
</html>
