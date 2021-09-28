# Analise da qualidade com a ferramenta PHP Insight

Utilizaremos a ferramenta PHP Insight para coletar métricas e medidas relacionadas á qualidade do
código da plataforma. Iremos analisar a métrica de complexidade ciclomatica, mal cheiro de código, arquitetura e estilo de programação em PHP. Iremos focar em arquivos que pertencem ao
domínio da aplicação e excluiremos diretórios que pertençam ao Codeigniter ou a bibliotecas de
terceiros.

Iremos avaliar as métricas dos principais diretórios: `application/controllers`, `application/models/`,
`application/helpers/` e `application/views/`. São eles que de fato implementam o domínio da aplicação.
Faremos então uma análise __top-down__, ou seja, avaliaremos as métricas
de forma geral e depois avaliaremos os diretórios individualmente.


## Visão geral

Para coletar as métricas, executamos o seguinte comando:

    vendor/bin/phpinsights analyse application/controllers application/models/ application/helpers/ application/views/

e obtivemos o seguinte resultado:

![relatorio](../_static/images/phpinsight.png)

A ferramenta atribui um percentual de qualidade de 0 a 100 para cada uma das métricas
(código, complexidade, arquitetura e estilo). Para cada métrica uma série de atributos são
analisados e são eles quem compõe a nota final dada pela ferramenta. Iremos interpretar os
percentuais que a ferramenta atribuiu para cada uma das métricas e tentar justificar, com exemplos
no código, as razões para cada percentual.


### Codigo

Na analise geral, a ferramenta atribuiu **61** pontos (de 0 a 100), para a métrica de código. 



## application/controllers

## application/models


## application/helpers

## application/views

