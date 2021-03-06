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
                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
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
                                                                                <button type=\"button\" class=\"btn btn-danger\" onclick=\"confirm_reprovacao(".$vagas[0] -> pr_vaga.");\"> Reprovar n??o agendados </button>";
        }*/
        if($aprovado){
                echo "
                                                                                <button type=\"button\" class=\"btn btn-danger\" onclick=\"confirm_reprovacao2(".$vagas[0] -> pr_vaga.");\"> Finalizar vaga </button>";
        }
        
        echo "
                                                                                <button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='".base_url('Vagas/recalcular_nota/'.$vagas[0] -> pr_vaga)."'\">Recalcular nota bruta</button>
										<button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='".base_url('Vagas/resultado3/'.$vagas[0] -> pr_vaga)."'\">Reprovadas na Habilita????o</button>
                                                                                <button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='".base_url('Vagas/resultado2/'.$vagas[0] -> pr_vaga)."'\">Detalhamento por compet??ncia</button>
																			
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
                                                                                            <th>Institui????o</th>
                                                                                            <th>Grupo</th>
                                                                                            <th>Status da vaga</th>
                                                                                            <th>In??cio inscri????o</th>
                                                                                            <th>Fim inscri????o</th>";
        /*
        echo "
                                                                                            <th>Quest??es</th>";
        */
        echo "
                                                                                            <th>A????es</th>
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
																							
						//echo ($linha -> bl_liberado == '1'?'Sim':'N??o');
						if($linha -> bl_removido == '0'){
								if($linha -> bl_liberado != '1'){
										echo "N??o liberada";
								}
								else if($linha -> bl_finalizado == '1'){
										echo "Processo conclu??do";
								}
								else{
										if($dt_fim > $atual){
												echo "Liberada para inscri????o";
										}
										else{
												if(isset($aguardando_decisao[$linha -> pr_vaga])){
														echo "Aguardando decis??o final";
												}
												else{
														echo "Candidaturas sobre an??lise";
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
                                        echo anchor('Vagas/resultado/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-sort-amount-down">Resultados</i>', " class=\"btn btn-sm btn-square btn-info\" title=\"Resultados\"");
                                }
                                if($linha -> bl_finalizado != '1' && $this -> session -> perfil != 'avaliador'){
                                                echo anchor('Vagas/edit/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-edit">Editar</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar vaga\"");
                                                if(!($linha -> bl_liberado == '1')){
                                                                echo anchor('Vagas/liberar_vaga/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-check-square">Liberar para inscri????o</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Liberar para inscri????o\"");
                                                }
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar vaga\" onclick=\"confirm_delete(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar</i></a>";
                                }
                        }
                        else{
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar vaga\" onclick=\"confirm_reactivate(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Reativar</i></a>";
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
                                                                        title: 'Voc?? confirma essa desativa????o?',
                                                                        text: 'A vaga em quest??o ser?? marcada como desativada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma essa reativa????o?',
                                                                        text: 'A vaga em quest??o voltar?? a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        \"info\":           \"Mostrando de  _START_ at?? _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 at?? 0 de 0 itens\",
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
                                                                            \"last\":       \"??ltima\",
                                                                            \"next\":       \"Pr??xima\",
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
			
                if(!isset($bl_liberado)){
                        $bl_liberado = '0';
                }
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_vagas');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }
                echo "
                                                                            <div class=\"kt-portlet__body\">
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Nome <abbr title="Obrigat??rio">*</abbr>', 'nome', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
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
                        $attributes['onclick'] = "this.value = '{$vc_vaga}';alert('N??o pode modificar o nome uma vaga j?? liberada para inscri????es!')";
                }
                echo form_input($attributes, $vc_vaga);
                echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Descri????o <abbr title="Obrigat??rio">*</abbr>', 'descricao', $attributes);
                echo "
                                                                                                    <div class=\"col-lg-6\">";
                if(!isset($tx_descricao) || (strlen($tx_descricao) == 0 && strlen(set_value('descricao')) > 0)){
                        $tx_descricao = set_value('descricao');
                }
                $attributes = array('name' => 'descricao',
                                    'rows'=>'3',
                                    'class' => 'form-control');
                if(strstr($erro, "'Descri????o'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                if($bl_liberado == '1' && $atual > $inicio){
                        $attributes['onclick'] = "this.value = '{$tx_descricao}';alert('N??o pode modificar a descri????o de uma vaga j?? liberada para inscri????es!')";
                }
                echo form_textarea($attributes, $tx_descricao);
                echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Institui????o <abbr title="Obrigat??rio">*</abbr>', 'instituicao', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $instituicoes=array(0 => '')+$instituicoes;
                if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('instituicao')) > 0)){
                        $es_instituicao = set_value('instituicao');
                }
                if($bl_liberado == '1' && $atual > $inicio){
                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\" onchange=\"this.value = '{$es_instituicao}';alert('N??o pode modificar a institui????o de vaga de uma vaga j?? liberada para inscri????es!')\"");
                }
                else if(strstr($erro, "'Institui????o'")){
                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\"");
                }
                echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Grupo da vaga <abbr title="Obrigat??rio">*</abbr>', 'grupo', $attributes);
                echo "
                                                                                            <div class=\"col-lg-5\">";
                //var_dump($grupos);
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
                        echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control\"  onchange=\"this.value = '{$es_grupoVaga}';alert('N??o pode modificar o grupo de vaga de uma vaga j?? liberada para inscri????es!')\"");
                }
                else{
                        if(strstr($erro, "'Grupo da vaga'")){
                                echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control\"");
                        }
                }
                echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('In??cio das inscri????es <abbr title="Obrigat??rio">*</abbr>', 'inicio', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                if(!isset($dt_inicio) || (strlen($dt_inicio) == 0 && strlen(set_value('inicio')) > 0)){
                        $dt_inicio = show_sql_date(set_value('inicio'), true);
                }
                $attributes = array('name' => 'inicio',
                                    'id' => 'inicio',
                                    'class' => 'form-control');
                if(strstr($erro, "'In??cio das inscri????es'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
				if($bl_liberado == '1' && $atual > $inicio){
                        $attributes['onclick'] = "this.value = '".show_date($dt_inicio, true)."';alert('N??o pode modificar a data de in??cio de uma vaga j?? liberada para inscri????es!')";
                }
                echo form_input($attributes, show_date($dt_inicio, true));
                echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('T??rmino das inscri????es <abbr title="Obrigat??rio">*</abbr>', 'fim', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                if(!isset($dt_fim) || (strlen($dt_fim) == 0 && strlen(set_value('inicio')) > 0)){
                        $dt_fim = show_sql_date(set_value('fim'), true);
                }
                $attributes = array('name' => 'fim',
                                    'id' => 'fim',
                                    'class' => 'form-control');
                if(strstr($erro, "'T??rmino das inscri????es'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, show_date($dt_fim, true));
				
                echo "
                                                                                            </div>
                                                                                    </div>";
																					
				/*echo "
																					<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Tipo de vaga <abbr title="Obrigat??rio">*</abbr>', 'brumadinho', $attributes);
                echo "
                                                                                            <div class=\"col-lg-5\">";
                
                $dados_tipo=array('0' => 'Transforma Minas','1' => 'Editais');
                if(!isset($bl_brumadinho) || (strlen($bl_brumadinho) == 0 && strlen(set_value('brumadinho')) > 0)){
                        $bl_brumadinho = set_value('brumadinho');
                }
                
                
				if(strstr($erro, "'Tipo de vaga'")){
						echo form_dropdown('brumadinho', $dados_tipo, $bl_brumadinho, "class=\"form-control is-invalid\"");
				}
				else{
						echo form_dropdown('brumadinho', $dados_tipo, $bl_brumadinho, "class=\"form-control\"");
				}
                
                echo "
                                                                                            </div>
                                                                                    </div>";*/
																					
				echo "
                                                                                    <div class=\"row\" style=\"margin-top: 20px; margin-bottom: 10px;\">
                                                                                            <legend>Avaliadores de curr??culo</legend>
                                                                                            
                ";
                
                
                foreach($usuarios as $usuario){
                        echo "
                                                                                    
                                                                                            <div class=\"col-md-12\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                        
                        echo form_label($usuario->vc_nome, 'usuario'.$usuario->pr_usuario, $attributes);
                        if(!isset($avaliador[$usuario->pr_usuario]) || (strlen($avaliador[$usuario->pr_usuario]) == 0 && strlen(set_value('usuario'.$usuario->pr_usuario)) > 0)){
                                $avaliador[$usuario->pr_usuario] = show_sql_date(set_value('usuario'.$usuario->pr_usuario), true);
                        }
                        if($avaliador[$usuario->pr_usuario] == $usuario->pr_usuario){
                                echo form_checkbox('usuario'.$usuario->pr_usuario, $usuario->pr_usuario, TRUE);
                        }
                        else{
                                echo form_checkbox('usuario'.$usuario->pr_usuario, $usuario->pr_usuario, FALSE);
                        }
                        
                        
                        echo "</div>
                                                                                    ";
                }
                echo "
                                                                                    
                                                                                    
                                                                                    </div>         
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div class=\"row\">
                                                                                            <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_vaga', 'Salvar', $attributes);
                echo "
                                                                                                    <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                $pagina['js']="
        <script type=\"text/javascript\">
            $('#inicio').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
            $('#fim').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
        </script>";
        }
}
else if($menu2 == 'resultado'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            <th>Teste de Ader??ncia</th>
                                                                                            <th>Teste de Motiva????o</th>
                                                                                            <th>Teste de HBDI</th>
                                                                                            ";
        if($this -> session -> perfil != 'avaliador'){
                echo "
                                                                                            <th>Nota total</th>
                                                                                            
                                                                                            <th>Nota - An??l. Curricular</th>
                                                                                            <th>Nota bruta - An??l. Curricular</th>
                                                                                            <th>Nota - Teste ader??ncia</th>
                                                                                            <th>Nota bruta - Teste ader??ncia</th>
                                                                                            <th>Nota - Teste motiva????o</th>
                                                                                            <th>Nota bruta - Teste motiva????o</th>
                                                                                            <th>Nota - Entr. Compet??ncia</th>
                                                                                            <th>Nota bruta - Entr. Compet??ncia</th>
                                                                                            <th>Nota - Entre. Especialista</th>
                                                                                            <th>Nota bruta - Entre. Especialista</th>
                                                                                            ";
        }                                                                                    
        echo "
                                                                                            <th>A????es</th>
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
                                                echo " - Compet??ncia";
                                        }
                                        if(isset($entrevistas[$linha -> pr_candidatura]['especialista'])){
                                                echo " - Especialista";
                                        }
                                }                                                        
                                echo '</span></td>';
                        }
                        echo "
                                                                                            <td class=\"text-center\">".($linha -> en_aderencia == '2'?"Realizado":($linha -> en_aderencia == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"N??o solicitado"))."</td>
                                                                                            <td class=\"text-center\">".($linha -> en_motivacao == '2'?"Realizado":($linha -> en_motivacao == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"N??o solicitado"))."</td>
                                                                                            <td class=\"text-center\">".($linha -> en_hbdi == '2'?"Realizado":($linha -> en_hbdi == '1'?(strlen($linha->dt_aderencia)>0&&strtotime($linha->dt_aderencia)>=$atual?"Solicitado":"Expirado"):"N??o solicitado"))."</td>
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


                        echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-search">Detalhes</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                        /*
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\"></i></a>";
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar curr??culo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
                        */

						if($vagas[0] -> bl_finalizado!= '1'){
							
								if($linha -> es_status == 8 || $linha -> es_status == 10){ //candidatura realizada ou selecionado para entrevista por compet??ncia
                                                                                if($this -> session -> perfil != 'avaliador'){
                                                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento compet??ncia</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por compet??ncia\"");
                                                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura.'/especialista', '<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento especialista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Agendar entrevista com especialista\"");
                                                                                        /*if(strlen($linha -> en_aderencia) == 0 && $linha -> es_status == 10){
                                                                                                        echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Solicitar teste de ader??ncia</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de ader??ncia\"");
                                                                                        }*/
                                                                                }
                                                                                if($linha -> es_status == 10){
                                                                                        //echo $entrevistas[$linha -> pr_candidatura]['competencia']->es_avaliador2;
                                                                                        if(isset($entrevistas[$linha -> pr_candidatura]['competencia'])&&(($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador1 || $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0 || strlen($linha -> es_avaliador_competencia2) == 0)){ //avaliador
                                                                                                if(strtotime($entrevistas[$linha -> pr_candidatura]['competencia']->dt_entrevista) <= $atual){
                                                                                                        echo "<br />";
                                                                                                        echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar n??o comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">N??o Comparecimento</i></a>";
                                                                                                }
                                                                                        }
                                                                                        else if(isset($entrevistas[$linha -> pr_candidatura]['especialista'])&&(($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && $entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador2 == '') { //avaliador
                                                                                                if(strtotime($entrevistas[$linha -> pr_candidatura]['especialista']->dt_entrevista) <= $atual){
                                                                                                        echo "<br />";
                                                                                                        echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar n??o comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">N??o Comparecimento</i></a>";
                                                                                                }
                                                                                        }
                                                                                }
								}

								else if($linha -> es_status == 11){ //candidatura com entrevista com especialista j?? realizada
                                                                                if($this -> session -> perfil != 'avaliador'){
										                echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura.'/especialista', '<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento especialista</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista com especialista\"");
                                                                                }
                                                                                                /*if(strlen($linha -> en_aderencia) == 0){
												echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Solicitar teste de ader??ncia</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de ader??ncia\"");
										}*/
										/*if($linha -> en_aderencia == '1'){
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo n??o preenchimento do teste de ader??ncia\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Eliminar por Teste de Ader??ncia</i></a>";
										}
										else{
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decis??o final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Mudar aguardando decis??o final</i></a>";
										}*/
                                                                                if(isset($entrevistas[$linha -> pr_candidatura]['especialista'])&&(($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($entrevistas[$linha -> pr_candidatura]['especialista'] -> es_avaliador2) == 0 ){ //avaliador
                                                                                        if(strtotime($entrevistas[$linha -> pr_candidatura]['especialista'] -> dt_entrevista) <= $atual){
                                                                                                echo "<br />";
                                                                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar n??o comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">N??o Comparecimento</i></a>";
                                                                                        }
                                                                                }
                                                                }
                                                                else if($linha -> es_status == 12){
                                                                                if(strlen($linha -> es_avaliador_competencia1) == 0){
                                                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento Compet??ncia</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por compet??ncia\"");
                                                                                }
										/*if($linha -> en_aderencia == '1'){
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo n??o preenchimento do teste de ader??ncia\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Eliminar por Teste de Ader??ncia</i></a>";
										}
										else{
												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decis??o final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Mudar aguardando decis??o final</i></a>";
										}*/
                                                                                if(isset($entrevistas[$linha -> pr_candidatura]['competencia']) && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador1 || $this -> session -> uid == $entrevistas[$linha -> pr_candidatura]['competencia'] -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0))){ //avaliador
                                                                                        if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                                                                echo "<br />";
                                                                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar n??o comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">N??o Comparecimento</i></a>";
                                                                                        }
                                                                                }
								}
								else if($linha -> es_status == 14 && $this -> session -> perfil != 'avaliador'){
										echo anchor('Candidaturas/editDossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Dossi??</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossi??\" target=\"blank\"");
								}
								else if($linha -> es_status == 16 && $this -> session -> perfil != 'avaliador'){
                                                                                echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Dossi??</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossi??\" target=\"blank\"");
										echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar candidato\" onclick=\"confirm_aprovacao_final(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Aprovar candidato</i></a>";
								}
                                                                else if(($linha -> es_status == 18 || $linha -> es_status == 19)&& $this -> session -> perfil != 'avaliador'){
                                                                                echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Dossi??</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossi??\" target=\"blank\"");
                                                                }
								else if(($linha -> es_status == 20 || $linha -> es_status == 7) && $dt_fim < $atual){
										if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
												echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-file-alt">Curr??culo</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Curr??culo\"");
												
												if($linha -> es_status == 20){
														echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprova????o por habilita????o\" onclick=\"confirm_reprovacao_habilitacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar reprova????o por habilita????o</i></a>";
												}
										}
								}
								/*if($linha -> es_status != 19 && $linha -> es_status != 20){
										echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura por revis??o de requisitos\" onclick=\"confirm_reprovacao_requisitos(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
								}*/
						}
                        else if(($linha -> es_status == 16 || $linha -> es_status == 18 || $linha -> es_status == 19)&& $this -> session -> perfil != 'avaliador'){
                                echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Dossi??</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossi??\" target=\"blank\"");
                        }
                        //echo anchor('Candidaturas/RevisaoRequisitos/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Revis??o de requisitos\"");
                         


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
                                                                        title: 'Voc?? confirma a aprova????o para a entrevista?',
                                                                        text: 'O candidato ser?? aprovado para a entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a reprova????o da an??lise curricular?',
                                                                        text: 'O candidato ser?? reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma o n??o comparecimento ?? entrevista?',
                                                                        text: 'O candidato ser?? eliminado por n??o comparecimento ?? entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o',
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
                                                                        title: 'Voc?? confirma a reprova????o dos candidatos n??o agendados para entrevista?',
                                                                        text: 'Todo o restante de candidatos ser?? reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a reprova????o dos candidatos dos candidatos que est??o aguardando decis??o final, finalizando essa vaga?',
                                                                        text: 'Essa vaga ser?? finalizada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a reprova????o desse candidato por revis??o de requisitos',
                                                                        text: 'Esse candidato ser?? eliminado por revis??o por requisitos.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a reprova????o desse candidato por n??o preenchimento do teste de ader??ncia',
                                                                        text: 'Esse candidato ser?? eliminado pelo n??o preenchimento do teste de ader??ncia.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma que esse candidato perdeu o recurso e ser?? reprovado definitivamente',
                                                                        text: 'Esse candidato ser?? eliminado no teste de habilita????o em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a aprova????o para aguardando decis??o final',
                                                                        text: 'Esse candidato ter?? o status alterado para aguardando decis??o final, se n??o tiver entrevista com especialista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a aprova????o final desse candidato',
                                                                        text: 'Esse candidato ser?? aprovado no processo seletivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        \"info\":           \"Mostrando de  _START_ at?? _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 at?? 0 de 0 itens\",
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
                                                                            \"last\":       \"??ltima\",
                                                                            \"next\":       \"Pr??xima\",
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
                                                                        \"info\":           \"Mostrando de  _START_ at?? _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 at?? 0 de 0 itens\",
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
                                                                            \"last\":       \"??ltima\",
                                                                            \"next\":       \"Pr??xima\",
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
                                                                                            
                                                                                            
                                                                                            <th>Nota - An??l. Curricular</th>
                                                                                            
                                                                                            <th>A????es</th>
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


                        echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-search">Detalhes</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                        /*
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\"></i></a>";
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar curr??culo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
                        */


                        
			echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-0 fa-file-alt">Curr??culo</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Curr??culo\"");
                        if($linha -> es_status == 20 && $this -> session -> perfil != 'avaliador'){
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprova????o por habilita????o\" onclick=\"confirm_reprovacao_habilitacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar reprova????o por habilita????o</i></a>";
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
                                                                        title: 'Voc?? confirma que esse candidato perdeu o recurso e ser?? reprovado definitivamente',
                                                                        text: 'Esse candidato ser?? eliminado no teste de habilita????o em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        \"info\":           \"Mostrando de  _START_ at?? _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 at?? 0 de 0 itens\",
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
                                                                            \"last\":       \"??ltima\",
                                                                            \"next\":       \"Pr??xima\",
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
                                    'id' => 'form_avaliacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo,'tipo_entrevista'=>$tipo_entrevista));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($entrevista);
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Avaliador 1 <abbr title="Obrigat??rio">*</abbr>', 'avaliador1', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                //var_dump($usuarios);
                //$usuarios=array(0 => '')+$usuarios;
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
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control is-invalid\" id=\"avaliador1\"");
                }
                else{
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\" id=\"avaliador1\"");
                }
                echo "
                                                                                            </div>
                                                                                    </div>";
                if($tipo_entrevista == 'competencia'){
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 2 <abbr title="Obrigat??rio">*</abbr>', 'avaliador2', $attributes);
                        echo "
                                                                                                    <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador2='';
                        if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                $avaliador2 = $entrevista[0] -> es_avaliador2;
                        }

                        if(strlen(set_value('avaliador2')) > 0){
                                $avaliador2 = set_value('avaliador2');
                        }
                        if(strstr($erro, "'Avaliador 2'")){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\" id=\"avaliador2\"");
                        }
                        else{
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\" id=\"avaliador2\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                        if(isset($questoes2)){

                                                                                    
                                echo "
                                                                                    <div class=\"form-group row\">";
                                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                                echo form_label('Data/Hor??rio m??ximo para preenchimento do teste de ader??ncia <abbr title="Obrigat??rio">*</abbr>', 'data2', $attributes);
                                echo "
                                                                                            <div class=\"col-lg-3\">";
                                $data_aderencia = '';
                                if(isset($candidatura[0] -> dt_aderencia) && strlen($candidatura[0] -> dt_aderencia)>0){
                                        $data_aderencia = $candidatura[0] -> dt_aderencia;
                                }
                        
                                if(strlen(set_value('data2')) > 0){
                                        $data_aderencia = show_sql_date(set_value('data2'), true);
                                }
                                $attributes = array('name' => 'data2',
                                                'id' => 'data2',
                                                'class' => 'form-control');
                                if(strstr($erro, "'Data/Hor??rio m??ximo'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
                                echo form_input($attributes, show_date($data_aderencia, true));
                                echo "
                                                                                            </div>
                                                                                    </div>";
                        }
																					
                }
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Hor??rio da entrevista <abbr title="Obrigat??rio">*</abbr>', 'data', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $data_entrevista = '';
                if(isset($entrevista[0] -> dt_entrevista) && strlen($entrevista[0] -> dt_entrevista)>0){
                        $data_entrevista = $entrevista[0] -> dt_entrevista;
                }
                        
                if(strlen(set_value('data')) > 0){
                        $data_entrevista = show_sql_date(set_value('data'), true);
                }
                $attributes = array('name' => 'data',
                                    'id' => 'data',
                                    'class' => 'form-control');
                if(strstr($erro, "'Hor??rio da entrevista'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, show_date($data_entrevista, true));
                echo "
                                                                                            </div>
                                                                                    </div>";
																					
				echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Link para a entrevista <abbr title="Obrigat??rio">*</abbr>', 'link', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
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
                if(strstr($erro, "'Hor??rio da entrevista'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $link);
                echo "
                                                                                            </div>
                                                                                    </div>";

                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Observa????es', 'link', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
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
                
                
                echo "
                                                                                            </div>
                                                                                    </div>";                                                                    																	
																					
                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                if($tipo_entrevista == 'competencia'){
                        if(!isset($questoes2)){
                                $attributes['id'] = 'salvar_entrevista';
                        }
                }
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/resultado/'.$candidatura[0] -> es_vaga)."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
                <script type=\"text/javascript\">
                     jQuery(':submit').click(function (event) {
                        if (this.id == 'salvar_entrevista') {
                                event.preventDefault();
                                $(document).ready(function(){
                                        event.preventDefault();
                                        swal.fire({
                                                title: 'Aviso de n??o inser????o dos testes',
                                                text: 'N??o existem quest??es para a etapa de Teste de Ader??ncia e/ou Teste de Motiva????o, por essa raz??o eles n??o estar??o dispon??veis para o candidato. Deseja continuar?',
                                                type: 'warning',
                                                showCancelButton: true,
                                                cancelButtonText: 'N??o',
                                                confirmButtonText: 'Sim, desejo salvar'
                                        })
                                        .then(function(result) {
                                                if (result.value) {
                                                        //desfaz as configura????es do bot??o
                                                        $('#salvar_entrevista').unbind(\"click\");
                                                        //clica, concluindo o processo
                                                        $('#salvar_entrevista').click();
                                                }
                                                
                                        });
                                        
                                        
                        });
                                                                                                                                                                                                        }
                    });
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });";
                if(isset($questoes2)){
                        $pagina['js'].="
                    $('#data2').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });";

                }
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
                                                                                            <th>Nota an??lise curricular</th>
                                                                                            <th>Nota entrevista</th>
                                                                                            <th>Nota m??dia</th>
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
                                                                        title: 'Voc?? confirma a aprova????o para a entrevista?',
                                                                        text: 'O candidato ser?? aprovado para a entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        title: 'Voc?? confirma a reprova????o da an??lise curricular?',
                                                                        text: 'O candidato ser?? reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'N??o, cancele',
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
                                                                        \"info\":           \"Mostrando de  _START_ at?? _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 at?? 0 de 0 itens\",
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
                                                                            \"last\":       \"??ltima\",
                                                                            \"next\":       \"Pr??xima\",
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
                        echo form_fieldset('Quest??o atual '.$x);
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Descri????o', 'nome_'.$linha -> pr_questao, $attributes);
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
                                    3 => 'Sim/N??o (Sim positivo)',
                                    4 => 'Sim/N??o (N??o positivo)',
                                    5 => 'Nenhum/B??sico/Intermedi??rio/Avan??ado'
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
                        echo form_label('Eliminat??ria?', 'eliminatoria_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='1' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='0' && strlen($linha -> bl_eliminatoria)>0));
                        echo " N??o
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Obrigat??ria?', 'obrigatorio_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='1' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='0' && strlen($linha -> bl_obrigatorio)>0));
                        echo " N??o
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
                                                                                                            <button type=\"button\" id=\"adicionar_questao\" class=\"btn btn-default\"><i class=\"la la-plus\"></i> Adicionar quest??o</button>
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
                        var newElement = '<fieldset><legend>Nova quest??o ' + valor_num + '</legend>";
                //$pagina['js'].=form_fieldset('Requisitos m??nimos');
                $pagina['js'].="<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                $pagina['js'].= form_label('Quest??o pr??-cadastrada', 'grupo', $attributes);
                $pagina['js'].= "<div class=\"col-lg-9\">";
                $pagina['js'].="<select name=\"outras_questoes_' + valor_num + '\" class=\"form-control\"><option value=\"\"> -- ESCOLHA AQUI OU DEFINA OS PAR??METROS ABAIXO -- </option><optgroup label=\"Etapa 1\">";
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
                $pagina['js'].= "<label for=\"nome2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Descri????o</label>";
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
                $pagina['js'].= "<option value=\"3\">Sim/N??o (Sim positivo)</option>";
                $pagina['js'].= "<option value=\"4\">Sim/N??o (N??o positivo)</option>";
                $pagina['js'].= "<option value=\"5\">Nenhum/B??sico/Intermedi??rio/Avan??ado</option>";
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"resposta2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Resposta aceita</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"text\" name=\"resposta2_' + valor_num + '\" class=\"form-control\" /></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"eliminatoria2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Eliminat??ria?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"0\" /> N??o</div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"obrigatorio2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Obrigat??ria?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"0\" /> N??o</div></div>";

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

?>