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
function retorna_idsTreino($ids_exerc, $treino)
{
    include "mysqlconecta.php";

    $array = array();

    while ($id = mysqli_fetch_array($query)) {
        array_push($array, array($id[0]));
    }

    mysqli_close($conexao);

    return json_encode($array);

}
function print_treino($ids_exerc, $treino, $dayWeek)
{

    include "mysqlconecta.php";

    $cont = 0;

    echo "<div id='$dayWeek' class='treino'>";
    echo "<div class='treinoTop'>";
    echo "<div class='titleWeek'>$dayWeek</div>";
    echo "</div>";
    echo "<div class='treinoBottom'>";

    if ($treino == 'treino') {

        echo "<table>";

        foreach($ids_exerc as $id) {

            $cont++;
            $nome_exerc = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome_exerc FROM exercicios WHERE id_exerc = $id"))[0];

            echo "<tr><td class='row'> $nome_exerc<br><p>" . pegaFoco($_SESSION['foco']) . " </p></td></tr>";

        }
    } else {

        echo "<tr>$treino</tr>";

    }

    echo "</table>";
    echo "</div>";
    echo "</div>";

    mysqli_close($conexao);
}
function pegaFull($arrayTreino, $tamanho){


    foreach ($arrayTreino as $id) {
        
        $tipoTreino = array_slice($arrayTreino,0, $tamanho);
 
    }

    return $tipoTreino;

}

function treino(){

    $peito_ids_exerc = pegaExercicios("peito", 4);
    $biceps_ids_exerc = pegaExercicios("biceps", 4);
    $triceps_ids_exerc = pegaExercicios("triceps", 4);
    $costa_ids_exerc = pegaExercicios("costas", 4);
    $posterior_ids_exerc = pegaExercicios("posterior", 6);
    $quadriceps_ids_exerc = pegaExercicios("quadriceps", 6);
    $panturrilha_ids_exerc = pegaExercicios("panturilha", 3);
    $ombros_ids_exerc = pegaExercicios("ombros", 3);

    $porSemana = $_SESSION['porSemana'];
    $areaDeFoco = $_SESSION['focoCorpo'];


    if ($porSemana == 1 && $areaDeFoco == 1) { //Full body
        
        $exercicios = array_merge(pegaFull($peito_ids_exerc,2),pegaFull($biceps_ids_exerc,1), pegaFull($triceps_ids_exerc, 1), pegaFull($costa_ids_exerc, 2));

        print_treino("", "Descanso", "Segunda");
        print_treino("", "Descanso", "Terça");
        print_treino($exercicios, "treino", "Quarta");
        print_treino("", "Descanso", "Quinta");
        print_treino("", "Descanso", "Sexta");
        print_treino("", "Descanso", "Sabado");
        print_treino("", "Descanso", "Domingo");

    }else if($porSemana == 1 && $areaDeFoco == 2){

        $exercicios = array_merge(pegaFull($peito_ids_exerc,1),pegaFull($costa_ids_exerc,1),pegaFull($posterior_ids_exerc, 2), pegaFull($quadriceps_ids_exerc,2));

        print_treino("", "Descanso", "Segunda");
        print_treino("", "Descanso", "Terça");
        print_treino($exercicios, "treino", "Quarta");
        print_treino("", "Descanso", "Quinta");
        print_treino("", "Descanso", "Sexta");
        print_treino("", "Descanso", "Sabado");
        print_treino("", "Descanso", "Domingo");

    } else if ($porSemana == 2 && $areaDeFoco == 1) { //Superior e Inferior

        $exerciciosSup = array_merge(pegaFull($peito_ids_exerc, 2),pegaFull($costa_ids_exerc, 2),pegaFull($biceps_ids_exerc, 1), pegaFull($triceps_ids_exerc,1));
        $exerciciosInf = array_merge(pegaFull($quadriceps_ids_exerc, 1),pegaFull($posterior_ids_exerc, 1), pegaFull($biceps_ids_exerc, 1), pegaFull($triceps_ids_exerc, 1),pegaFull($ombros_ids_exerc,2));

        print_treino("", "Descanso", "Segunda");
        print_treino($exerciciosSup, "treino", "Terça");
        print_treino("", "Descanso", "Quarta");
        print_treino($exerciciosInf, "treino", "Quinta");
        print_treino("", "Descanso", "Sexta");
        print_treino("", "Descanso", "Sabado");
        print_treino("", "Descanso", "Domingo");

    }else if($porSemana == 2 && $areaDeFoco == 2){

        $exerciciosSup = array_merge(pegaFull($peito_ids_exerc, 1),pegaFull($costa_ids_exerc, 1),pegaFull($biceps_ids_exerc, 1), pegaFull($triceps_ids_exerc,1) , pegaFull($quadriceps_ids_exerc, 1), pegaFull($posterior_ids_exerc, 1));
        $exerciciosInf = array_merge(pegaFull($quadriceps_ids_exerc, 2),pegaFull($posterior_ids_exerc, 2), pegaFull($ombros_ids_exerc,2));

        print_treino("", "Descanso", "Segunda");
        print_treino($exerciciosSup, "treino", "Terça");
        print_treino("", "Descanso", "Quarta");
        print_treino($exerciciosInf, "treino", "Quinta");
        print_treino("", "Descanso", "Sexta");
        print_treino("", "Descanso", "Sabado");
        print_treino("", "Descanso", "Domingo");

    }
    if ($porSemana > 2 && $areaDeFoco == 1) { // Mais de duas vezes por semana e Foco no Superior

        if ($porSemana == 3) {

            $treinoA = array_merge($peito_ids_exerc, pegaFull($triceps_ids_exerc, 3));
            $treinoB = array_merge($costa_ids_exerc, pegaFull($biceps_ids_exerc,3));
            $treinoC = array_merge(pegaFull($posterior_ids_exerc,3), pegaFull($quadriceps_ids_exerc,3));


            print_treino($treinoA, "treino", "Segunda");
            print_treino("", "Descanso", "Terça");
            print_treino($treinoB, "treino", "Quarta");
            print_treino("", "Descanso", "Quinta");
            print_treino($treinoC, "treino", "Sexta");
            print_treino("", "Descanso", "Sabado");
            print_treino("", "Descanso", "Domingo");

            
        } else if ($porSemana == 4) {

            $treinoA = array_merge($peito_ids_exerc,pegaFull($triceps_ids_exerc, 3));
            $treinoB = array_merge($costa_ids_exerc, pegaFull($biceps_ids_exerc,3));
            $treinoC = array_merge(pegaFull($posterior_ids_exerc,3), pegaFull($quadriceps_ids_exerc,3));
            $treinoD = array_merge($peito_ids_exerc, $costa_ids_exerc);


            print_treino($treinoA, "treino", "Segunda");
            print_treino($treinoB, "treino", "Terça");
            print_treino("", "Descanso", "Quarta");
            print_treino($treinoC, "treino", "Quinta");
            print_treino($treinoD, "treino", "Sexta");
            print_treino("", "Descanso", "Sabado");
            print_treino("", "Descanso", "Domingo");

        } else if ($porSemana == 5) {

            $treinoA = array_merge($peito_ids_exerc, pegaFull($triceps_ids_exerc, 3));
            $treinoB = array_merge($costa_ids_exerc, pegaFull($biceps_ids_exerc,3));
            $treinoC = array_merge(pegaFull($posterior_ids_exerc,3), pegaFull($quadriceps_ids_exerc,3));
            $treinoD = array_merge($peito_ids_exerc, $costa_ids_exerc);
            $treinoE = array_merge($biceps_ids_exerc, $triceps_ids_exerc);

            print_treino($treinoA, "treino", "Sabado");
            print_treino($treinoB, "treino", "Terça");
            print_treino($treinoC, "treino", "Quarta");
            print_treino($treinoD, "treino", "Quinta");
            print_treino($treinoE, "treino", "Sexta");
            print_treino("", "Descanso", "Sabado");
            print_treino("", "Descanso", "Domingo");

        } else if ($porSemana == 6) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, pegaFull($triceps_ids_exerc, 3));
            $treinoB = array_merge($costa_ids_exerc, pegaFull($biceps_ids_exerc,3));
            $treinoC = array_merge(pegaFull($posterior_ids_exerc,3), pegaFull($quadriceps_ids_exerc,3));
            $treinoD = array_merge($peito_ids_exerc, $costa_ids_exerc);
            $treinoE = array_merge($biceps_ids_exerc, $triceps_ids_exerc);

            print_treino($treinoA, "treino", "Segunda");
            print_treino($treinoB, "treino", "Terça");
            print_treino($treinoC, "treino", "Quarta");
            print_treino($treinoD, "treino", "Quinta");
            print_treino($treinoE, "treino", "Sexta");
            print_treino("", "30 minutos de cardio", "Sabado");
            print_treino("", "Descanso", "Domingo");

        }


    } else if ($porSemana > 2 && $areaDeFoco == 2) { // Mais de duas vezes por semana e Foco no Inferior

        $ombros = array_slice($ombros_ids_exerc, 0, 2);

        $pernaFull = array_merge(pegaFull($posterior_ids_exerc,3), pegaFull($quadriceps_ids_exerc,3), pegaFull($ombros_ids_exerc, 2));

        if ($porSemana == 3) {

            $treinoA = array_merge($peito_ids_exerc, $costa_ids_exerc);
            $treinoB = array_merge($posterior_ids_exerc);
            $treinoC = array_merge($quadriceps_ids_exerc);

            print_treino($treinoA, "treino", "Segunda");
            print_treino("", "Descanso", "Terça");
            print_treino($treinoB, "treino", "Quarta");
            print_treino("", "Descanso", "Quinta");
            print_treino($treinoC, "treino", "Sexta");
            print_treino("", "Descanso", "Sabado");
            print_treino("", "Descanso", "Domingo");
            

            //feito1
        } else if ($porSemana == 4) {

            $treinoA = array_merge($peito_ids_exerc, pegaFull($costa_ids_exerc, 3));
            $treinoB = array_merge($posterior_ids_exerc, $panturrilha_ids_exerc);
            $treinoC = array_merge($quadriceps_ids_exerc, $panturrilha_ids_exerc);
            $treinoD = array_merge($triceps_ids_exerc, $biceps_ids_exerc);

            print_treino($treinoA, "treino", "Segunda");
            print_treino($treinoB, "treino", "Terça");
            print_treino("", "Descanso", "Quarta");
            print_treino($treinoC, "treino", "Quinta");
            print_treino($treinoD, "treino", "Sexta");
            print_treino("", "Descanso", "Sabado");
            print_treino("", "Descanso", "Domingo");

        } else if ($porSemana == 5) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, pegaFull($biceps_ids_exerc, 3));
            $treinoB = array_merge($costa_ids_exerc, pegaFull($triceps_ids_exerc, 3));
            $treinoC = array_merge($posterior_ids_exerc, $panturrilha_ids_exerc);
            $treinoD = array_merge($quadriceps_ids_exerc, $panturrilha_ids_exerc);
            $treinoE = array_merge($pernaFull);

            print_treino($treinoA, "treino", "Segunda");
            print_treino($treinoB, "treino", "Terça");
            print_treino($treinoC, "treino", "Quarta");
            print_treino($treinoD, "treino", "Quinta");
            print_treino($treinoE, "treino", "Sexta");
            print_treino("", "Descanso", "Sabado");
            print_treino("", "Descanso", "Domingo");

        } else if ($porSemana == 6) {

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc, pegaFull($triceps_ids_exerc, 3));
            $treinoB = array_merge($costa_ids_exerc, pegaFull($biceps_ids_exerc, 3));
            $treinoC = array_merge($posterior_ids_exerc, $panturrilha_ids_exerc);
            $treinoD = array_merge($quadriceps_ids_exerc, $panturrilha_ids_exerc);
            $treinoE = array_merge($pernaFull);

            print_treino($treinoA, "treino", "Segunda");
            print_treino($treinoB, "treino", "Terça");
            print_treino($treinoC, "treino", "Quarta");
            print_treino($treinoD, "treino", "Quinta");
            print_treino($treinoE, "treino", "Sexta");
            print_treino("", "30 minutos de cardio", "Sabado");
            print_treino("", "Descanso", "Domingo");

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

                <button id="salvarTreino" type="button" class="butao" name="salvar"
                    onclick="SalvarTreino()">Salvar Treino</button>

            </form>

            <a href="gerador.php"><input type="submit" value="Gerar Treino Novo" class="butao"></a>
        </div>
    </div>

    <footer>



    </footer>

</body>

</html>