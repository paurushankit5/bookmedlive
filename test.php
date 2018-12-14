<?php
    $name   =   "IOMKILOLIKTCJIOPLLPO";          // Reading input from STDIN
    function check_plaindrome($string) {
        //remove all spaces
        $string = str_replace(' ', '', $string);
    
        //remove special characters
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    
        //change case to lower
       // $string = strtolower($string);
    
        //reverse the string
        if(strlen($string)<2)
        {
            return '';
        }
        $reverse = strrev($string);
    
        if ($string == $reverse) {
            return $reverse;
        } 
        else {
            return '';
        }
    }

    $len = strlen($name);
   // $len=5;
    for($i=$len;$i>=2;$i--)
    {
        for($j=0;$j<=$len;$j++)
        {
            if($i!=$j)
            {
                echo $j." - ".$i."<br>";
                $data = substr($name,$j,$i);
                
                $res = check_plaindrome($data);
                if($res !='')
                {
                    $result[]   =   $res;
                }
            }
        } 
    } 
    $array = array_unique($result);
    $array = array_values(array_filter($array));
    //echo "<pre>";
    //print_r($array); 
    if (strpos("iloli", 'lol') !== false)
   // echo 'true';
    $final  = array();
    for($i=0;$i<=count($array)-1;$i++)
    {
        $flag = false;
        foreach ($array as $x) {
            if($x!=$array[$i])
            {
               // echo $array[$i]." -- ".$x."<br>";
                if (strpos($array[$i], $x) == true)
                {
                    $flag=true;
                    //echo $x." <br";
                    $final[] = $x;
                }
            }
        } 
         
    }
    $final =    array_unique($final); 
    //print_r($final);
    $final2 = $result=array_diff($array,$final);
   // print_r($final2);
    echo implode(", ",$final2);
?>
