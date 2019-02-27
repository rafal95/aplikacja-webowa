<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

class Match extends Model
{

    static public function generate($count){

        $liczba_druzyn = $count;
       if($liczba_druzyn%2>0)
            $liczba_druzyn++;
       
       for($i=0;$i<$liczba_druzyn/2;$i++){
           $home_team[$i] = $i+1;
           $away_team[$i] = $liczba_druzyn - $i;
       }

       for($i=0;$i<$liczba_druzyn/2;$i++){
           $druzyna[0] = $home_team[$i];
           $druzyna[1] = $away_team[$i];
           $mecz_kolejki[$i] = $druzyna;
       }

       $kolejka[0] = $mecz_kolejki;
// drugi etap
    for($k=1;$k<$liczba_druzyn-1;$k++){
       if($away_team[0] == $liczba_druzyn){
           $home_team[0] = $away_team[0];
           $away_team[0] = $away_team[$liczba_druzyn/2 -1];
           $druzyn[0] = $home_team[0];
           $druzyn[1] = $away_team[0];
           $mecz_kolejki[0] = $druzyn; 
       }
       else{
           $away_team[0] = $home_team[0];
           $home_team[0] = $away_team[$liczba_druzyn/2 -1];
           $druzyn[0] = $home_team[0];
           $druzyn[1] = $away_team[0];
           $mecz_kolejki[0] = $druzyn; 
       }
       
       $skoku = 0;
       $skokd = 0;
       $ftu = $away_team[0];
       $ftd = $home_team[0];
       for($i=1;$i<$liczba_druzyn/2;$i++){
           if($home_team[0] == $liczba_druzyn){
               $skoku++;
               $home_team[$i] = $ftu+$skoku;
               $away_team[$i] = $away_team[$i-1] - 1;
               if($home_team[$i] == $liczba_druzyn){
                    $home_team[$i] = 1;
                    $ftu = 1;
                    $skoku = 0;
               }
               if($away_team[$i] == 0)
                    $away_team[$i] = $liczba_druzyn-1;
           }
           else{
               $skokd++;
               $home_team[$i] = $home_team[$i-1] + 1;
               $away_team[$i] = $ftd - $skokd;
               if($home_team[$i] == $liczba_druzyn)
                    $home_team[$i] = 1;
               if($away_team[$i] == 0){
                    $away_team[$i] = $liczba_druzyn-1;
                    $ftd = $liczba_druzyn-1;
                    $skokd = 0;
               }
           }
           $druzyn[0] = $home_team[$i];
           $druzyn[1] = $away_team[$i];
           $mecz_kolejki[$i] = $druzyn;
       }
       $kolejka[$k] = $mecz_kolejki;
    }

       /* $count_team = $count;
        $team[0] = 0;
        $team[1] = 0;
        
        for($i=0;$i<=intval($count_team/2);$i++){
            $game[$i] = 0; // game - mecz w kolejce
        }
        /// count -1 zmienic jesli jest nieparzyste
        if($count_team%2 > 0)
            $count_kolejek = $count_team ;
        else
            $count_kolejek = $count_team-1;

        for($k=0;$k<=$count_kolejek;$k++){ // było <= count
            $storage[$k] = $game;
        }
        
        for($k=0;$k<$count_kolejek;$k++){
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
        }*/

       // return $storage;
        return $kolejka;
    }

}
