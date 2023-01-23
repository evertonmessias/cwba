<div class="about-cwba">
    <h2 class="title">Registro de Acessos</h2>
    <table id="access" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>IP</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $lista = list_access('access');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            foreach ($lista as $item) {
                $data = explode("-", explode(" ", $item->time)[0]);
                $datahora = $data[2] . "/" . $data[1] . "/" . $data[0] . " , " . explode(" ", $item->time)[1];
                echo "<tr><td>" . $item->id . "</td><td>" . $item->ipadress . "</td><td>" . $datahora . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>