<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this->load->view('templates/internaCabecalho', $pagina);

echo "
                        <div class=\"col-12\">
                            <div class=\"tsm-inner-content\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper\">
                                        <div class=\"page-body\">
                                            <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                    <div class=\"card\">
                                                        <div class=\"card-block\">
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}";
if($menu2 == 'questoes' || $menu2 == 'resultado' || $menu2 == 'resultado2' || $menu2 == 'resultado3'){
        echo ' - '.$vagas[0] -> vc_vaga;
}
echo "</h4>
                                                                    </div>";
if($menu2 == 'index' && $this -> session -> perfil != 'avaliador'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <a href=\"".base_url('Vagas/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Nova vaga </a>
                                                                    </div>";
}
if($menu2 != 'index' && strlen($sucesso) == 0 && ($menu2 == 'create' || $menu2 == 'edit')){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_vagas').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/index')."';\">Cancelar</button>
                                                                    </div>";
}
if($menu2 == 'resultado' && $vagas[0] -> bl_finalizado != '1'&&$this -> session -> perfil != 'avaliador'){
        $reprovado = false;
        $agendado = false;
        $finalizado = false;
        $aprovado = false;
        if(isset($candidaturas)){
                
                foreach ($candidaturas as $linha){
                        if($linha -> es_status == 8){
                               $reprovado = true; 
                        }
                        $validacao_reprovado = ($linha ->es_status == 10 || $linha ->es_status == 11 || $linha ->es_status == 12 || $linha ->es_status == 14 || $linha ->es_status == 16);
                        if($reprovado && $validacao_reprovado){
                                $agendado = true;
                                $finalizado = true;
                        }
                        else if($validacao_reprovado){
                                
                                $finalizado = true;
                        }

                        
                }
                foreach($candidaturas as $linha){
                        if($finalizado && $linha ->es_status == 19){
                                $aprovado = true;
                        }
                        if($aprovado){
                                break;
                        }
                }
        }

        echo "
                                                                    <div class=\"col-lg-4 text-right\">";
        /*if($agendado){
                echo "
                                                                                <button type=\"button\" class=\"btn btn-danger\" onclick=\"confirm_reprovacao(".$vagas[0] -> pr_vaga.");\"> Reprovar não agendados </button>";
        }*/
        if($aprovado){
                echo "
                                                                                <button type=\"button\" class=\"btn btn-danger\" onclick=\"confirm_reprovacao2(".$vagas[0] -> pr_vaga.");\"> Finalizar vaga </button>";
        }
        
        echo "
                                                                                <button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='".base_url('Vagas/recalcular_nota/'.$vagas[0] -> pr_vaga)."'\">Recalcular nota bruta</button>
										
                                                                                <button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='".base_url('Vagas/resultado2/'.$vagas[0] -> pr_vaga)."'\">Detalhamento por competência</button>
																			
                                                                    </div>";
}
if($menu2 == 'resultado2' || $menu2 == 'resultado3'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vagas[0] -> pr_vaga)."'\">Voltar</button>
                                                                    </div>";
}
echo "
                                                            </div>";
if($menu2 == 'index'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" ".($inativo == 1? "checked=\"checked\" ":"")." /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Instituição</th>
                                                                                            <th>Grupo</th>
                                                                                            <th>Status da vaga</th>
                                                                                            <th>Início inscrição</th>
                                                                                            <th>Fim inscrição</th>";
        /*
        echo "
                                                                                            <th>Questões</th>";
        */
        echo "
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($vagas)){
				$atual = time();
                foreach ($vagas as $linha){
                        $dt_inicio = strtotime($linha -> dt_inicio);
                        $dt_fim = strtotime($linha -> dt_fim);
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td class=\"text-center\">".$linha -> vc_sigla."</td>
                                                                                            <td>".$linha -> vc_grupovaga."</td>
                                                                                            <td>";
																							
						//echo ($linha -> bl_liberado == '1'?'Sim':'Não');
						if($linha -> bl_removido == '0'){
								if($linha -> bl_liberado != '1'){
										echo "Não liberada";
								}
								else if($linha -> bl_finalizado == '1'){
										echo "Processo concluído";
								}
								else{
										if($dt_fim > $atual){
												echo "Liberada para inscrição";
										}
										else{
												if(isset($aguardando_decisao[$linha -> pr_vaga])){
														echo "Aguardando decisão final";
												}
												else{
														echo "Candidaturas sobre análise";
												}
										}
								}
						}
						else{
								echo "Vaga removida";
						}
						echo "</td>    
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_inicio)."\" data-order=\"$dt_inicio\">".show_date($linha -> dt_inicio, true)."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_fim)."\" data-order=\"$dt_fim\">".show_date($linha -> dt_fim, true)."</td>";
                        /*
                        echo "
                                                                                            <td class=\"text-center\">".$linha -> cont."</td>";
                        */
                        echo "
                                                                                            <td class=\"text-center\">";
                        if($linha -> bl_removido == '0'){
                                if($atual > $dt_fim){
                                        //if(isset($selecao_entrevista[$linha -> pr_vaga])){
                                                //echo anchor('Vagas/selecionar_entrevista/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-edit"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Selecionar candidatos\"");
                                        //}
                                        //echo anchor('Vagas/visualizar_nota/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Visualizar candidato\"");
                                        echo anchor('Vagas/resultado/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-1 fa-sort-amount-down"></i> Resultados', " class=\"btn btn-sm btn-square btn-info\" title=\"Resultados\"");
                                }
                                if($linha -> bl_finalizado != '1' && $this -> session -> perfil != 'avaliador'){
                                                echo anchor('Vagas/edit/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-1 fa-edit"></i> Editar', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar vaga\"");
                                                echo anchor('Vagas/gerirAvaliadores/'.$linha -> pr_vaga, '<i class="fas fa-id-card-alt mr-1"></i> Gerir avaliadores', " class=\"btn btn-sm btn-square btn-warning\" title=\"Gerir avaliadores\"");
                                                if(!($linha -> bl_liberado == '1')){
                                                                echo anchor('Vagas/liberar_vaga/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-1 fa-check-square"></i> Liberar para inscrição', " class=\"btn btn-sm btn-square btn-primary\" title=\"Liberar para inscrição\"");
                                                }
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar vaga\" onclick=\"confirm_delete(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i> Desativar</a>";
                                }
                        }
                        else {
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar vaga\" onclick=\"confirm_reactivate(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i> Reativar</a>";
                        }

                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function check_inativo(){
                                                            if(document.getElementById('inativo').checked == true){
                                                                    $(location).attr('href', '".base_url('Vagas/index/')."1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '".base_url('Vagas/index/')."')        
                                                            }
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'A vaga em questão será marcada como desativada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/delete/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'A vaga em questão voltará a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reactivate/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [0, 'asc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";
}
else if($menu2 == 'create' || $menu2 == 'edit'){
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                if(isset($dt_inicio)){
                        $inicio = strtotime($dt_inicio);
                }
                else{
                        $inicio = 0;
                }
				
				$atual = time();
		//gambiarra para liberar a edição de vaga liberada	
                /*if(!isset($bl_liberado)){
                        $bl_liberado = '0';
                }*/
                $bl_liberado = '0';
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_vagas');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }
        ?>
        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Título da vaga: <abbr title="Obrigatório">*</abbr>', 'nome', $attributes);
                        if(!isset($vc_vaga) || (strlen($vc_vaga) == 0 && strlen(set_value('nome')) > 0)){
                                $vc_vaga = set_value('nome');
                        }

                        $attributes = array('name' => 'nome',
                        'maxlength'=>'250',
                        'class' => 'form-control');
                                                                                                                        
                        if(strstr($erro, "'Nome'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1' && $atual > $inicio){
                                $attributes['onclick'] = "this.value = '{$vc_vaga}';alert('Não é possível alterar o título de vaga já liberada para inscrições!')";
                        }
                        echo form_input($attributes, $vc_vaga);
                        ?>        
                </div>
        </div>

        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Instituição: <abbr title="Obrigatório">*</abbr>', 'instituicao', $attributes);
                        $instituicoes=array(0 => '')+$instituicoes;
                        if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('instituicao')) > 0)){
                                $es_instituicao = set_value('instituicao');
                        }
                        if($bl_liberado == '1' && $atual > $inicio){
                                echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-select form-control\" onchange=\"this.value = '{$es_instituicao}';alert('Não é possível modificar a instituição de vaga de uma vaga já liberada para inscrições!')\"");
                        }
                        else if(strstr($erro, "'Instituição'")){
                                echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-select form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-select form-control\"");
                        }
                        ?>
                </div>
        </div>

        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Grupo de questões da vaga: <abbr title="Obrigatório">*</abbr>', 'grupo', $attributes);

                        foreach ($grupos as $linha){
                                $dados_grupos[$linha -> pr_grupovaga] = $linha -> vc_grupovaga;
                        }
                        if(!is_array($dados_grupos)) {
                                $dados_grupos = array();
                        }
                        $dados_grupos=array(0 => '')+$dados_grupos;
                        if(!isset($es_grupoVaga) || (strlen($es_grupoVaga) == 0 && strlen(set_value('grupo')) > 0)){
                                $es_grupoVaga = set_value('grupo');
                        }

                        if($bl_liberado == '1' && $atual > $inicio){
                                echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-select form-control\"  onchange=\"this.value = '{$es_grupoVaga}';alert('Não é possível modificar o grupo de questões de uma vaga já liberada para inscrições!')\"");
                        }
                        else{
                                if(strstr($erro, "'Grupo da vaga'")){
                                        echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-select form-control is-invalid\"");
                                }
                                else{
                                        echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-select form-control\"");
                                }
                        }
                        ?>
                </div>
        </div>    
            
        <div class="row">
                <div class="col-sm-12 col-md-6 mb-3">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Início das inscrições: <abbr title="Obrigatório">*</abbr>', 'inicio', $attributes);
                
                        if(!isset($dt_inicio) || (strlen($dt_inicio) == 0 && strlen(set_value('inicio')) > 0)){
                                $dt_inicio = set_value('inicio');
                        }
                        $attributes = array('name' => 'inicio',
                                        'id' => 'inicio',
                                        'class' => 'form-control',
                                        'type' => 'datetime-local');
                        if(strstr($erro, "'Início das inscrições'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }

                        if($bl_liberado == '1' && $atual > $inicio){
                                $attributes['onclick'] = "this.value = '".show_date($dt_inicio, true)."';alert('Não é possível modificar a data de início de uma vaga já liberada para inscrições!')";
                        }
                        echo form_input($attributes, str_replace(" ","T",$dt_inicio));
                        ?>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Término das inscrições: <abbr title="Obrigatório">*</abbr>', 'fim', $attributes);
                
                        if(!isset($dt_fim) || (strlen($dt_fim) == 0 && strlen(set_value('inicio')) > 0)){
                                $dt_fim = set_value('fim');
                        }
                        $attributes = array('name' => 'fim',
                                        'id' => 'fim',
                                        'class' => 'form-control',
                                        'type' => 'datetime-local');
                        if(strstr($erro, "'Término das inscrições'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }

                        echo form_input($attributes, str_replace(" ","T",$dt_fim));
                        ?>
                </div>
        </div>         

        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Remuneração da vaga: <abbr title="Obrigatório">*</abbr>', 'remuneracao', $attributes);
                        if(!isset($vc_remuneracao) || (strlen($vc_remuneracao) == 0 && strlen(set_value('remuneracao')) > 0)){
                                $vc_remuneracao = set_value('remuneracao');
                        }
                        $attributes = array('name' => 'remuneracao',
                        'id' => 'remuneracao',
                        'type' => 'text',
                        'maxlength'=>'250',
                        'class' => 'form-control',
                        'onpaste' => 'return false;',
                        'onKeyPress'=> "return(moeda(this,'.',',',event))");
                        if(strstr($erro, "'Remuneração'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$vc_remuneracao}';alert('Não é possível modificar a remuneração de uma vaga já liberada para inscrições!')";
                        }
                        
                        echo form_input($attributes, $vc_remuneracao);
                        ?>
                </div>
        </div>                

        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Atribuições e competências da vaga: <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);
                        if(!isset($tx_descricao) || (strlen($tx_descricao) == 0 && strlen(set_value('descricao')) > 0)){
                                $tx_descricao = set_value('descricao');
                        }
                        $attributes = array('name' => 'descricao',
                                            'rows'=>'3',
                                            'class' => 'form-control');
                        if(strstr($erro, "'Descrição'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1' && $atual > $inicio){
                                $attributes['onclick'] = "this.value = '{$tx_descricao}';alert('Não é possível modificar a descrição das competências e atribuições de uma vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_descricao);
                        ?>
                </div>
        </div>
        
        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label', 'title' => 'Insira neste campo a lista de documentos exigidos para habilitação do candidato à vaga', 'alt' => 'Lista de documentos exigidos e definidos em edital');
                        echo form_label('Documentação Necessária: <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);

                        if(!isset($tx_documentacao) || (strlen($tx_documentacao) == 0 && strlen(set_value('documentacao')) > 0)){
                                $tx_documentacao = set_value('documentacao');
                        }
                        $attributes = array('name' => 'documentacao',
                                        'rows'=>'6',
                                        'class' => 'form-control');
                        if(strstr($erro, "'Documentação necessária'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$tx_documentacao}';alert('Não é possível modificar a documentação necessária de vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_documentacao);
                        ?>
                </div>
        </div>
        
        <div class="row">
                <div class="col">
                        <label class="form-label" for="todasAreaInt">Defina as opções de área de interesse em atuação profissional em que a vaga se encaixa:<abbr title="Obrigatório">*</abbr></label>                                 
                </div>
        </div>        
        <div class="row">
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'atendimento', 'class' => 'form-check-input');
                                if(strlen(set_value('atendimento')) > 0){
                                        $en_atendimento = set_value('atendimento');
                                }
                                echo form_checkbox($attributes, '1', ($en_atendimento == '1'));
                                ?>
                                <span>Atendimento</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'auditoria', 'class' => 'form-check-input');
                                if(strlen(set_value('auditoria')) > 0){
                                        $en_auditoria = set_value('auditoria');
                                }
                                echo form_checkbox($attributes, '1', ($en_auditoria == '1'));
                                ?>
                                <span>Auditoria</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'compras', 'class' => 'form-check-input');
                                if(strlen(set_value('compras')) > 0){
                                        $en_compras = set_value('compras');
                                }
                                echo form_checkbox($attributes, '1', ($en_compras == '1'));
                                ?>
                                <span>Compras</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'controladoria', 'class' => 'form-check-input');
                                if(strlen(set_value('controladoria')) > 0){
                                        $en_controladoria = set_value('controladoria');
                                }
                                echo form_checkbox($attributes, '1', ($en_controladoria == '1'));
                                ?>
                                <span>Controladoria</span>
                        </div>
                </div>
        </div>
        <div class="row">
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('desenvolvimentoEco')) > 0){
                                        $en_desenvolvimento_eco = set_value('desenvolvimentoEco');
                                }
                                
                                $attributes = array('name' => 'desenvolvimentoEco', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_desenvolvimento_eco == '1'));
                                ?>
                                <span>Desenvolvimento econômico</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('desenvSoc')) > 0){
                                        $en_desenv_soc = set_value('desenvSoc');
                                }
                                
                                $attributes = array('name' => 'desenvSoc', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_desenv_soc == '1'));
                                ?>
                                <span>Desenvolvimento social</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('dirHum')) > 0){
                                        $en_dir_hum = set_value('dirHum');
                                }
                                
                                $attributes = array('name' => 'dirHum', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_dir_hum == '1'));
                                ?>
                                <span>Direitos Humanos</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('controladoria')) > 0){
                                        $en_educacao = set_value('controladoria');
                                }
                                
                                $attributes = array('name' => 'educacao', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_educacao == '1'));
                                ?>
                                <span>Educação</span>
                        </div>
                </div>
        </div>
        <div class="row">
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('financeiro')) > 0){
                                        $en_financeiro = set_value('financeiro');
                                }
                                $attributes = array('name' => 'financeiro', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_financeiro == '1'));
                                ?>
                                <span>Financeiro</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('gestContrat')) > 0){
                                        $en_gest_contrat = set_value('gestContrat');
                                }
                                
                                $attributes = array('name' => 'gestContrat', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_gest_contrat == '1'));
                                ?>
                                <span>Gestão de contratos</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('gestPessoa')) > 0){
                                        $en_gest_pessoa = set_value('gestPessoa');
                                }
                                
                                $attributes = array('name' => 'gestPessoa', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_gest_pessoa == '1'));
                                ?>
                                <span>Gestão de pessoas</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'gestProcess', 'class' => 'form-check-input');
                                if(strlen(set_value('gestProcess')) > 0){
                                        $en_gest_process = set_value('gestProcess');
                                }
                                echo form_checkbox($attributes, '1', ($en_gest_process == '1'));
                                ?>
                                <span>Gestão de processos</span>
                        </div>
                </div>
        </div>
        <div class="row">
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                if(strlen(set_value('gestProj')) > 0){
                                        $en_gest_proj = set_value('gestProj');
                                }
                                $attributes = array('name' => 'gestProj', 'class' => 'form-check-input');
                                echo form_checkbox($attributes, '1', ($en_gest_proj == '1'));
                                ?>
                                <span>Gestão de projetos</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'infraestrutura', 'class' => 'form-check-input');
                                if(strlen(set_value('infraestrutura')) > 0){
                                        $en_infraestrutura = set_value('infraestrutura');
                                }
                                echo form_checkbox($attributes, '1', ($en_infraestrutura == '1'));
                                ?>
                                <span>Infraestrutura</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'logistica', 'class' => 'form-check-input');
                                if(strlen(set_value('logistica')) > 0){
                                        $en_logistica = set_value('logistica');
                                }
                                echo form_checkbox($attributes, '1', ($en_logistica == '1'));
                                ?>
                                <span>Logística</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'meioAmb', 'class' => 'form-check-input');
                                if(strlen(set_value('meioAmb')) > 0){
                                        $en_meio_amb = set_value('meioAmb');
                                }
                                echo form_checkbox($attributes, '1', ($en_meio_amb == '1'));
                                ?>
                                <span>Meio Ambiente</span>
                        </div>
                </div>
        </div>
        <div class="row">
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'polPub', 'class' => 'form-check-input');
                                if(strlen(set_value('polPub')) > 0){
                                        $en_pol_pub = set_value('polPub');
                                }
                                echo form_checkbox($attributes, '1', ($en_pol_pub == '1'));
                                ?>
                                <span>Políticas Públicas</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'recHum', 'class' => 'form-check-input');
                                if(strlen(set_value('recHum')) > 0){
                                        $en_rec_hum = set_value('recHum');
                                }
                                echo form_checkbox($attributes, '1', ($en_rec_hum == '1'));
                                ?>
                                <span>Recursos Humanos</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'saude', 'class' => 'form-check-input');
                                if(strlen(set_value('saude')) > 0){
                                        $en_saude = set_value('saude');
                                }
                                echo form_checkbox($attributes, '1', ($en_saude == '1'));
                                ?>
                                <span>Saúde</span>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3 mb-3">
                        <div class="form-check my-2">
                                <?php
                                $attributes = array('name' => 'tic', 'class' => 'form-check-input');
                                if(strlen(set_value('tic')) > 0){
                                        $en_tic = set_value('tic');
                                }
                                echo form_checkbox($attributes, '1', ($en_tic == '1'));
                                ?>
                                <span>Tecnologia da informação</span>
                        </div>
                </div>
        </div>

        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label');
                        echo form_label('Defina o grupo de atividades/órgão de interesse em que a vaga se encaixa: <abbr title="Obrigatório">*</abbr>', 'grupoatividade', $attributes);
                        $gruposatividades = array_merge(array(0 => ''),$gruposatividades);
                        if(!isset($es_grupoatividade) || (strlen($es_grupoatividade) == 0 && strlen(set_value('grupoatividade')) > 0)){
                                $es_grupoatividade = set_value('grupoatividade');
                        }
                        if($bl_liberado == '1' && $atual > $inicio){
                                echo form_dropdown('grupoatividade', $gruposatividades, $es_grupoatividade, "class=\"form-select form-control\" onchange=\"this.value = '{$es_grupoatividade}';alert('Não é possível alterar o grupo de atividades/órgãos de uma vaga já liberada para inscrições!')\"");
                        }
                        else if(strstr($erro, "'Grupo de Atividade'")){
                                echo form_dropdown('grupoatividade', $gruposatividades, $es_grupoatividade, "class=\"form-select form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('grupoatividade', $gruposatividades, $es_grupoatividade, "class=\"form-select form-control\"");
                        }
                        ?>
                </div>
        </div>

        <div class="row mb-3">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'form-label', 'title' => 'Caso necessário, insira aqui quaisquer informações úteis ao candidato', 'alt' => 'Informações adicionais sobre a vaga');
                        echo form_label('Informações adicionais para o candidato:', 'orientacoes', $attributes);

                        if(!isset($tx_orientacoes) || (strlen($tx_orientacoes) == 0 && strlen(set_value('descricao')) > 0)){
                                $tx_orientacoes = set_value('orientacoes');
                        }
                        $attributes = array('name' => 'orientacoes',
                                        'rows'=>'6',
                                        'class' => 'form-control');
                        if(strstr($erro, "'Orientações'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$tx_orientacoes}';alert('Não é possível modificar as informações adicionais de vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_orientacoes);
                        ?>
                </div>
        </div>

        <div class="row mb-3">
                <div class="col">
                <?php
                $attributes = array('class' => 'btn btn-primary mr-1');
                echo form_submit('salvar_vaga', 'Salvar', $attributes);
                echo "<button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>";
                ?>        
                </div>
        </div>
        </form>
        <?php         
																					
              
                $pagina['js']="
        <script type=\"text/javascript\">
            
            function moeda(a, e, r, t) {
                let n = \"\"
                  , h = j = 0
                  , u = tamanho2 = 0
                  , l = ajd2 = \"\"
                  , o = window.Event ? t.which : t.keyCode;
                if (13 == o || 8 == o)
                    return !0;
                if (n = String.fromCharCode(o),
                -1 == \"0123456789\".indexOf(n))
                    return !1;
                for (u = a.value.length,
                h = 0; h < u && (\"0\" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
                    ;
                for (l = \"\"; h < u; h++)
                    -1 != \"0123456789\".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
                if (l += n,
                0 == (u = l.length) && (a.value = \"\"),
                1 == u && (a.value = \"0\" + r + \"0\" + l),
                2 == u && (a.value = \"0\" + r + l),
                u > 2) {
                    for (ajd2 = \"\",
                    j = 0,
                    h = u - 3; h >= 0; h--)
                        3 == j && (ajd2 += e,
                        j = 0),
                        ajd2 += l.charAt(h),
                        j++;
                    for (a.value = \"\",
                    tamanho2 = ajd2.length,
                    h = tamanho2 - 1; h >= 0; h--)
                        a.value += ajd2.charAt(h);
                    a.value += r + l.substr(u - 2, u)
                }
                return !1
            }
                tinymce.init({
                            
                            selector: 'textarea',
                            height: 300,
                            menubar: false,
                            plugins: [
                                'advlist autolink lists link image charmap print preview anchor',
                                'searchreplace visualblocks code fullscreen',
                                'insertdatetime table paste code help wordcount'
                            ],
                            toolbar: 'undo redo | formatselect | ' +
                            'bold italic backcolor | alignleft aligncenter ' +
                            'alignright alignjustify | bullist numlist outdent indent | ' +
                            'removeformat | help'
                        });

        </script>";
        }
}

else if($menu2 == 'gerirAvaliadores'){
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }
        $attributes = array('id' => 'form_avaliadores');
        //if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                echo form_open($url, $attributes, array('codigo' => $codigo));
        /*}
        else{
                echo form_open($url, $attributes);
        }*/

        ?>

        <div class="row mb-3">
                <div class="col">
                        <h5>Avaliadores da vaga: <?php echo $avaliador -> vc_nome ?></h5>
                </div>
        </div>

        <div class="row mb-3">
                <div class="col">
                        <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="cad_avaliadores_table">
                                        <thead>
                                              <tr>
                                                <th>
                                                <?php
                                                $attributes = array('id'=>'todos','name' => 'todos', 'value' => '1');
                                                echo form_checkbox($attributes, FALSE);  
                                                ?>    
                                                </th>
                                                <th>Nome</th>
                                                <th>CPF</th>
                                                
                                              </tr>  
                                        </thead>
                                        <tbody>
                                              <?php
                                               if(isset($usuarios) || isset($usuarios2)){
                                                        if(isset($usuarios)){
                                                                foreach ($usuarios as $linha){
                                                                        echo "
                                                                                        <tr>
                                                                                                <td>";
                                                                                $attributes = array('id'=>'usuario'.$linha->pr_usuario,'name' => 'usuario'.$linha->pr_usuario, 'value' => $linha->pr_usuario, 'class'=>'usuario_checkbox');                        
                                                                                if(isset($avaliador[$linha->pr_usuario]) && $avaliador[$linha->pr_usuario] == $linha->pr_usuario){
                                                                                        echo form_checkbox($attributes,$linha->pr_usuario,TRUE);
                                                                                }
                                                                                else{
                                                                                        echo form_checkbox($attributes,$linha->pr_usuario,FALSE);
                                                                                }                        
                                                                                echo "</td>
                                                                                                <td>".$linha -> vc_nome."</td>
                                                                                                <td>".$linha -> vc_login."</td>
                                                                                                ";  

                                                                                echo "          
                                                                                        </tr>";
                                                                                } 
                                                                        }                
                                                        else {
                                                                echo "                  <tr>
                                                                                                <td colspan=\"5\">Não foi encontrado nenhum avaliador cadastrado para o órgão</td>                                                                                                                
                                                                                        </tr>";
                                                        }
                                                                                                        
                                                }
                                              ?>
                                        </tbody>
                                </table>        
                        </div>        
                </div>
        </div>

        <div class="row">
                <div class="col">
                        <?php
                        $attributes = array('class' => 'btn btn-primary','id'=>'inserir_avaliadores');
                        echo form_submit('inserir_avaliadores', 'Inserir avaliadores', $attributes);
                        
                        echo "<button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>";
                        ?>       
                </div>
        </div>


        <?php
        $pagina['js']="
        <script type=\"text/javascript\">
        $('#cad_avaliadores_table').DataTable({
                order: [
                    [1, 'asc']
                ],
                columnDefs: [
                        {
                            'orderable': false,
                            'targets': [-1]
                        },
                        {
                            'searchable': false,
                            'targets': [-1]
                        }
                ],
                language: {
                            \"decimal\":        \"\",
                            \"emptyTable\":     \"Nenhum item encontrado\",
                            \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                            \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                            \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                            \"infoPostFix\":    \"\",
                            \"thousands\":      \",\",
                            \"lengthMenu\":     \"Mostrar _MENU_\",
                            \"loadingRecords\": \"Carregando...\",
                            \"processing\":     \"Carregando...\",
                            \"search\":         \"Pesquisar:\",
                            \"zeroRecords\":    \"Nenhum item encontrado\",
                            \"paginate\": {
                                \"first\":      \"Primeira\",
                                \"last\":       \"Última\",
                                \"next\":       \"Próxima\",
                                \"previous\":   \"Anterior\"
                            },
                            \"aria\": {
                                \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                \"sortDescending\": \": clique para ordenar de forma decrescente\"
                            }
                },
                lengthMenu: [
                        [-1],
                        [\"Todos\"]
                    ]
        });

        jQuery(':submit').click(function (event) {
                if (this.id == 'inserir_avaliadores') {
                        event.preventDefault();
                        $(document).ready(function(){
                                event.preventDefault();
                                if($('input[type=\"search\"]').val().length > 0){
                                        alert('Limpe o campo de busca antes de salvar');
                                }
                                else{
                                        //desfaz as configurações do botão
                                        $('#inserir_avaliadores').unbind(\"click\");
                                        //clica, concluindo o processo
                                        $('#inserir_avaliadores').click();
                                }

                                


                });
                                                                                                                                                                                                }
        });
        
       
</script>
        ";

}

else if($menu2 == 'resultado'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            <th>Teste de Aderência</th>
                                                                                            <th>Teste de Motivação</th>
                                                                                            <th>Teste de HBDI</th>
                                                                                            <th>Formulário de Situação Funcional</th>
                                                                                            ";
        if($this -> session -> perfil != 'avaliador'){
                echo "
                                                                                            <th>Nota total</th>
                                                                                            
                                                                                            <th>Nota - Anál. Curricular</th>
                                                                                            <th>Nota bruta - Anál. Curricular</th>
                                                                                            <th>Nota - Teste aderência</th>
                                                                                            <th>Nota bruta - Teste aderência</th>
                                                                                            <th>Nota - Teste motivação</th>
                                                                                            <th>Nota bruta - Teste motivação</th>
                                                                                            <th>Nota - Entr. Competência</th>
                                                                                            <th>Nota bruta - Entr. Competência</th>
                                                                                            <th>Nota - Entre. Especialista</th>
                                                                                            <th>Nota bruta - Entre. Especialista</th>
                                                                                            ";
        }                                                                                    
        echo "
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($candidaturas)){
		$atual = time();
                foreach ($candidaturas as $linha){
			$dt_fim = strtotime($linha -> dt_fim);
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome.'</td>';
                        if($linha -> es_status == 7 || $linha -> es_status == 8){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-warning badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else if($linha -> es_status == 9 || $linha -> es_status ==13 || $linha -> es_status ==15 || $linha -> es_status ==18  || $linha -> es_status ==20){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else if($linha -> es_status == 10 || $linha -> es_status ==11 || $linha -> es_status ==12 || $linha -> es_status ==14 || $linha -> es_status ==16 || $linha -> es_status ==19){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">".$linha -> vc_status;
                                if($linha -> es_status == 10){
                                        if(isset($entrevistas[$linha -> pr_candidatura]['competencia'])){
                                                echo " - Competência";
                                        }
                                        if(isset($entrevistas[$linha -> pr_candidatura]['especialista'])){
                                                echo " - Especialista";
                                        }
                                }                                                        
                                echo '</span></td>';
                        }
                        echo "
                                                                                            <td class=\"text-center\">".($linha -> en_aderencia == '2'?"Realizado":($linha -> en_aderencia == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"Não solicitado"))."</td>
                                                                                            <td class=\"text-center\">".($linha -> en_motivacao == '2'?"Realizado":($linha -> en_motivacao == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"Não solicitado"))."</td>
                                                                                            <td class=\"text-center\">".($linha -> en_hbdi == '2'?"Realizado":($linha -> en_hbdi == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"Não solicitado"))."</td>
                                                                                            <td class=\"text-center\">".($linha -> en_situacao_funcional == '2'?"Realizado":($linha -> en_situacao_funcional == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"Não solicitado"))."</td>
                                                                                            ";
                        /*
                        echo "
                                                                                            <td class=\"text-center\">".$linha -> cont."</td>";
                        */
                        
			if(!isset($linha -> in_nota2) || !(strlen($linha -> in_nota2) > 0)){
                                $linha -> in_nota2 = 0;
                        }
                        if(!isset($linha -> in_nota3) || !(strlen($linha -> in_nota3) > 0)){
                                $linha -> in_nota3 = 0;
                        }
                        
                        if(!isset($linha -> in_nota4) || !(strlen($linha -> in_nota4) > 0)){
                                $linha -> in_nota4 = 0;
                                
                        }
                        if(!isset($linha -> in_nota5) || !(strlen($linha -> in_nota5) > 0)){
                                $linha -> in_nota5 = 0;
                        }
                        if(!isset($linha -> in_nota6) || !(strlen($linha -> in_nota6) > 0)){
                                $linha -> in_nota6 = 0;
                        }
                        if(!isset($linha -> in_nota7) || !(strlen($linha -> in_nota7) > 0)){
                                $linha -> in_nota7 = 0;
                        }
                        
                        if($linha -> en_aderencia == '1'){
                                $linha -> in_nota5 = 0;
                        }
                        if($linha -> en_motivacao == '1'){
                                $linha -> in_nota6 = 0;
                        }

                        if($linha -> es_status == 20 || $linha -> es_status == 21){
                                $linha -> in_nota3 = 0;
                        }
                        
                        

                        $total = 0;

                        $bruta3 = round(($total3*$linha->in_nota3)/100);
                        $bruta4 = round(($total4*$linha->in_nota4)/100);
                        $bruta5 = round(($total5*$linha->in_nota5)/100);
                        $bruta6 = round(($total6*$linha->in_nota6)/100);
                        $bruta7 = round(($total7*$linha->in_nota7)/100);

                        /*if($linha -> in_nota2 != 0){
                                        $total += intval($linha -> in_nota2);
                        }*/
                        if($linha -> in_nota3 != 0){
                                        $total += intval($linha -> in_nota3);
                        }
                        if($linha -> in_nota4 != 0){
                                        $total += intval($linha -> in_nota4);
                        }
                        if($linha -> in_nota5 != 0){
                                        $total += intval($linha -> in_nota5);
                        }
                        if($linha -> in_nota6 != 0){
                                        $total += intval($linha -> in_nota6);
                        }
                        if($linha -> in_nota7 != 0){
                                        $total += intval($linha -> in_nota7);
                        }
                        if($this -> session -> perfil != 'avaliador'){
                                if($linha -> in_nota6 == 0){
                                        if($linha -> en_aderencia){
                                                        if($linha -> en_motivacao){
                                                                        echo "
                                                                                            <td class=\"text-center\">".(round($total/4))."</td>";
                                                        }
                                                        else{
                                                                        echo "
                                                                                            <td class=\"text-center\">".(round($total/3))."</td>";
                                                        }
                                                                        
                                        }
                                        else{
                                                        echo "
                                                                                            <td class=\"text-center\">".(round($total/2))."</td>";
                                        }
                                }
                                else{
                                        if($linha -> en_aderencia){
                                                        if($linha -> en_motivacao){
                                                                echo "
                                                                                            <td class=\"text-center\">".(round($total/5))."</td>";
                                                        }
                                                        else{
                                                                echo "
                                                                                            <td class=\"text-center\">".(round($total/4))."</td>";
                                                        }
                                                                        
                                        }
                                        else{
                                                        echo "
                                                                                            <td class=\"text-center\">".(round($total/3))."</td>";
                                        }
                                }
                                //<td class=\"text-center\">".$linha -> in_nota2."</td>
                                echo "
																							
                                                                                            
                                                                                            <td class=\"text-center\">".$linha -> in_nota3."</td>
                                                                                            <td class=\"text-center\">".$bruta3."</td>
                                                                                            <td class=\"text-center\">".$linha -> in_nota5."</td>
                                                                                            <td class=\"text-center\">".$bruta5."</td>
                                                                                            <td class=\"text-center\">".$linha -> in_nota7."</td>
                                                                                            <td class=\"text-center\">".$bruta7."</td>
                                                                                            <td class=\"text-center\">".$linha -> in_nota4."</td>
                                                                                            <td class=\"text-center\">".$bruta4."</td>
                                                                                            <td class=\"text-center\">".$linha -> in_nota6."</td>
                                                                                            <td class=\"text-center\">".$bruta6."</td>
                                                                                            ";
                        }                                                                    
                        echo "
                                                                                            <td class=\"text-center\">";


                        echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-search"></i> Detalhes', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                        /*
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\"></i></a>";
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar currículo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
                        */

						if($vagas[0] -> bl_finalizado!= '1'){
							
								if($linha -> es_status == 8 || $linha -> es_status == 10){ //candidatura realizada ou selecionado para entrevista por competência
                                                                                if($this -> session -> perfil != 'avaliador'){
                                                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i> Agendamento competência', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por competência\"");
                                                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura.'/especialista', '<i class="fa fa-lg mr-0 fa-calendar-check"></i> Agendamento especialista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Agendar entrevista com especialista\"");
                                                                                        /*if(strlen($linha -> en_aderencia) == 0 && $linha -> es_status == 10){
                                                                                                        echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Solicitar teste de aderência</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de aderência\"");
                                                                                        }*/
                                                                                        if($linha -> es_status == 8){
                                                                                                echo anchor('Vagas/AlterarStatus/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Alterar status', " class=\"btn btn-sm btn-square btn-secondary\" title=\"Avaliar entrevista\"");
                                                                                        }
                                                                                }
                                                                                if($linha -> es_status == 10){
                                                                                        //echo $entrevistas[$linha -> pr_candidatura]['competencia']->es_avaliador2;
                                                                                        if(isset($entrevistas[$linha -> pr_candidatura]['competencia'])&&(($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador1 || $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0 || strlen($linha -> es_avaliador_competencia2) == 0)){ //avaliador
                                                                                                if(strtotime($entrevistas[$linha -> pr_candidatura]['competencia']->dt_entrevista) <= $atual){
                                                                                                        echo "<br />";
                                                                                                        echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera"></i> Entrevista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
                                                                                                }
                                                                                        }
                                                                                        else if(isset($entrevistas[$linha -> pr_candidatura]['especialista'])&&(($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && $entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador2 == '') { //avaliador
                                                                                                if(strtotime($entrevistas[$linha -> pr_candidatura]['especialista']->dt_entrevista) <= $atual){
                                                                                                        echo "<br />";
                                                                                                        echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera"></i> Entrevista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
                                                                                                }
                                                                                        }
                                                                                }
								}

								else if($linha -> es_status == 11){ //candidatura com entrevista com especialista já realizada
                                                                                if($this -> session -> perfil != 'avaliador'){
										                echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura.'/especialista', '<i class="fa fa-lg mr-0 fa-calendar-check"></i> Agendamento especialista', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista com especialista\"");
                                                                                }
                                                                                                /*if(strlen($linha -> en_aderencia) == 0){
												echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Solicitar teste de aderência</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de aderência\"");
										}*/
										/*if($linha -> en_aderencia == '1'){
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo não preenchimento do teste de aderência\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Eliminar por Teste de Aderência</i></a>";
										}
										else{
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decisão final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Mudar aguardando decisão final</i></a>";
										}*/
                                                                                if(isset($entrevistas[$linha -> pr_candidatura]['especialista'])&&(($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador2) == 0 ){ //avaliador
                                                                                        if(strtotime($entrevistas[$linha -> pr_candidatura]['especialista'] -> dt_entrevista) <= $atual){
                                                                                                echo "<br />";
                                                                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera"></i> Entrevista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
                                                                                        }
                                                                                }
                                                                }
                                                                else if($linha -> es_status == 12){
                                                                                if(strlen($linha -> es_avaliador_competencia1) == 0){
                                                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i> Agendamento Competência', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por competência\"");
                                                                                }
										/*if($linha -> en_aderencia == '1'){
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo não preenchimento do teste de aderência\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Eliminar por Teste de Aderência</i></a>";
										}
										else{
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decisão final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Mudar aguardando decisão final</i></a>";
										}*/
                                                                                if(isset($entrevistas[$linha -> pr_candidatura]['competencia']) && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador1 || $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0))){ //avaliador
                                                                                        if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                                                                echo "<br />";
                                                                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera"></i> Entrevista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
                                                                                        }
                                                                                }
								}
								else if($linha -> es_status == 14 && $this -> session -> perfil != 'avaliador'){
										echo anchor('Candidaturas/editDossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Dossiê', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\"");
								}
								else if($linha -> es_status == 16 && $this -> session -> perfil != 'avaliador'){
                                                                                echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Dossiê', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\"");
										echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar candidato\" onclick=\"confirm_aprovacao_final(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Aprovar candidato</i></a>";
								}
                                                                else if(($linha -> es_status == 18 || $linha -> es_status == 19)&& $this -> session -> perfil != 'avaliador'){
                                                                                echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Dossiê', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\"");
                                                                }
								else if(($linha -> es_status == 20 || $linha -> es_status == 7) && $dt_fim < $atual){
										if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
												echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Currículo', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");
												
												if($linha -> es_status == 20){
														echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprovação por habilitação\" onclick=\"confirm_reprovacao_habilitacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar reprovação por habilitação</i></a>";
												}
										}
								}
                                                                if(strlen($linha -> dt_aderencia) > 0 && strtotime($linha -> dt_aderencia) < $atual && ($linha -> en_aderencia == '1' || $linha -> en_hbdi == '1' || $linha -> en_mtivacao == '1' || $linha -> en_situacao_funcional == '1')){
                                                                        echo anchor('Vagas/ProrrogarAderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Prorrogar testes', " class=\"btn btn-sm btn-square btn-danger\" title=\"Prorrogar testes\"");
                                                                        //echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Prorrogar teste de aderência\"><i class=\"fa fa-lg mr-0 fa-file-alt\">Prorrogar teste de aderência</i></a>";
                                                                }
								/*if($linha -> es_status != 19 && $linha -> es_status != 20){
										echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura por revisão de requisitos\" onclick=\"confirm_reprovacao_requisitos(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
								}*/
						}
                        else if(($linha -> es_status == 16 || $linha -> es_status == 18 || $linha -> es_status == 19)&& $this -> session -> perfil != 'avaliador'){
                                
                                echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Dossiê', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\"");
                        }
                        //echo anchor('Candidaturas/RevisaoRequisitos/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Revisão de requisitos\"");
                         


                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            <script type=\"text/javascript\">";
        /*
                                                    function confirm_aprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação para a entrevista?',
                                                                        text: 'O candidato será aprovado para a entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/aprovar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação da análise curricular?',
                                                                        text: 'O candidato será reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_curriculo/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }*/
        $pagina['js'] .= "
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o não comparecimento à entrevista?',
                                                                        text: 'O candidato será eliminado por não comparecimento à entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não',
                                                                        confirmButtonText: 'Sim, elimine'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Candidaturas/eliminar_entrevista/')."' + id + '/' + {$vagas[0] -> pr_vaga})
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_reprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação dos candidatos não agendados para entrevista?',
                                                                        text: 'Todo o restante de candidatos será reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_restantes/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    
                                                    function confirm_reprovacao2(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação dos candidatos dos candidatos que estão aguardando decisão final, finalizando essa vaga?',
                                                                        text: 'Essa vaga será finalizada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove os candidatos e finalize a vaga'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_restantes2/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_reprovacao_requisitos(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação desse candidato por revisão de requisitos',
                                                                        text: 'Esse candidato será eliminado por revisão por requisitos.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_revisao_requisitos/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reprovacao_entrevista(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação desse candidato por não preenchimento do teste de aderência',
                                                                        text: 'Esse candidato será eliminado pelo não preenchimento do teste de aderência.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
													
													function confirm_reprovacao_habilitacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma que esse candidato perdeu o recurso e será reprovado definitivamente',
                                                                        text: 'Esse candidato será eliminado no teste de habilitação em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, confirma'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_habilitacao/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
													
                                                    function confirm_aprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação para aguardando decisão final',
                                                                        text: 'Esse candidato terá o status alterado para aguardando decisão final, se não tiver entrevista com especialista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/aguardar_decisao_final/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_aprovacao_final(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação final desse candidato',
                                                                        text: 'Esse candidato será aprovado no processo seletivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/aprovar_final/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            bDeferRender: true,
                                                            order: [
                                                                [5, 'desc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";

        

}
else if($menu2 == 'AlterarStatus'){
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_alteracao');
                echo form_open($url, $attributes, array('codigo' => $codigo,'se_pagina_candidatura'=>$se_pagina_candidatura));

                echo "                                          <div class=\"container-fluid\">
                                                                        <div class=\"row\">
                                                                                <div class=\"col\">
                                                                                        <div class=\"alert alert-danger mb-4\">
                                                                                                <h5 class=\"mb-2\">Atenção!</h5>
                                                                                                <p class=\"mb-2\">Essa funcionalidade irá alterar o status de uma candidatura com currículo já avaliado!</p>
                                                                                                <p>Elabore sua justificativa de forma detalhada e respeitando o limite máximo de 4000 caracteres indicado no campo abaixo.</p>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class=\"row mb-3\">
                                                                                <div class=\"col\">
                                                                                        <h5>Dados da candidatura</h5>
                                                                                </div>
                                                                        </div>
                                                                        <div class=\"row\">
                                                                                <div class=\"col-sm-12 col-md-6 mb-3\">";
                                                                                        $attributes = array('class' => 'form-label');
                                                                                        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                        //print_r($candidatura);
                        echo "                                                          </br>
                                                                                        ".$candidato -> vc_nome." 
                                                                                </div>
                                                                                <div class=\"col-sm-12 col-md-6 mb-3\">";
                                                                                        $attributes = array('class' => 'form-label');
                                                                                        echo form_label('Status da candidatura', 'statusCandidatura', $attributes);
                        echo "                                                          </br>
                                                                                        ".$candidatura -> vc_status."
                                                                                </div>
                                                                        </div>
                                                                        <div class=\"row mb-3\">        
                                                                                <div class=\"col-sm-12 col-md-6 mb-3\">";
                                                                                        $attributes = array('class' => 'form-label');
                                                                                        echo form_label('Nome da Vaga:', 'nomeVaga', $attributes);
                        echo "                                                          </br>
                                                                                        ".$candidatura -> vc_vaga."
                                                                                </div>
                                                                                <div class=\"col-sm-12 col-md-6 mb-3\">";
                                                                                        $attributes = array('class' => 'form-label');
                                                                                        echo form_label('Avaliador(a):', 'avaliador', $attributes);
                        echo "                                                          </br>
                                                                                        ".$candidatura -> avaliador_curriculo."
                                                                                </div>
                                                                        </div>
                                                                        <div class=\"row mb-3\">
                                                                                <div class=\"col\">";
                                                                                        $attributes = array('class' => 'form-label');
                                                                                        echo form_label('Justificativa <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                                                                                        $attributes = array('name' => 'justificativa',
                                                                                                            'id' => 'justificativa',
                                                                                                            'rows'=>'5',
                                                                                                            'class' => 'form-control');
                                                                                        if(strstr($erro, "'Justificativa'")){
                                                                                                $attributes['class'] = 'form-control is-invalid';
                                                                                        }
                                                                                        echo form_textarea($attributes, set_value('justificativa'));
                        echo "                                                                                
                                                                                </div>
                                                                        </div>
                                                                        <div class=\"row\">
                                                                                <div class=\"col\">";
                                                                                $attributes = array('class' => 'btn btn-primary');
                                                                                echo form_submit('alterar_entrevista', 'Alterar', $attributes);
                        if($se_pagina_candidatura == '1'){
                                echo "                                                                          
                                                                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao/')."'\">Cancelar</button>";
                        }
                        else{
                                echo "                                                                          
                                                                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$candidatura -> es_vaga)."'\">Cancelar</button>";
                        }
                        echo "
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </form>";

                                                $pagina['js'] .= "
                                                <script type=\"text/javascript\">
                                                        dCounts('justificativa',4000);
                                                </script>
                                                ";


        }
}
else if($menu2 == 'resultado2'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            ";
        foreach($competencias as $competencia){
                echo " 
                                                                                            <th>{$competencia}</th>
                ";
        }
        echo "
                                                                                            
                                                                                            <th>Nota total</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        $chaves = array_keys($competencias);
        if(isset($candidaturas)){
                foreach ($candidaturas as $linha){

                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome.'</td>';
                        
                        
                        
                        echo "
                                                                                            <td class=\"text-center\">-</td>";
                        
                        $total = 0;
                        $divisor = 0;
                        foreach($chaves as $chave){
                                if(isset($notas[$linha->pr_candidatura][$chave])){
                                        $total += $notas[$linha->pr_candidatura][$chave];
                                        ++$divisor;
                                }
                                else{
                                        $notas[$linha->pr_candidatura][$chave] = 0;
                                }
                                echo "
                                                                                            <td class=\"text-center\">{$notas[$linha->pr_candidatura][$chave]}</td>";
                        }
                        if($divisor == 0){
                                $divisor = 1;
                        }
                        $total = $total/$divisor;
                        echo "
                                                                                            <td class=\"text-center\">
                                                                                                    {$total}
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [2, 'desc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";

        

}
else if($menu2 == 'resultado3'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            
                                                                                            
                                                                                            <th>Nota - Anál. Curricular</th>
                                                                                            
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($candidaturas)){
                foreach ($candidaturas as $linha){

                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome.'</td>';
                        
                        echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                       
                        
                        /*
                        echo "
                                                                                            <td class=\"text-center\">".$linha -> cont."</td>";
                        */
                        
						
                        if(!isset($linha -> in_nota3) || !(strlen($linha -> in_nota3) > 0)){
                                $linha -> in_nota3 = 0;
                        }
                        
                        
                        
                        echo "
                                                                                            
                                                                                            <td class=\"text-center\">".$linha -> in_nota3."</td>
                                                                                            
                                                                                            <td class=\"text-center\">";


                        echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-search"></i> Detalhes', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                        /*
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\"></i></a>";
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar currículo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
                        */


                        
			echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-file-alt"></i> Currículo', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");
                        if($linha -> es_status == 20 && $this -> session -> perfil != 'avaliador'){
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprovação por habilitação\" onclick=\"confirm_reprovacao_habilitacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar reprovação por habilitação</i></a>";
                        }


                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            
        
                                            <script type=\"text/javascript\">
													function confirm_reprovacao_habilitacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma que esse candidato perdeu o recurso e será reprovado definitivamente',
                                                                        text: 'Esse candidato será eliminado no teste de habilitação em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, confirma'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_habilitacao/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [2, 'desc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";

        

}
else if($menu2 == 'ProrrogarAderencia'){
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
        
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('id' => 'form_prorrogacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo));
                ?>
                <div class="row mb-3">
                        <div class="col">
                                <h5>Dados da candidatura:</h5>
                        </div>
                </div>
                <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                                echo "</br>";
                                echo $candidato -> vc_nome; 
                                ?>                       
                        </div>
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label ');
                                echo form_label('E-mail:', 'Email', $attributes);
                                echo "</br>";
                                echo $candidato -> vc_email;
                                ?>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Telefone(s):', 'Telefones', $attributes);
                                echo "</br>";
                                echo $candidato -> vc_telefone;
                                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                        echo ' - '.$candidato -> vc_telefoneOpcional;
                                }
                                ?>
                        </div>
                </div>
                <div class="row mb-4">
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Vaga:', 'Vaga', $attributes);
                                echo "</br>";
                                echo $vc_vaga;
                                ?>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Status da candidatura:', 'status', $attributes);
                                echo "</br>";
                                echo $vc_status;
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col">
                                <h5>Data de teste de aderência:</h5>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col-sm-12">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Data atual do teste de aderência', 'data2', $attributes);
                                
                                $dt_aderencia = str_replace(' ',"T",$dt_aderencia);
                        
                                if(strlen(set_value('data2')) > 0){
                                        $dt_aderencia = set_value('data2');
                                }
                                $attributes = array('name' => 'data2',
                                                'id' => 'data2',
                                                'class' => 'form-control',
                                                'type' => 'datetime-local',
                                                'disabled' => 'disabled');
                                
                                echo form_input($attributes, $dt_aderencia);
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col-sm-12">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Nova data do teste de aderência', 'data2', $attributes);
                                
                                
                        
                                
                                $attributes = array('name' => 'data2_nova',
                                                'id' => 'data2_nova',
                                                'class' => 'form-control',
                                                'type' => 'datetime-local'
                                                );
                                if(strstr($erro, "'Nova data do teste de aderência'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
                                echo form_input($attributes, set_value('data2_nova'));
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col">
                                <?php
                                $attributes = array('class' => 'btn btn-primary ml-1');
                                
                                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                                echo "<button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/resultado/'.$es_vaga)."'\">Cancelar</button>";
                                ?> 
                        </div>
                </div>
                <?php
        }
}
else if($menu2 == 'AgendamentoEntrevista'){ //agendamento da entrevista 
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
        
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){

                $attributes = array('id' => 'form_avaliacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo,'tipo_entrevista'=>$tipo_entrevista));
                ?>
                <div class="row mb-3">
                        <div class="col">
                                <h5>Dados da candidatura:</h5>
                        </div>
                </div>
                <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                                echo "</br>";
                                echo $candidato -> vc_nome; 
                                ?>                       
                        </div>
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label ');
                                echo form_label('E-mail:', 'Email', $attributes);
                                echo "</br>";
                                echo $candidato -> vc_email;
                                ?>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Telefone(s):', 'Telefones', $attributes);
                                echo "</br>";
                                echo $candidato -> vc_telefone;
                                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                        echo ' - '.$candidato -> vc_telefoneOpcional;
                                }
                                ?>
                        </div>
                </div>
                <div class="row mb-4">
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Vaga:', 'Vaga', $attributes);
                                echo "</br>";
                                echo $candidatura[0] -> vc_vaga;
                                ?>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Status da candidatura:', 'status', $attributes);
                                echo "</br>";
                                echo $candidatura[0] -> vc_status;
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col">
                                <h5>Dados da Entrevista:</h5>
                        </div>
                </div>
                <div class="row">
                        <div class="col-sm-12 col-md-6 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Avaliador 1 <abbr title="Obrigatório">*:</abbr>', 'avaliador1', $attributes);
                                $dados_usuarios[0] = '';
                                foreach($usuarios as $linha){
                                        $dados_usuarios[$linha -> pr_usuario] = $linha -> vc_nome;
                                }
                                $avaliador1='';
                                if(isset($entrevista[0] -> es_avaliador1) && strlen($entrevista[0] -> es_avaliador1)>0){
                                        $avaliador1=$entrevista[0] -> es_avaliador1;
                                }
                
                
                                if(strlen(set_value('avaliador1')) > 0){
                                        $avaliador1 = set_value('avaliador1');
                                }
                                if(strstr($erro, "'Avaliador 1'")){
                                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-select form-control is-invalid\" id=\"avaliador1\"");
                                }
                                else{
                                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-select form-control\" id=\"avaliador1\"");
                                }
                                ?>
                        </div>
<?php if($tipo_entrevista != 'competencia'){ ?>
                </div>
<?php        }?>                     
<?php if($tipo_entrevista == 'competencia'){ ?>
                        <div class="col-sm-12 col-md-6 mb-3">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Avaliador 2 <abbr title="Obrigatório">*</abbr>', 'avaliador2', $attributes);   
                                $avaliador2='';
                                if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                        $avaliador2 = $entrevista[0] -> es_avaliador2;
                                }

                                if(strlen(set_value('avaliador2')) > 0){
                                        $avaliador2 = set_value('avaliador2');
                                }
                                if(strstr($erro, "'Avaliador 2'")){
                                        echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-select form-control is-invalid\" id=\"avaliador2\"");
                                }
                                else{
                                        echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-select form-control\" id=\"avaliador2\"");
                                }
                                ?>
                        </div>
                </div>     
<?php   if(isset($questoes2)){ ?>       
                <div class="row mb-3">
                        <div class="col-sm-12">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Data/Horário máximo para preenchimento dos testes (Aderência, HBDI e Perfil)<abbr title="Obrigatório">*</abbr>', 'data2', $attributes);
                                $data_aderencia = '';
                                if(isset($candidatura[0] -> dt_aderencia) && strlen($candidatura[0] -> dt_aderencia)>0){
                                        $data_aderencia = $candidatura[0] -> dt_aderencia;
                                        $data_aderencia = str_replace(' ','T',$data_aderencia);
                                }
                        
                                if(strlen(set_value('data2')) > 0){
                                        $data_aderencia = set_value('data2');
                                }
                                $attributes = array('name' => 'data2',
                                                'id' => 'data2',
                                                'class' => 'form-control',
                                                'type' => 'datetime-local');
                                if(strstr($erro, "'Data/Horário máximo'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
                                echo form_input($attributes, $data_aderencia);
                                ?>
                        </div>
                </div>                
        <?php  } ?>
<?php   } ?>       
                <div class="row mb-3">
                        <div class="col">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Horário da entrevista <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                                $data_entrevista = '';
                                if(isset($entrevista[0] -> dt_entrevista) && strlen($entrevista[0] -> dt_entrevista)>0){
                                        $data_entrevista = $entrevista[0] -> dt_entrevista;
                                        $data_entrevista = str_replace(' ','T',$data_entrevista);
                                }
                                        
                                if(strlen(set_value('data')) > 0){
                                        $data_entrevista = set_value('data');
                                }
                                $attributes = array('name' => 'data',
                                                'id' => 'data',
                                                'class' => 'form-control',
                                                'type' => 'datetime-local');
                                if(strstr($erro, "'Horário da entrevista'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
                                echo form_input($attributes, $data_entrevista);
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Link para a entrevista online<abbr title="Obrigatório">*</abbr>', 'link', $attributes);
                                $link = '';
                                if(isset($entrevista[0] -> vc_link) && strlen($entrevista[0] -> vc_link)>0){
                                        $link = $entrevista[0] -> vc_link;
                                }
                                        
                                if(strlen(set_value('link')) > 0){
                                        $link = set_value('link');
                                }
                                $attributes = array('name' => 'link',
                                                'id' => 'link',
                                                                                        'type' => 'text',
                                                                                        'maxlength' => '600',
                                                'class' => 'form-control');
                                if(strstr($erro, "'Horário da entrevista'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
                                echo form_input($attributes, $link);
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col">
                                <?php
                                $attributes = array('class' => 'form-label');
                                echo form_label('Observações', 'link', $attributes);
                                $observacoes = '';
                                if(isset($entrevista[0] -> tx_observacoes) && strlen($entrevista[0] -> tx_observacoes)>0){
                                        $observacoes = $entrevista[0] -> tx_observacoes;
                                }
                                        
                                if(strlen(set_value('observacoes')) > 0){
                                        $observacoes = set_value('observacoes');
                                }
                                $attributes = array('name' => "observacoes",
                                                        'id' => "observacoes",
                                                        'rows' => '4',
                                                        'class' => 'form-control');

                                echo form_textarea($attributes, $observacoes);
                                ?>
                        </div>
                </div>
                <div class="row mb-3">
                        <div class="col">
                                <?php
                                $attributes = array('class' => 'btn btn-primary ml-1');
                                if($tipo_entrevista == 'competencia'){
                                        if(!isset($questoes2)){
                                                $attributes['id'] = 'salvar_entrevista';
                                        }
                                }
                                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                                echo "<button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/resultado/'.$candidatura[0] -> es_vaga)."'\">Cancelar</button>";
                                ?> 
                        </div>
                </div>
        </form>
        <?php
                $pagina['js']="
                <script type=\"text/javascript\">
                     jQuery(':submit').click(function (event) {
                        if (this.id == 'salvar_entrevista') {
                                event.preventDefault();
                                $(document).ready(function(){
                                        event.preventDefault();
                                        swal.fire({
                                                title: 'Aviso de não inserção dos testes',
                                                text: 'Prezado(a) Gestor(a) não foram incluídas questões para a etapa de Teste de Aderência e/ou Teste de Motivação.<br><br>Se continuar os candidatos não poderão responder os testes.<br><br> Deseja confirmar essa ação?',
                                                type: 'warning',
                                                showCancelButton: true,
                                                cancelButtonText: 'Não',
                                                confirmButtonText: 'Sim, desejo salvar'
                                        })
                                        .then(function(result) {
                                                if (result.value) {
                                                        //desfaz as configurações do botão
                                                        $('#salvar_entrevista').unbind(\"click\");
                                                        //clica, concluindo o processo
                                                        $('#salvar_entrevista').click();
                                                }
                                                
                                        });
                                        
                                        
                        });
                                                                                                                                                                                                        }
                    });
                    ";
                
                        $pagina['js'].="
                    $('#avaliador1').select2();";
                if($tipo_entrevista == 'competencia'){    
                        $pagina['js'].="
                        $('#avaliador2').select2();";    
                        
                }
                $pagina['js'].="
                </script>";
        }
        
        echo "
                                                    </div>
                                            </div>";
}
else{
		if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }
}
/*
else if($menu2 == 'visualizar_nota'){

        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Nota análise curricular</th>
                                                                                            <th>Nota entrevista</th>
                                                                                            <th>Nota média</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($candidaturas)){
                foreach ($candidaturas as $linha){

                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome."</td>
                                                                                            <td class=\"text-center\">";
                        if(isset($linha -> in_nota3)){
                                echo $linha -> in_nota3;
                        }
                        echo "</td>
                                                                                            <td class=\"text-center\">";
                        if(isset($linha -> in_nota4)){
                                echo $linha -> in_nota4;
                        }
                        echo "</td>
                                                                                            ";

                        echo "
                                                                                            <td class=\"text-center\">";
                        if(isset($linha -> in_nota3)&&isset($linha -> in_nota4)){
                                echo round((intval($linha -> in_nota3)+intval($linha -> in_nota4))/2);
                        }
                        else if(isset($linha -> in_nota3)){
                                echo $linha -> in_nota3;
                        }
                        else if(isset($linha -> in_nota4)){
                                echo $linha -> in_nota4;
                        }
                        else{
                                echo "0";
                        }
                        echo "</td>";

                        echo "

                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function confirm_aprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação para a entrevista?',
                                                                        text: 'O candidato será aprovado para a entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/aprovar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação da análise curricular?',
                                                                        text: 'O candidato será reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_curriculo/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [0, 'asc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";

        //******************************************

}
*/
/*
else if($menu2 == 'questoes'){
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-exclamation-triangle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                                    </div>
                                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-check-circle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            $sucesso
                                                                                    </div>
                                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_vagas');
                echo form_open($url, $attributes, array('codigo' => $codigo, 'num' => 0));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Vaga');
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                echo form_label('Nome', 'nome', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                $attributes = array('name' => 'nome',
                                    'class' => 'form-control',
                                    'disabled' => 'disabled');
                echo form_input($attributes, $vc_vaga);
                echo "
                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                //var_dump($questoes_atuais);
                $x=0;
                foreach ($questoes_atuais as $linha){
                        $x++;
                        echo form_fieldset('Questão atual '.$x);
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Descrição', 'nome_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'nome_'.$linha -> pr_questao,
                                            'class' => 'form-control',
                                            'rows' => '2');
                        echo form_textarea($attributes, strip_tags($linha -> tx_questao));
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Etapa', 'etapa_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-4\">";
                        $etapas=array(0 => '')+$etapas;
                        if(strstr($erro, "'Etapa'")){
                                echo form_dropdown('etapa_'.$linha -> pr_questao, $etapas, $linha -> es_etapa, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('etapa_'.$linha -> pr_questao, $etapas, $linha -> es_etapa, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Tipo de resposta', 'tipo_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-4\">";
                        $attributes = array(
                                    '' => '',
                                    1 => 'Customizadas',
                                    2 => 'Aberta',
                                    3 => 'Sim/Não (Sim positivo)',
                                    4 => 'Sim/Não (Não positivo)',
                                    5 => 'Nenhum/Básico/Intermediário/Avançado'
                                    );
                        if(strstr($erro, "'Tipo de resposta'")){
                                echo form_dropdown('tipo_'.$linha -> pr_questao, $attributes, $linha -> in_tipo, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('tipo_'.$linha -> pr_questao, $attributes, $linha -> in_tipo, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Resposta aceita', 'resposta_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'resposta_'.$linha -> pr_questao,
                                            'class' => 'form-control',
                                            'maxlength' => '500');
                        echo form_input($attributes, strip_tags($linha -> vc_respostaAceita));
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Eliminatória?', 'eliminatoria_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='1' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='0' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Não
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Obrigatória?', 'obrigatorio_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='1' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='0' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Não
                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                }

                echo "
                                                                                    <div id=\"div_questoes\"></div>
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">
                                                                                                            <button type=\"button\" id=\"adicionar_questao\" class=\"btn btn-default\"><i class=\"la la-plus\"></i> Adicionar questão</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_usuario', 'Salvar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                $pagina['js']="
        <script type=\"text/javascript\">
                $( '#adicionar_questao' ).click(function() {
                        var valor_num = $('input[name=num]').val();
                        valor_num++;
                        var newElement = '<fieldset><legend>Nova questão ' + valor_num + '</legend>";
                //$pagina['js'].=form_fieldset('Requisitos mínimos');
                $pagina['js'].="<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                $pagina['js'].= form_label('Questão pré-cadastrada', 'grupo', $attributes);
                $pagina['js'].= "<div class=\"col-lg-9\">";
                $pagina['js'].="<select name=\"outras_questoes_' + valor_num + '\" class=\"form-control\"><option value=\"\"> -- ESCOLHA AQUI OU DEFINA OS PARÂMETROS ABAIXO -- </option><optgroup label=\"Etapa 1\">";
                foreach ($outras_questoes1 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="<optgroup label=\"Etapa 2\">";
                foreach ($outras_questoes2 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="<optgroup label=\"Etapa 3\">";
                foreach ($outras_questoes3 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"nome2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Descrição</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><textarea name=\"nome2_' + valor_num + '\" cols=\"40\" rows=\"2\" class=\"form-control\" ></textarea></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"etapa2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Etapa</label>";
                $pagina['js'].= "<div class=\"col-lg-4\"><select name=\"etapa2_' + valor_num + '\" class=\"form-control\" >";
                //var_dump($etapas);
                for($x=0;$x<count($etapas);$x++){
                        $pagina['js'].= "<option value=\"{$x}\">".$etapas[$x]."</option>";
                }
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"tipo2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Tipo de resposta</label>";
                $pagina['js'].= "<div class=\"col-lg-4\"><select name=\"tipo2_' + valor_num + '\" class=\"form-control\" >";
                $pagina['js'].= "<option value=\"\"></option>";
                $pagina['js'].= "<option value=\"2\">Aberta</option>";
                $pagina['js'].= "<option value=\"3\">Sim/Não (Sim positivo)</option>";
                $pagina['js'].= "<option value=\"4\">Sim/Não (Não positivo)</option>";
                $pagina['js'].= "<option value=\"5\">Nenhum/Básico/Intermediário/Avançado</option>";
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"resposta2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Resposta aceita</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"text\" name=\"resposta2_' + valor_num + '\" class=\"form-control\" /></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"eliminatoria2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Eliminatória?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"0\" /> Não</div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"obrigatorio2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Obrigatória?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"0\" /> Não</div></div>";

                echo form_fieldset_close();
                $pagina['js'].= "<div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                $pagina['js'].="';
                        $( '#div_questoes' ).append( $(newElement) );
                        $('input[name=num]').val(valor_num);
                });
        </script>";
        }
}*/
/*else{
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }
}*/
echo "
                                                            </div>
                                                    </div>";

$this->load->view('templates/internaRodape', $pagina);

