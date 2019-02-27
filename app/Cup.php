<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    static public function generate_cup($count){
        $count_team = $count;
        $count_team_per_group = 0;
        $high_group = 0;

       /* if($count_team < 6){
            $count_group = 1;
            $count_team_per_group = $count_team;
        }
        else if($count_team == 6){
            $count_group = 2;
            $count_team_per_group = 3;
        }
        else if($count_team >= 19 and $count_team<=20){
            if($count_team % 5 > 0){
                $count_group = intval($count_team/5)+1;
                $high_group = intval($count_team/5);
            }
            else{
                $count_group = intval($count_team/5);
                $high_group = $count_group;
                $count_team_per_group = 5;
            }
        }
        else if($count_team >= 21 and $count_team<=27){
            if($count_team % 3 > 0){
                $count_group = intval($count_team/3);
                $high_group = $count_team % 3;
            }
            else{
                $count_group = intval($count_team/3);
                $count_team_per_group = 3;
            }
        }
        else if($count_team % 4 > 0){
            if($count_team % 4 <= 2){/// sprawdzuc ile grup ma miec wiecej druzyn
                $count_group = intval($count_team/4);
                //$count_team_per_group = 4+1;
                $high_group = $count_team % 4;
            }
            else{
                $count_group = intval($count_team/4)+1;
                $count_team_per_group = 4;
            }
        }
        else if($count_team % 4 == 0){
            $count_group = intval($count_team/4);
            $count_team_per_group = 4;
        }*/
        //nowe
        $count_group = intval($count_team/4);
        if($count_team == 6){
            $count_group = 2;
            $count_team_per_group = 3;
        }
        else if($count_team == 19){
            $count_group = intval($count_team/5)+1;
            $high_group = intval($count_team/5);
        }
        else if($count_team == 20){
            $count_group = intval($count_team/5);
            $high_group = $count_group;
            $count_team_per_group = 5;
        }
        else if($count_team >= 21 and $count_team<27){
            if($count_team % 3 > 0){
                $count_group = intval($count_team/3);
                $high_group = $count_team % 3;
            }
            else{
                $count_group = intval($count_team/3);
                $count_team_per_group = 3;
            }
        }
        else if($count_team % 4 > 0){
            if($count_team % 4 <= 2){/// sprawdzuc ile grup ma miec wiecej druzyn
                $count_group = intval($count_team/4);
                $high_group = $count_team % 4;
            }
            else{
                $count_group = intval($count_team/4)+1;
                $count_team_per_group = 4;
            }
        }
        else if($count_team % 4 == 0){
            $count_group = intval($count_team/4);
            $count_team_per_group = 4;
        }
        
        
       // $count_team_per_group = 4;
        //endnowe

        $count = 0;
        for($i=0;$i<=$count_group;$i++){
           /* if($count_team >= 21 and $count_team<=27){               
                if($i+1<=$high_group)
                    $count_team_per_group = 4;
                else
                    $count_team_per_group = 3;
            }else{
                if($i+1<=$high_group)
                    $count_team_per_group = 5;
                else
                    $count_team_per_group = 4;
            }*/

            //new
            if($count_team >= 21 and $count_team<27){               
                if($i+1<=$high_group)
                    $count_team_per_group = 4;
                else
                    $count_team_per_group = 3;
            }
            else{
                if($high_group > 0 ){
                    if($i+1<=$high_group)
                        $count_team_per_group = 5;
                    else
                        $count_team_per_group = 4;
                }
            }

            ///end nwe
            for($j=0;$j<$count_team_per_group;$j++){
                $group[$i][$j] = 0;
            }   
        }

        $count = 0;
        
        for($i=0;$i<$count_group;$i++){
            //echo "grupa $i";  jezeli i jest mneijsze lub rowne liczbie grup ktore maja peic druzyn 
            //echo "</br>";     to count per group = 5 else 4

          /*  if($count_team >= 21 and $count_team<=27){               
                if($i+1<=$high_group)
                    $count_team_per_group = 4;
                else
                    $count_team_per_group = 3;
            }else{
                if($i+1<=$high_group)
                    $count_team_per_group = 5;
                else
                    $count_team_per_group = 3;//yu
            }*/

            if($count_team >= 21 and $count_team<27){               
                if($i+1<=$high_group)
                    $count_team_per_group = 4;
                else
                    $count_team_per_group = 3;
            }
            else{
                if($high_group > 0 ){
                    if($i+1<=$high_group)
                        $count_team_per_group = 5;
                    else
                        $count_team_per_group = 4;
                }
            }

            for($j=0;$j<$count_team_per_group;$j++){
                if($count<$count_team){
                    $a=1;
                    $team = rand(1,$count_team);
                   // echo $team;
                    for($k=0;$k<=$i;$k++){
                     //   echo "-";
                       // echo $k;
                       // echo "</br>";

                  /*  if($count_team >= 21 and $count_team<=27){               
                        if($k+1<=$high_group)
                            $count_team_per_group = 4;
                        else
                            $count_team_per_group = 3;
                    }else{
                        if($k+1<=$high_group)
                            $count_team_per_group = 5;
                        else
                            $count_team_per_group = 3;//yu
                    }*/
                    $count_team_per_groupt = 3;
                    if($count_team >= 21 and $count_team<27){               
                        if($k+1<=$high_group)
                            $count_team_per_group = 4;
                        else
                            $count_team_per_group = 3;
                    }
                    else{
                        if($high_group > 0 ){
                            if($k+1<=$high_group)
                                $count_team_per_group = 5;
                            else
                                $count_team_per_group = 4;
                        }
                    }
                   /* else if($count_team % 4 <= 1){
                        $count_team_per_groupt = 4;
                    }*/
                        

                        for($l=0;$l<$count_team_per_group;$l++){
                            if($team == $group[$k][$l]){
                               $j--;
                              // $count--;
                               $a=0;
                               break;
                         //    echo " ist ";
        
                            }
                           //echo $group[$k][$l];
                           //echo "-";
                        }
                        if($a==0) break;
                    }
                   // echo "</br>";
                    if($a){
                    $group[$i][$j] = $team;
                    $count++;}
                }
                else {
                    break;
                }
            }
        }
        
        
        
        //wypis
       /* $count = 0;
        for($i=0;$i<$count_group;$i++){
            echo "grupa $i";
            echo "</br>";
            for($j=0;$j<4;$j++){
                if($count<$count_team){
                    echo " ";
                    echo $group[$i][$j];
                    echo "</br>";
                    $count++;
                }
                else{
                    break;
                }
            }
        }*/

        return $group;
    }
}
