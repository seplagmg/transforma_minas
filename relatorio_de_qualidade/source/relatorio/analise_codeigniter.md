
As views de modo geral possuem pouco código php, o que explica o valor 100 para arquitetura e
complexidade. O maior problema desses arquivos é a estrutura do html que é gerada do lado do
servidor. A implementação abusa do uso da função `echo`, utilizando-a inclusive em diversos pontos
desnecessários. Um exemplo retirado do arquivo `application/views/home.php`:


```
echo "
            <section class=\"login-block\">
                <!-- Container-fluid starts -->
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-sm-12 d-flex justify-content-center\">
                            <!-- Authentication card start -->";
$attributes = array('class' => 'md-float-material form-material');
echo form_open($url, $attributes);
echo "
                                    <div class=\"text-center\">
                                        <img src=\"".base_url('images/logo.png')."\" alt=\"".$this -> config -> item('nome')."\" />
                                    </div>
                                    <!--<div class=\"row\" style=\"margin-top: 10px\">";
/*if($menu2 == 'index'){
        echo "
                                        <div class=\"alert background-danger\" style=\"width:90%;margin:0 auto;\">
                                               Prezado(a) candidato(a) dos editais de <strong>Processo Seletivo Simplificado Pró-Brumadinho</strong>, estes processos foram migrados para o sistema Processos Seletivos MG: <a href=\"http://www.processoseletivo.mg.gov.br/\"><strong>http://www.processoseletivo.mg.gov.br/</strong></a>
                                        </div>
                                        ";
}*/
echo "
                                    </div>-->
                                    <div class=\"card col-lg-8 mt-3 p-3 mx-auto\">
                                        <div class=\"card-block\">
                                            <div class=\"row m-b-20\">
                                                <div class=\"col-md-12\">
                                                    <h3 class=\"h3 text-gray-800 mb-4 text-center\">{$nome_pagina}</h3>
                                                </div>
                                            </div>";
```

A função `echo` serve para incluir no html variaveis que são definidas em outras partes do código
(como nas controllers). Mas note que boa parte do código acima não precisaria ser gerado via `echo`,
poderia ser apenas um html simples, utilizando a função php apenas quando necessário. O uso
indiscrimnado da função `echo` dificulta a manutenibilidade e o estilo do frontend da aplicação.
