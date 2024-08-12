<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleIndex.css">
    <title>Academia</title>
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
    <div class="fundo-baixo">
        <form action="gerador.php" method="post">
        <div class="infos">
            <div class="title">
                Qual o seu foco?
            </div>
            <div class="inputs">
                <div class="radios-foco">
                    <div><input type="radio" value="1" name="foco" required> EMAGRECIMENTO</input></div>
                    <div><input type="radio" value="2" name="foco" required> GANHO DE MASSA</input></div>
                    <div><input type="radio" value="3" name="foco" required> SAÚDE</input></div>
                </div>
                <div class="title">
                    Quantas vezes por semana você treina?
                </div>
                <div class="radios-porSemana">
                    <div><input type="radio" value="1" name="porSemana" required> 1</input></div>
                    <div><input type="radio" value="2" name="porSemana" required> 2</input></div>
                    <div><input type="radio" value="3" name="porSemana" required> 3</input></div>
                    <div><input type="radio" value="4" name="porSemana" required> 4</input></div>
                    <div><input type="radio" value="5" name="porSemana" required> 5</input></div>
                    <div><input type="radio" value="6" name="porSemana" required> 6</input></div>
                    <div><input type="radio" value="7" name="porSemana" required> 7</input></div>
                </div>
                <div class="title">
                    Qual o parte do seu corpo quer desenvolver mais?
                </div>
                <div class="radios-focoDoCorpo">
                    <div><input type="radio" value="1" name="focoCorpo" required> SUPERIOR</input></div>
                    <div><input type="radio" value="2" name="focoCorpo" required> INFERIOR</input></div>
                </div>
                <div class="alinha">
                    <input type="submit" value="Gerar" name="geraTreino" class="botaoGera">
                </div>
            </div>
          
        </div>
        </form>
    </div>
</body>

</html>