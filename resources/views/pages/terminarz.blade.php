<?php

    print_r($high_group);

     /*  $liczba_druzyn = count($teams);
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
//wypis
    for($k=0;$k<$liczba_druzyn-1;$k++){
       for($i=0;$i<$liczba_druzyn/2;$i++){
            echo $kolejka[$k][$i][0];
            echo "-";
            echo $kolejka[$k][$i][1];
            echo " ";
       }
       echo "</br>";
    }
       /* $count_team = count($teams);
        $team[0] = 0;
        $team[1] = 0;*/
     /*   //liczba meczy w kolejce
        for($i=0;$i<=intval($count_team/2);$i++){
            $game[$i] = 0;
        }
        // liczba kolejek 
        for($k=0;$k<=$count_team;$k++){
            $storage[$k] = $game;
        }
        
        for($k=0;$k<$count_team;$k++){ // dla kazdej kolejki
            $b=1;
            print_r($k);
            echo "</br>";
            for($i=0;$i<intval($count_team/2);$i++){ // dla akzdego meczu w kolejce
                $a=1;
                print_r($i);
                echo "</br>";
                    //losowanie par 
                    $team[0]=rand(1,$count_team); 
                    do{
                        $team[1]=rand(1,$count_team);
                    }while($team[1]==$team[0]);
                    //print_r($team);
                    // sprawdzanie czy wylosowane druzyny już graja w tej kolejce 
                    for($j=0;$j<=$i;$j++) { 
                        if($team[0]==$game[$j][0] or $team[0]==$game[$j][1] or $team[1]==$game[$j][0] or $team[1]==$game[$j][1] ){   
                                $i--;  // jezeli wylosowane druzyny juz graja w tej kolejce to -- liczba meczy
                                $a=0;   
                                echo "pow";
                                break;
                            }
                    }
                    // jezeli wylosowane druzyny nie graja w kolejce to kolejny mecz w kolecje = para druzyn
                if($a){
                    $flag =0;
                   $game[$i+1]=$team;
                   for($l=0;$l<=$k;$l++){
                        for($n=1;$n<=intval($count_team/2);$n++){
                            if($storage[$l][$n][0] == $game[$i+1][0] and $storage[$l][$n][1] == $game[$i+1][1] or $storage[$l][$n][0] == $game[$i+1][1] and $storage[$l][$n][1] == $game[$i+1][0] ){
                                $flag= 1;
                                $i--;
                                break;
                            }
                        }
                        if($flag)
                            break;
                   }
                }     
            }
        $storage[$k] = $game;
            // sprawdzanie czy taki mecz był już w poprzednich kolejkach
           /* for($l=0;$l<=$k;$l++){ //czyzby tutaj l<k?
                echo "kolejka: ";
                print_r($l);
                echo "</br>";
                $c=1;
                for($j=1;$j<=intval($count_team/2);$j++){ // czy mecz game[j]
                    for($i=1;$i<=intval($count_team/2);$i++){ //jest w kolejncyh kolejkach
                        print_r($game[$j]);
                        echo "  ";
                        print_r($storage[$l][$i]);
                        echo "</br>";
                        if($storage[$l][$i][0] == $game[$j][0] and $storage[$l][$i][1] == $game[$j][1] or $storage[$l][$i][0] == $game[$j][1] and $storage[$l][$i][1] == $game[$j][0] ){
                            echo "pow ";
                            echo "</br>";
                            print_r($game[$j]);
                            echo "  ";
                            print_r($storage[$l][$i]);
                            echo "</br>";
                            $c = 0;
                            break;
                        }
                    }
                    if($c==0)
                        break;
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

/*for($k=0;$k<$count_team;$k++){//kolejek
for($i=1;$i<=intval($count_team/2);$i++){// meczy w
    echo $storage[$k][$i][0];
    echo "-";
    echo $storage[$k][$i][1];
    echo " ";
}
echo "</br>";
}*/



?> 