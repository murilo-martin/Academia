<?php

session_start();



include "mysqlconecta.php";

$repetições = "0x0";

$porSemana = $_SESSION['porSemana'];
$areaCorpo = $_SESSION['focoCorpo'];


function pegafoco($foco)
{

    if ($foco == 1) {

        return '3 x 15';

    }
    if ($foco == 2) {

        return '3 x 8 a 12';

    }

    return '4 x 8 a 15';


}


function pegaExercicios($area, $qtd_exercicios)
{
    include "mysqlconecta.php";

    $query = mysqli_query($conexao, "SELECT id_exerc FROM exercicios WHERE tipo LIKE '$area'");

    $ids_exerc_exerc = [];
    while ($result = mysqli_fetch_array($query)) {

        array_push($ids_exerc_exerc, $result[0]);

    }
    shuffle($ids_exerc_exerc);

    mysqli_close($conexao);

    return array_slice($ids_exerc_exerc, 0, $qtd_exercicios);
}

function print_treino($ids_exerc, $treino)
{

    include "mysqlconecta.php";

    foreach ($ids_exerc as $id) {

        $nome_exerc = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome_exerc FROM exercicios WHERE id_exerc = $id"))[0];

        echo "<tr><td class='row'>$nome_exerc<br><p>" . pegaFoco($_SESSION['foco']) . " </p></td></tr>";
        echo "<input type='hidden' value='$id' name='ids_exerc' id='ids_exerc'>";

    }

    mysqli_close($conexao);

}
function treino()
{

    $peito_ids_exerc = pegaExercicios("peito", 4);
    $biceps_ids_exerc = pegaExercicios("biceps", 4);
    $triceps_ids_exerc = pegaExercicios("triceps", 4);
    $costa_ids_exerc = pegaExercicios("costas", 4);
    $posterior_ids_exerc = pegaExercicios("posterior", 6);
    $quadriceps_ids_exerc = pegaExercicios("quadriceps", 6);
    $panturrilha_ids_exerc = pegaExercicios("panturilha", 2);
    $ombros_ids_exerc = pegaExercicios("ombros", 3);


    $peitoFull = array_slice($peito_ids_exerc, 0, 2);
    $bicepsFull = array_slice($biceps_ids_exerc, 0, 2);
    $tricepsFull = array_slice($biceps_ids_exerc, 0, 2);
    $costaFull = array_slice($costa_ids_exerc, 0, 2);
    $quadricepsMenor = array_slice($quadriceps_ids_exerc, 0, 3);
    $posteriorMenor = array_slice($posterior_ids_exerc, 0, 3);

    $porSemana = $_SESSION['porSemana'];
    $areaDeFoco = $_SESSION['focoCorpo'];

    if ($porSemana == 1) { //Full body

        $quadricepsMenor = array_slice($quadriceps_ids_exerc, 0, 1);
        $posteriorMenor = array_slice($posterior_ids_exerc, 0, 1);

        $exercicios = array_merge($peitoFull, $bicepsFull, $tricepsFull, $costaFull, $quadricepsMenor, $posteriorMenor);

        print_treino($exercicios, "Treino FullBody");

    } else if ($porSemana == 2) { //Superior e Inferior

        $quadricepsMenor = array_slice($quadriceps_ids_exerc, 0, 3);
        $posteriorMenor = array_slice($posterior_ids_exerc, 0, 3);
        $ombros = array_slice($ombros_ids_exerc, 0, 2);
        $panturrilha = array_slice($panturrilha_ids_exerc, 0, 2);

        $exerciciosSup = array_merge($peitoFull, $bicepsFull, $tricepsFull, $costaFull);
        $exerciciosInf = array_merge($panturrilha, $ombros, $posteriorMenor, $quadricepsMenor);

        print_treino($exerciciosSup, "treino SUP");
        print_treino($exerciciosInf, "treino INFE");

    }
    if ($porSemana > 2 && $areaDeFoco == 1) { // Mais de duas vezes por semana e Foco no Superior

        if ($porSemana == 3) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, $tricepsFull);
            $treinoB = array_merge($costa_ids_exerc, $bicepsFull);
            $treinoC = array_merge($posteriorMenor, $quadricepsMenor);

            echo "<div id='Segunda' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Segunda</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";
            echo "<table>";
            print_treino($treinoA, "treinoA:");
            echo "</table>";
            echo "</div>";
            echo "</div>";

            echo "<div id='Terca' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Terça</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";
            echo 'Descanso';
            echo "</div>";
            echo "</div>";

            echo "<div id='Quarta' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Quarta</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";
            echo "<table>";
            echo print_treino($treinoB, "treinoB:");
            echo "</table>";
            echo "</div>";
            echo "</div>";

            echo "<div id='Quinta' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Quinta</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";

            echo 'Descanso';

            echo "</div>";

            echo "</div>";
            echo "<div id='Sexta' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Sexta</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";
            echo "<table>";
            echo print_treino($treinoC, "treinoC:");
            echo "</table>";
            echo "</div>";

            echo "</div>";
            echo "<div id='Sabado' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Sabádo</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";

            echo 'Descanso';

            echo "</div>";
            echo "</div>";

            echo "<div id='Domingo' class='treino'>";
            echo "<div class='treinoTop'>";
            echo "<div class='titleWeek'>Domingo</div>";
            echo "</div>";
            echo "<div class='treinoBottom'>";

            echo 'Descanso';

            echo "</div>";
            echo "</div>";
 
        } else if ($porSemana == 4) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, $tricepsFull);
            $treinoB = array_merge($costa_ids_exerc, $bicepsFull);
            $treinoC = array_merge($posteriorMenor, $quadricepsMenor);
            $treinoD = array_merge($peito_ids_exerc, $costa_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            echo "<div id='treinoE' class='treino'></div>";
            echo "<div id='treinoF' class='treino'></div>";

        } else if ($porSemana == 5) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, $tricepsFull);
            $treinoB = array_merge($costa_ids_exerc, $bicepsFull);
            $treinoC = array_merge($posteriorMenor, $quadricepsMenor);
            $treinoD = array_merge($peito_ids_exerc, $costa_ids_exerc);
            $treinoE = array_merge($biceps_ids_exerc, $triceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");
            echo "<div id='treinoF' class='treino'></div>";

        } else if ($porSemana == 6) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, $tricepsFull);
            $treinoB = array_merge($costa_ids_exerc, $bicepsFull);
            $treinoC = array_merge($posteriorMenor, $quadricepsMenor);
            $treinoD = array_merge($peito_ids_exerc, $costa_ids_exerc);
            $treinoE = array_merge($biceps_ids_exerc, $triceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");
            echo "<div id='treinoF' class='treino'> cardio 60 minutos</div>";

        }


    } else if ($porSemana > 2 && $areaDeFoco == 2) { // Mais de duas vezes por semana e Foco no Inferior

        $ombros = array_slice($ombros_ids_exerc, 0, 2);

        $pernaFull = array_merge($posteriorMenor, $quadricepsMenor, $ombros);

        if ($porSemana == 3) {

            $treinoA = array_merge($peito_ids_exerc, $costa_ids_exerc);
            $treinoB = array_merge($posterior_ids_exerc);
            $treinoC = array_merge($quadriceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            echo "<div id='treinoD' class='treino'></div>";
            echo "<div id='treinoE' class='treino'></div>";
            echo "<div id='treinoF' class='treino'></div>";

            //feito1
        } else if ($porSemana == 4) {

            $treinoA = array_merge($peito_ids_exerc, $costaFull);
            $treinoB = array_merge($posterior_ids_exerc, $panturrilha_ids_exerc);
            $treinoC = array_merge($quadriceps_ids_exerc, $panturrilha_ids_exerc);
            $treinoD = array_merge($triceps_ids_exerc, $biceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            echo "<div id='treinoE' class='treino'>a</div>";
            echo "<div id='treinoF' class='treino'>b</div>";

        } else if ($porSemana == 5) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, $tricepsFull);
            $treinoB = array_merge($costa_ids_exerc, $bicepsFull);
            $treinoC = array_merge($posterior_ids_exerc, $panturrilha_ids_exerc);
            $treinoD = array_merge($quadriceps_ids_exerc, $panturrilha_ids_exerc);
            $treinoE = array_merge($pernaFull);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");
            echo "<div id='treinoF' class='treino'></div>";

        } else if ($porSemana == 6) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, $tricepsFull);
            $treinoB = array_merge($costa_ids_exerc, $bicepsFull);
            $treinoC = array_merge($posterior_ids_exerc, $panturrilha_ids_exerc);
            $treinoD = array_merge($quadriceps_ids_exerc, $panturrilha_ids_exerc);
            $treinoE = array_merge($pernaFull);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");
            echo "<div id='treinoF' class='treino'>Cardio 60 minutos</div>";

        }

    }

}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleGerador.css">
    <script src="teste.js"></script>
    
    <title>Document</title>
</head>

<body>
    <nav class="nav-bar">
        <div class="nav-bar-left">
            <a href="index.php">
                <figure>
                    <img src="Images/strength.png" style="width:5em;left:1.5em;position:relative;" alt="image">
                </figure>
            </a>
        </div>
        <div class="nav-bar-right">
            <img src="Images/logout.png" style="width:3em;right:1.5em;position:relative;">
        </div>
    </nav>
    <?php

        echo "<input type='hidden' id='treino' name='treino' value=''>";
    ?>

    <div class="areaTreino-center">
        <div class="areaTreino">
            <?php

                echo treino();

            ?>
        </div>
        <div class="areaBotoes">

        <form action="gerador.php" method="POST">
            
            <button id="salvarTreino" type="submit" class="butao" name="salvar">Salvar Treino</button>
        
        </form>
        
            <a href="gerador.php"><input type="submit" value="Gerar Treino Novo" class="butao"></a>
        </div>
    </div>
    
    <footer>

   

    </footer>
    
</body>

</html>

<?php

?>