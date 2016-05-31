<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 foreach($nodes as $nod){
     echo $nod->getProperty('firstname').' '.$nod->getProperty('lastname').'  --  '.$nod->getProperty('position').'<br/>';
 }