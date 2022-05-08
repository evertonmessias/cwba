<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>LOG</title>
    <style>
        table.access {
            width: 25%;
            border-spacing: 0;
        }
        table.access th{
            background-color: #ccc;
        }
        table.access th,
        table.access td {
            border: 1px solid #555;
            padding: 3px;
        }
    </style>
</head>

<body>
    <table class="access">
        <tr>
            <th>id</th>
            <th>IP</th>
            <th>Data</th>
        </tr>
        <?php
        try {
            $lista = list_access('*');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        foreach ($lista as $item) {
            echo "<tr><td>" . $item->id . "</td><td>" . $item->ipadress . "</td><td>" . $item->time . "</td></tr>";
        }
        ?>
    </table>
    <br><br>
</body>

</html>