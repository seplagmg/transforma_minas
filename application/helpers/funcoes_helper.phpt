<?php
function minus_maius
       

        if(strlen($texto) > 0){
                if(strtoupper($texto) == $texto){
                       
                       
                        return false;
                }
                if(strtolower($texto) == $texto){
                       
                       
                        return false;
                }
        }
        return true;
}
?>
