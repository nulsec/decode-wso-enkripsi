<?
function decrypt($data,$filename='',$times=1)
{
    error_reporting(0);
 
    function bulk($str)
    {
        $str = preg_replace('~^\?\>~','',$str);
        return str_ireplace(array('<?php','<?','?>','eval','__FILE__'),array('','','/*','echo','$_FILE__'),$str);
    }
 
    $f = $data;
    $_FILE__=$filename;
     
    for ($i=0;$i<$times;$i++)
    {
        ob_start();
        eval(bulk($f));
        $f = ob_get_contents();
        ob_end_clean();  
    }
    return preg_replace(array('~^\?\>~','~\<\?$~'),'',$f);
}
 
 
$data = file_get_contents('encodedfile.php');
 
echo decrypt($data, 'encodedfile.php', 3);
?>
