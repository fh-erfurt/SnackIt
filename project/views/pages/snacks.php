<h1>Snacks</h1>
<? 
print_r($products);
if(isset($products) && !empty($products)) //DIE VARIABLE IST NICHT VORHANDEN ABER DER GRUND DAFÜR IST NICHT BEKANNT
    {
    include(__DIR__ . '/../products/list.php');
    }
?>
