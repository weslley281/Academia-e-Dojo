<footer class="container-fluid bg-dark">
    <p class="m-0 text-center text-white mt-2 mb-2">Copyright &copy; Weslley Henrique Vieira Ferraz <?php echo date("Y"); ?></p>
    <p class="m-0 text-white">© Instituto de Artes Marciais e Defesa Pessoal Kenshydokan <?php echo date("Y"); ?>. Todos os direitos reservados.</p>
    <p class="m-0"><button onclick="moveTo('policies')" type="button" class="btn btn-outline-light">Políticas e Privacidade</button> | <button onclick="moveTo('terms')" type="button" class="btn btn-outline-light">Termos e Condições</button></p>
    <hr class="bg-light">
    <p class="m-0 text-white">Desenvolvido por Weslley Henrique Vieira Ferraz<br>
        Tenha um site ou app incrivel como esse faça um orçamento sem compromisso <a href="https://engenheirosoftwareweslley.com.br" target="_blank">clicando aqui</a></p>
</footer>
<script src="./libs/bootstrap/jquery.js"></script>
<script src="./libs/bootstrap/popper.js"></script>
<script src="./libs/bootstrap/bootstrap.js"></script>
<script src="./utils/maskCPF.js"></script>
<script src="./libs/DataTables/datatables.js"></script>
<script src="./libs/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#minhaTabela').DataTable({
            "order": [
                [0, "asc"]
            ], // Ordena a primeira coluna em ordem crescente
            "pageLength": 10, // Define o número de registros por página
            "searching": true // Habilita a pesquisa
        });
    });
</script>

<script>
    function formatarNumero(input) {
        if (input.id === "value") {
            // Remove caracteres que não são números, pontos ou a primeira ocorrência de ponto após a primeira posição
            input.value = input.value.replace(/[^\d.]/g, '').replace(/^(\d*\.)(.*)\./g, '$1$2');
        }
    }
</script>


<script>
    tinymce.init({
        selector: 'textarea#description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        language: 'pt_BR',
    });
</script>

<script>
    function moveTo(page) {
        window.location.href = `./${page}.php`;
    }
</script>