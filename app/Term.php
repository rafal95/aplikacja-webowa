<?php

namespace App;


class Term 
{

    static public function generate($count){

        $count_team = $count;
        $team[0] = 0;
        $team[1] = 0;
        
        for($i=0;$i<=intval($count_team/2);$i++){
            $game[$i] = 0;
        }

        for($k=0;$k<=$count_team-1;$k++){
            $storage[$k] = $game;
        }
        
        for($k=0;$k<$count_team-1;$k++){
            $b=1;
            for($i=0;$i<intval($count_team/2);$i++){
                $a=1;
        
                    $team[0]=rand(1,$count_team);
                    do{
                        $team[1]=rand(1,$count_team);
                    }while($team[1]==$team[0]);
                
                    for($j=0;$j<=$i;$j++) { 
                        if($team[0]==$game[$j][0] or $team[0]==$game[$j][1] or $team[1]==$game[$j][0] or $team[1]==$game[$j][1] ){   
                                $i--;
                                $a=0;
                                break;
                            }
                    }
                if($a){
                $game[$i+1]=$team;
                }
        
            }
        
        
            for($l=0;$l<=$k;$l++){
                $c=1;
                for($j=1;$j<=intval($count_team/2);$j++){
                    for($i=1;$i<=intval($count_team/2);$i++){
                        if($storage[$l][$i][0] == $game[$j][0] and $storage[$l][$i][1] == $game[$j][1] or $storage[$l][$i][0] == $game[$j][1] and $storage[$l][$i][1] == $game[$j][0] ){
                            $c = 0;
                            break;
                        }
                    }
                }
                if($c==0){
                    $k--;
                    $b=0;
                    break;
                }
            }

            if($b){
            $storage[$k] = $game;}
        }

        return $storage;

    }

}


