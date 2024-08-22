<?php

include "mysqlconecta.php";

$repetições = "0x0";

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

echo pegafoco($_POST["foco"]);

function pegaExercicios($area, $qtd_exercicios){
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

function print_treino($ids_exerc, $treino){

    include "mysqlconecta.php";

    foreach ($ids_exerc as $id) {

        $nome_exerc = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome_exerc FROM exercicios WHERE id_exerc = $id"))[0];

        echo "<tr><td>$treino</td><td>$nome_exerc </td><td>".pegaFoco($_POST['foco'])."</td></tr>";

    }

    mysqli_close($conexao);

}

function treino()
{

    $peito_ids_exerc = pegaExercicios  ("peito"  ,4);
    $biceps_ids_exerc = pegaExercicios ("biceps" ,4);
    $triceps_ids_exerc =pegaExercicios ("triceps",4);
    $costa_ids_exerc = pegaExercicios  ("costas" ,4);
    $perna_ids_exerc = pegaExercicios  ("pernas" ,6);

    $peitoFull = array_slice($peito_ids_exerc, 0, 2);
    $bicepsFull = array_slice($biceps_ids_exerc, 0, 2);
    $tricepsFull = array_slice($biceps_ids_exerc, 0, 2);
    $costaFull = array_slice($costa_ids_exerc, 0, 2);

    $porSemana = $_POST['porSemana'];
    $areaDeFoco = $_POST['focoCorpo'];

    if ($porSemana == 1) { //Full body

        $pernaFull = array_slice($perna_ids_exerc, 0, 2);

        $exercicios = array_merge($peitoFull, $bicepsFull, $tricepsFull,$costaFull, $pernaFull);

        print_treino($exercicios, "Treino FullBody");

    } else if ($porSemana == 2) { //Superior e Inferior

        $exercicios = array_merge($peitoFull, $bicepsFull, $tricepsFull ,$costaFull);

        print_treino($perna_ids_exerc, "treino SUP");
        print_treino($exercicios, "treino INFE");

    }
    if($porSemana > 2 && $areaDeFoco == 1){ // Mais de duas vezes por semana e Foco no Superior

        if($porSemana == 3){

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc,$tricepsFull);
            $treinoB = array_merge($costa_ids_exerc,$bicepsFull);
            $treinoC = array_merge($perna_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");

        }else if($porSemana == 4){

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc,$tricepsFull);
            $treinoB = array_merge($costa_ids_exerc,$bicepsFull);
            $treinoC = array_merge($perna_ids_exerc);
            $treinoD = array_merge($peito_ids_exerc,$costa_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");

        }else if($porSemana == 5){

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc,$tricepsFull);
            $treinoB = array_merge($costa_ids_exerc,$bicepsFull);
            $treinoC = array_merge($perna_ids_exerc);
            $treinoD = array_merge($peito_ids_exerc,$costa_ids_exerc);
            $treinoE = array_merge($biceps_ids_exerc,$triceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");

        }else if($porSemana == 6){

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc,$tricepsFull);
            $treinoB = array_merge($costa_ids_exerc,$bicepsFull);
            $treinoC = array_merge($perna_ids_exerc);
            $treinoD = array_merge($peito_ids_exerc,$costa_ids_exerc);
            $treinoE = array_merge($biceps_ids_exerc,$triceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");
            echo "Cardio: 60 minutos";

        }
        

    }else if($porSemana > 2 && $areaDeFoco == 2){ // Mais de duas vezes por semana e Foco no Inferior

        $posterior_ids_exerc   = pegaExercicios("posterior", 6);
        $quadriceps_ids_exerc  = pegaExercicios("quadriceps", 6);
        $panturrilha_ids_exerc = pegaExercicios("panturilha", 2);
        $ombros_ids_exerc = pegaExercicios("ombros", 3);

        $posteriorMenor = array_slice($posterior_ids_exerc,0,3);
        $quadricepsMenor = array_slice($quadriceps_ids_exerc,0,3);
        $ombros = array_slice($ombros_ids_exerc,0,2);

        $pernaFull = array_merge($posteriorMenor, $quadricepsMenor, $ombros);
        
        if($porSemana == 3){

            $treinoA = array_merge($peito_ids_exerc,$costa_ids_exerc);
            $treinoB = array_merge($posterior_ids_exerc);
            $treinoC = array_merge($quadriceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");

            //feito1
        }else if($porSemana == 4){

            $treinoA = array_merge($peito_ids_exerc,$costaFull);
            $treinoB = array_merge($posterior_ids_exerc,$panturrilha_ids_exerc);
            $treinoC = array_merge($quadriceps_ids_exerc,$panturrilha_ids_exerc);
            $treinoD = array_merge($triceps_ids_exerc,$biceps_ids_exerc);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");

        }else if($porSemana == 5){

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc,$tricepsFull);
            $treinoB = array_merge($costa_ids_exerc,$bicepsFull);
            $treinoC = array_merge($posterior_ids_exerc,$panturrilha_ids_exerc);
            $treinoD = array_merge($quadriceps_ids_exerc,$panturrilha_ids_exerc);
            $treinoE = array_merge($pernaFull);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");

        }else if($porSemana == 6){

            $bicepsFull = array_slice($biceps_ids_exerc, 0, 3);
            $tricepsFull = array_slice($triceps_ids_exerc, 0, 3);

            $treinoA = array_merge($peito_ids_exerc,$tricepsFull);
            $treinoB = array_merge($costa_ids_exerc,$bicepsFull);
            $treinoC = array_merge($posterior_ids_exerc,$panturrilha_ids_exerc);
            $treinoD = array_merge($quadriceps_ids_exerc,$panturrilha_ids_exerc);
            $treinoE = array_merge($pernaFull);

            print_treino($treinoA, "treinoA:");
            print_treino($treinoB, "treinoB:");
            print_treino($treinoC, "treinoC:");
            print_treino($treinoD, "treinoD:");
            print_treino($treinoE, "treinoE:");
            echo "Cardio: 60 minutos";

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
    <title>Document</title>
</head>

<body>
    <h1>Area fullbody:</h1>
    
    <table> <tr><th>treino</th><th> exercicio</th><th>repetições</th></tr>
        <?php

            echo treino();

        ?>
    </table>
</body>

</html>