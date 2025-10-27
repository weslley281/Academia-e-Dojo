<?php
// gerar_manual.php

// Inclui o autoloader do dompdf
require_once 'libs/dompdf/autoload.inc.php';

// Usa o namespace do Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

echo "Iniciando a geração do PDF...<br>";

try {
    // Pega o conteúdo do manual em HTML
    $html = file_get_contents('manual_content.html');

    if ($html === false) {
        throw new Exception("Não foi possível ler o arquivo manual_content.html");
    }

    // Configura as opções do Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    // Define uma fonte padrão que suporte caracteres UTF-8
    $options->set('defaultFont', 'DejaVu Sans');

    // Instancia o Dompdf com as opções
    $dompdf = new Dompdf($options);

    // Carrega o HTML
    $dompdf->loadHtml($html);

    // Define o tamanho e a orientação do papel
    $dompdf->setPaper('A4', 'portrait');

    // Renderiza o HTML para PDF
    $dompdf->render();

    // Salva o arquivo PDF no servidor
    $output = $dompdf->output();
    file_put_contents('manual_do_usuario.pdf', $output);

    echo "Manual do usuário gerado com sucesso!<br>";
    echo "<a href='manual_do_usuario.pdf' target='_blank'>Clique aqui para ver o PDF</a><br><br>";
    echo "Depois de salvar o PDF, você pode apagar os arquivos 'gerar_manual.php' e 'manual_content.html'.";

} catch (Exception $e) {
    echo "Ocorreu um erro ao gerar o PDF: " . $e->getMessage();
}
?>