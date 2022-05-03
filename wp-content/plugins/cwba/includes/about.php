<div class="about-cwba">
    <h1 class="title">Sobre</h1>
    <p><b>CWBA</b> é um Sistema de Gerenciamento de Cursos Wordpress.</p>    
    <ul>
        <li><a href="https://github.com/evertonmessias/cwba" target="_blank">Project Link</a></li>
        <li><a href="https://ic.unicamp.br/~everton" target="_blank">Developer Website</a></li>
    </ul>
    <hr>
    <h3>Acessos:</h3>
<table class="access">
<tr><th>id</th><th>IP</th><th>Data</th></tr>
    <?php
    try {
    $lista = list_access('*');    
} catch (Exception $e) {
    echo $e->getMessage();
}
foreach($lista as $item){
    echo "<tr><td>".$item->id."</td><td>".$item->ipadress."</td><td>".$item->time."</td></tr>";
}
?>
</table>
</div>