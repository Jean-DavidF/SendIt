<html>
<head>
    <meta charset="UTF-8">

    <title>List</title>

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0">

    <!-- Style -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/list.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato|Philosopher:400,400i,700,700i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script type="text/javascript" src="js/sendmarks.js"></script> -->
    <script type="text/javascript" src="js/functions.js"></script>
</head>

<?php
    // Set parameters
    require 'parameters.php';

    $mapping = [
        'mmi_1' => 'MMI 1',
        'mmi_2' => 'MMI 2',
        'lp_creaweb' => 'LP Créaweb'
    ];
?>

<body>

<div class="undo">
    <a href="choice.php"><i class="fa fa-undo"></i></a>
</div>


<div class="wrapper">
    <div class="container">
        <div class="header">
            <h1>List</h1>
            <p>Liste des étudiants de <?= $mapping[$_POST['students']] ? $mapping[$_POST['students']] : $_POST['students']; ?></p>
        </div>
        <div class="content">
            <div class="table-content">
                <table align="center">
                    <thead><tr><th>ID</th><th>N° Étudiant</th><th>Email</th></thead>
                    <?php
                        foreach($etudiants as $etudiant){
                            echo '<tr><td>'.$etudiant['id'].'</td><td>'.$etudiant['numero'].'</td><td>'
                            .$etudiant['email'].'</td></tr>';
                        }   
                    ?>
            </div>
        </div>
    </div>
</div>

</body>