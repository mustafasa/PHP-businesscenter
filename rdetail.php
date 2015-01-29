<?php 
//check for user admin authorization
session_start();
if (!isset($_SESSION["admin"]) || (time() - $_SESSION['login_time']) >3600) {
    header("location: logout.php"); 
    exit();
}

$adminid = preg_replace('#[^0-9]#i', '', $_SESSION["adminid"]); // filter everything but numbers and letters
$admin = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["admin"]); // filter everything but numbers and letters
$adminp =  $_SESSION["adminp"];

include ("mysqli.php");
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and receipt=1 LIMIT 1 ";
	$query3 = mysqli_query($db_conx, $sql3);
	$productCount3 =  mysqli_num_rows($query3);
	$muser="";
	while ($row = $query3->fetch_assoc()) { 
$name=ucfirst($row['name']);
$hr = $row['hr'];
$tenant = $row['tenant'];
$inquery = $row['inquery'];
$cheque = $row['cheque'];
$asset = $row['assset'];
$service = $row['service'];
$auser=$row['auser'];
$receipt = $row['receipt'];
$expense=$row['expense'];
$dpass = $row['password'];
}

if ((crypt($adminp ,$dpass ) != $dpass) || ($productCount3==0)){ // evaluate the count
	header("location: logout.php"); 
     exit();
}
$_SESSION['login_time'] = time();
?>
<?php
//get list of asset
    include ("mysqli.php");
if (isset($_GET['id'])) {
	$id = $_GET['id'];
$sql ="SELECT * FROM  receipt where id=$id ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
$row = $query->fetch_assoc();

$sdate = date('d-m-Y', strtotime($row['date']));
$tid = $row['tid'];
$sid = $row['sid'];
$recfrm =$row['recfrm'];
$amount = $row['amount'];
$pmethod =$row['pmethod'];
$fors = $row['fors'];
$regby =$row['regby'];
$cdate = $row['cdate'];
$bname =$row['bname'];
$amounts=floor($amount);
//convert number to words
function convert_number_to_words($number) {
    
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}

$wordamount= convert_number_to_words($amounts);
}

}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Center Solution</title>
</head>
<style>
@media print {
	body{
	
  -webkit-print-color-adjust:exact;
}
}
td{font-size:13px; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; color:#666;}
.ab{border: 2px solid #030; width:800px;}
</style>
<body >
<div class="ab" >
<table width="800px;" height="464" style="padding:4px 4px 4px 4px;">
<tr><td height="102" colspan="2"></td>
<td width="205">Tel.: +974232323<br />
Fax.: +9744234327<br />Email:info@bluelynx.qa<br />P.O.Box:6029<br />Doha - Qatar</td></tr>
<tr>
  <td height="30" colspan="3" align="center" ><h2 style="color:#063"> &nbsp;&nbsp;Cash/Cheque Receipt Voucher</h2></td></tr>
<tr><td width="295" height="30" ><strong>No.</strong><span style="color:#900; font-size:18px;"> <?php echo $id;?></span></td><td width="278"><strong>AMOUNT</strong><span style="border: 1px solid #030; margin-left:5px; font-size:16px;  "> <?php echo $amount;?>/- &nbsp;</span></td><td><strong>Date</strong> <?php echo $sdate;?></td></tr>
<tr><td height="30" style="padding-top:20px;" ><strong>Tenant ID:</strong> <?php echo $tid;?></td><td colspan="2"><strong>Service ID:</strong> <?php echo $sid;?></td></tr>
<tr><td height="30" colspan="3"><strong>Received from Mr/M/s:</strong><?php echo ucfirst($recfrm);?></td></tr>
<tr><td height="30" colspan="3"><strong>The Sum of </strong><?php echo strtoupper($wordamount);?></td></tr>
<tr><td height="30" colspan="2"><strong>By Cash/Cheque No. </strong><?php echo $pmethod;?></td><td><strong>Dated: </strong><?php echo $cdate;?></td></tr>
<tr><td height="30" colspan="3"><strong>Bank</strong> <?php echo $bname;?></td></tr>
<tr><td height="30" colspan="3"><strong>Being</strong> <?php echo $fors;?></td></tr>
<tr><td colspan="3" align="right" style="padding-right:40px;"><strong>Receiver</strong></td></tr>
</table>

</div>

</body>
</html>