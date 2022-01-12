<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Title</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
</head>
<Style>
    body {
        background-color: lightblue;
    }
    h2 {
        color: red;
    }
    .jumbotron{
        text-align: center;
        background-color: rgba(255, 196, 0, 0.699);
    }
    
</style>
<body>
<div class="jumbotron">
    <font size="+3">Tư vấn chăm sóc sức khỏe người cao tuổi</font><br />
  
</div>
<div class="contaier">
    <div id="question">
    </div>
    <div id="answer">
    </div>
    <div id="showResult">
        <span></span>
    </div>
    <div id="showb">
        <span></span>
    </div>
    <button class="btnSubmit">Submit</button>
</div>
</body>
<?php
// Connection
$mysqli = new mysqli("localhost:3306", "root", "Hongduyen243", "btl_htdttt");
// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
} else {
    function getDataQuestion($question, $mysqli)
    {
        $result = $mysqli->query("select * from tblquestion where question_code = '$question'");

        return $result->fetch_array(MYSQLI_ASSOC);
    }

    function getDataAnswer($answer, $mysqli)
    {
        $result = $mysqli->query("select * from tblanswer where answer_code = '$answer'");

        return $result->fetch_array(MYSQLI_ASSOC);
    }

    function getDataExpression($expression, $mysqli)
    {
        $result = $mysqli->query("select * from tblexpression where code like '$expression%'");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    $que             = ['TTCT', 'TT', 'VT', 'MT', 'BN', 'DT', 'BH'];
    $rowDataQuestion = [];
    foreach ($que as $q) {
        $rowDataQuestion[$q] = getDataQuestion($q, $mysqli);
    }

    function showResult($answer, $mysqli)
    {
        $order   = array("\r\n", "\n", "\r");
        $replace = '<br>';

        $result = $mysqli->query("select * from tblcare where code = '$answer'");

        $data = $result->fetch_array(MYSQLI_ASSOC);
        echo "<label class='$answer'>";
        echo str_replace($order, $replace, $data['value']);
        echo "</label>";
    }

    function showb($answer, $mysqli)
    {
        $order   = array("\r\n", "\n", "\r");
        $replace = '<br>';

        $result = $mysqli->query("select * from tblb where code = '$answer'");

        $data = $result->fetch_array(MYSQLI_ASSOC);
        echo "<label class='$answer'>";
        echo str_replace($order, $replace, $data['value']);
        echo "</label>";
    }

    $ans           = [
        'TTCT0',
        'TTCT1',
        'TTCT2',
        'TT1',
        'TT2',
        'TT3',
        'TT4',
        'TT5',
        'TT6',
        'VT1',
        'VT2',
        'VT3',
        'VT4',
        'VT5',
        'VT6',
        'MT0',
        'MT1',
        'MT2',
        'MT3',
        'MT4',
        'BN0',
        'BN1',
        'BN2',
        'BN3',
        'BN4',
        'BN5',
        'BN6',
        'DT0',
        'DT1',
        'DT2',
        'DT3'
    ];
    $rowDataAnswer = [];
    foreach ($ans as $a) {
        $rowDataAnswer[$a] = getDataAnswer($a, $mysqli);
    }

foreach ($que

    as $q) {
    ?>
    <script>
        $('#question').append("<?php
            echo "<div class='questionOf$q d-none'> ";
            echo "<h2><span class='textQuestion'> ";
            echo  $rowDataQuestion[$q]['question'] ;
            echo "</span></h2>";
            echo "</div>";
            ?>")
        $('#answer').append("<?php
            if ($q != 'BH') {
                echo "<div class='answerOf$q d-none'> ";
                foreach ($ans as $a) {
                    $str = substr($a, 0, -1);
                    if ($str == $q) {
                        echo "<label class='label-answer'>";
                        echo $rowDataAnswer[$a]['answer'];
                        if ($q == 'BN' || $q == 'TT') {
                            echo "  <input type='checkbox' name='checkbox$q'/>";
                        } else {
                            echo "  <input type='radio' name='radio$q'/>";
                        }
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                        echo "<br>";
                    }
                }
                echo "</div>";
            }
            ?>")
    </script>
<?php
}

$expressionCode = ['TK', 'TM', 'HH', 'TH', 'TN', 'XK'];

foreach ($expressionCode

as $e) {
?>
    <script>
        $('#answer').append("<?php
            $order = array("\r\n", "\n", "\r");
            $replace = '<br>';
            echo "<div class='answerOfBH_$e d-none'>";

            $rowDataExpression = getDataExpression($e, $mysqli);
            for ($i = 0; $i < count($rowDataExpression); $i++) {
                echo "<label class='label-answer'>";
                echo str_replace($order, $replace, $rowDataExpression[$i]['value']);
                echo "  <input type='radio' name='radioBH_$e'/>";
                echo "  <span class='checkmark'></span>";
                echo "</label>";
                echo "<br>";
            }
            echo "</div>";
            ?>")
    </script>
    <?php
}
}
?>
<script>
    let question = ['TTCT', 'TT', 'VT', 'MT', 'BN', 'DT'];
    let answer = [
        [0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0]
    ];
    let code;
    $(document).ready(function () {
        function atLeastOneIsChecked(question) {
            var check = -1;
            var tmp = 0;
            $('.answerOf' + question + ' label input[type=radio]').each(function () {
                tmp++;
                if ($(this).is(":checked")) {
                    check = tmp;
                }
            });
            return check;
        }

        function atLeastMoreIsChecked(question) {
            var check = [];
            var tmp = 0;
            $('.answerOf' + question + ' label input[type=checkbox]').each(function () {
                tmp++;
                if ($(this).is(":checked")) {
                    check.push(tmp);
                }
            });
            return check;
        }

        function initShowQuestion() {
            $('.questionOfTTCT').removeClass('d-none');
            $('.answerOfTTCT').removeClass('d-none');
        }
        
        function btnSubmit() {
            if (!$('.questionOfTTCT').hasClass('d-none')) {
                $('.questionOfTTCT').addClass('d-none');
                $('.answerOfTTCT').addClass('d-none');
                var ans = atLeastOneIsChecked('TTCT');

                if (ans === 1) {
                    $('#showResult span').append("<?php
                        $order = array("\r\n", "\n", "\r");
                        $replace = '<br>';

                        $result = $mysqli->query("select * from tbladvise where code = 'TV'");

                        $data = $result->fetch_array(MYSQLI_ASSOC);
                        echo "<h2>Cách chăm sóc sức khỏe hàng ngày: </h2>";
                        echo "<label>";
                        echo str_replace($order, $replace, $data['value']);
                        echo "</label>";
                        ?>");
                } else if (ans === 3) {
                    $('.questionOfTT').removeClass('d-none');
                    $('.answerOfTT').removeClass('d-none');
                } else {
                    $('.questionOfVT').removeClass('d-none');
                    $('.answerOfVT').removeClass('d-none');
                }
            } else if (!$('.questionOfTT').hasClass('d-none')) {
                $('#showResult span').append("<?php 
                    echo "<h2>Cách chăm sóc sức khỏe : </h2>";
                    $ans = ['TV1', 'TV2', 'TV3', 'TV4', 'TV5', 'TV6'];
                    $order = array("\r\n", "\n", "\r");
                    $replace = '<br>';

                    foreach ($ans as $a) {
                        $result = $mysqli->query("select * from tbladvise where code = '$a'");

                        $data = $result->fetch_array(MYSQLI_ASSOC);
                        echo "<label class='$a d-none'>";
                        echo str_replace($order, $replace, $data['value']);
                        echo "</label>";
                    }
                    ?>");
                $('.questionOfTT').addClass('d-none');
                $('.answerOfTT').addClass('d-none');

                var ans = atLeastMoreIsChecked('TT');
                for (var i = 0; i < ans.length; i++) {
                    $('#showResult span label.TV' + ans[i]).removeClass('d-none');
                }

            } else if (!$('.questionOfVT').hasClass('d-none')) {
                $('.questionOfVT').addClass('d-none');
                $('.answerOfVT').addClass('d-none');
                answer[0][atLeastOneIsChecked('VT') - 1] = 1;
                $('.questionOfMT').removeClass('d-none');
                $('.answerOfMT').removeClass('d-none');
            } else if (!$('.questionOfMT').hasClass('d-none')) {
                $('.questionOfMT').addClass('d-none');
                $('.answerOfMT').addClass('d-none');
                answer[1][atLeastOneIsChecked('MT') - 1] = 1;
                $('.questionOfBN').removeClass('d-none');
                $('.answerOfBN').removeClass('d-none');
            } else if (!$('.questionOfBN').hasClass('d-none')) {
                $('.questionOfBN').addClass('d-none');
                $('.answerOfBN').addClass('d-none');
                var ans = atLeastMoreIsChecked('BN');
                for (var i = 0; i < ans.length; i++) {
                    answer[2][ans[i] - 1] = 1;
                }
                $('.questionOfDT').removeClass('d-none');
                $('.answerOfDT').removeClass('d-none');
            } else if (!$('.questionOfDT').hasClass('d-none')) {
                $('.questionOfDT').addClass('d-none');
                $('.answerOfDT').addClass('d-none');
                answer[3][atLeastOneIsChecked('DT') - 1] = 1;
                $('.questionOfBH').removeClass('d-none');

                if (answer[0][0] === 1) {
                    $('.answerOfBH_TK').removeClass('d-none');
                    code = "TK";
                } else if (answer[0][1] === 1) {
                    $('.answerOfBH_TM').removeClass('d-none');
                    code = "TM";
                } else if (answer[0][2] === 1) {
                    $('.answerOfBH_HH').removeClass('d-none');
                    code = "HH";
                } else if (answer[0][3] === 1) {
                    $('.answerOfBH_TH').removeClass('d-none');
                    code = "TH";
                } else if (answer[0][4] === 1) {
                    $('.answerOfBH_TN').removeClass('d-none');
                    code = "TN";
                } else if (answer[0][5] === 1) {
                    $('.answerOfBH_XK').removeClass('d-none');
                    code = "XK";
                }
            } else if (!$('.questionOfBH').hasClass('d-none')) {
                $('.questionOfBH').addClass('d-none');
                $('.answerOfBH_' + code).addClass('d-none');
                answer[4][atLeastOneIsChecked('BH_' + code) - 1] = 1;
                if (code == 'TK') {
                    if (answer[4][0] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b1', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS1', $mysqli); ?>")
                    } else if (answer[4][1] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b2', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS2', $mysqli); ?>")
                    } else if (answer[4][2] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b3', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS3', $mysqli); ?>")
                    } else if (answer[4][3] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b4', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS4', $mysqli); ?>")
                    } else {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b5', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS5', $mysqli); ?>")
                    }
                } else if (code == 'TM') {
                    if (answer[4][0] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b6', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS6', $mysqli); ?>")
                    } else if (answer[4][1] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b7', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS7', $mysqli); ?>")
                    } else if (answer[4][2] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b8', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS8', $mysqli); ?>")
                    } else {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b9', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS9', $mysqli); ?>")
                    }
                } else if (code == 'HH') {
                    if (answer[4][0] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b10', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "Cách chăm sóc sức khỏe : </h2>"; showResult('CS10', $mysqli); ?>")
                    } else if (answer[4][1] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b11', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS11', $mysqli); ?>")
                    } else if (answer[4][2] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b12', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "Cách chăm sóc sức khỏe : </h2>"; showResult('CS12', $mysqli); ?>")
                    } else if (answer[4][3] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b13', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS13', $mysqli); ?>")
                    } else if (answer[4][4] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b14', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS14', $mysqli); ?>")
                    } else {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b15', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS15', $mysqli); ?>")
                    }
                } else if (code == 'TH') {
                    if (answer[4][0] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b16', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS16', $mysqli); ?>")
                    } else if (answer[4][1] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b17', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS17', $mysqli); ?>")
                    } else if (answer[4][2] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b18', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS18', $mysqli); ?>")
                    } else if (answer[4][3] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b19', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS19', $mysqli); ?>")
                    } else {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b20', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS20', $mysqli); ?>")
                    }
                } else if (code == 'TN') {
                    if (answer[4][0] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b21', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS21', $mysqli); ?>")
                    } else if (answer[4][1] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b22', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS22', $mysqli); ?>")
                    } else if (answer[4][2] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b23', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS23', $mysqli); ?>")
                    } else if (answer[4][3] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b24', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS24', $mysqli); ?>")
                    } else if (answer[4][4] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b25', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS25', $mysqli); ?>")
                    } else if (answer[4][5] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b26', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS26', $mysqli); ?>")
                    } else {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b27', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS27', $mysqli); ?>")
                    }
                } else if (code == 'XK') {
                    if (answer[4][0] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b28', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS28', $mysqli); ?>")
                    } else if (answer[4][1] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b29', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS29', $mysqli); ?>")
                    } else if (answer[4][2] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b30', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS30', $mysqli); ?>")
                    } else if (answer[4][3] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b31', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS31', $mysqli); ?>")
                    } else if (answer[4][4] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b32', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS32', $mysqli); ?>")
                    } else if (answer[4][5] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b33', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS33', $mysqli); ?>")
                    } else if (answer[4][6] === 1) {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b34', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS34', $mysqli); ?>")
                    } else {
                        $('#showb span').append("<?php echo "<h2>Chẩn đoán bệnh : </h2>"; showB('b35', $mysqli); ?>")
                        $('#showResult span').append("<?php echo "<h2>Cách chăm sóc sức khỏe : </h2>"; showResult('CS35', $mysqli); ?>")
                    }
                }
            }
        }

        initShowQuestion();
        $('.btnSubmit').click(btnSubmit);
    });
</script>

</html>
