
    <h3>Spielplan:</h3>
    <div class="w3-responsive">
        <table class="w3-table w3-striped w3-bordered">
            <thead>
            <tr class="w3-primary">
                <th></th>
                <th>Mannschaft</th>
                <th >Wertigkeit</th>
            </tr>
            </thead>

            <?php
            $number=$spielplan->getPlaetze();
            if($group!=0){
                $number=4;
            }
            for($i=0;$i<$number;$i++){
                //$spiel=$spielplan->getSpiel($i);
                $result=$spielplan->getTeam_Info($i,$group);
                $teamname=$result["teamname"];//wird übergeben
                $wertigkeit=$result["wertigkeit"];
                $index=$i+1;
                echo
                "<tr>
                    <td> $index</td>
                    <td>$teamname</td>
                    <td>$wertigkeit</td>
                    </tr>
                    ";
            }

           ?>

        </table>
    </div>
    <br>



