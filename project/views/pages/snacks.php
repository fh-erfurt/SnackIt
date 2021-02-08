<h1>Snacks</h1>
<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>
<? 
if(isset($products) && !empty($products)) 
    {
    include(__DIR__ . '/../products/list.php');
    }
	
?>
