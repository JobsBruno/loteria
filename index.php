<!DOCTYPE html>
<html>
<head>
    <title>Loteria</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
       body{
        background-size: cover;
        background-image: center;
        background-repeat:  no-repeat;
       }
       
       .number-pad {
            display: inline-block;
            margin-right: 10px;
            cursor: pointer;
            padding: 17px 17px;
            font-size: 15px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 2px;
        }

        .number-pad.selected {
            background-color: #add8e6;
            color: #000080;
        }

        .selected-count {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".number-pad").click(function() {
                $(this).toggleClass("selected");
                var checkbox = $(this).next("input[type='checkbox']");
                checkbox.prop("checked", !checkbox.prop("checked"));
                updateSelectedCount();
            });

            function updateSelectedCount() {
                var count = $("input[name='numeros[]']:checked").length;
                $(".selected-count").text("Números selecionados: " + count);
            }
        });
    </script>
</head>
<body background="Loteria.jpg">
    <h2><center>Quem Cedo Madruga:</center></h2>
    <div id="selected-numbers" class="selected-count"><center>Números selecionados: 0</center></div>
    <form method="post">
        <center>
        <?php
        for ($i = 1; $i <= 50; $i++) {
            echo "<div class='number-pad'>" . $i . "</div>";
            echo "<input type='checkbox' name='numeros[]' value='$i' style='display: none;'>";
        }
        ?>
        </center>
        <br>
        <label>Valor da Aposta:</label>
        <input type="number" name="aposta" required>
        <br><br>
        <input type="submit" name="submit" value="Verificar Resultado">
    </form>
    
    
 
    <?php
    if (isset($_POST['submit'])) {
        $numerosEscolhidos = $_POST['numeros'];
        $aposta = $_POST['aposta'];
 
        if (count($numerosEscolhidos) != 25) {
            echo "<p>Por favor, escolha exatamente 25 números.</p>";
        } else {
            $numerosSorteados = range(1, 50);
            shuffle($numerosSorteados);
            $numerosSorteados = array_slice($numerosSorteados, 0, 25);
 
            $acertos = count(array_intersect($numerosEscolhidos, $numerosSorteados));
 
            echo "<p>Números Sorteados: " . implode(", ", $numerosSorteados) . "</p>";
            echo "<p>Números Escolhidos: " . implode(", ", $numerosEscolhidos) . "</p>";
            echo "<p>Acertos: $acertos</p>";
 
            $premio = 0;
            if ($acertos >0 && $acertos <21){
                $premio = 0;
            } elseif ($acertos <= 24 && $acertos >=21) {
                $premio = $acertos * $aposta;
            } elseif ($acertos = 0) {
                $premio = 50 * $aposta;
            } elseif($acertos = 25) {
                $premio = 50 * $aposta;
            }
 
            echo "<p>Prêmio: $premio</p>";
        }
    }
    ?>
</body>
</html>