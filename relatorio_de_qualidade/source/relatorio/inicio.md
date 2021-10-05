# Introdução

Este relatório tem como objetivo construir uma fotografia da qualidade do código da plataforma
Transforma Minas. Esta fotografia irá focar em métricas de qualidade, arquitetura de software e
boas práticas de programação.

Para a coleta de métricas de qualidade, utilizaremos um conjunto de ferramentas 
disponíveis no universo PHP. Para uma visão da arquitetura de software e boas práticas de
programação utilizaremos como base o que a literura de engenharia de software e ciência da computação 
aborda sobre estes assuntos.

A partir desta fotografia iremos propor um possível roadmap para o
projeto. Este terá como foco a melhoria da manutenibilidade da plataforma para que orgãos
publicos, empresas e desenvolvedores consigam contribuir enviando _merge requests_ para novas
funcionalidades e _patches_ de
correção.


## Ferramentas utilizadas nas análises

As seguintes ferramentas serão utilizadas para analisar o código da plataforma:

| Ferramenta         | Descrição     | Tipo | Link |
|--------------|-----------|------------|-----------|
| PHP-CS-Fixer | Ferramenta que formata o código seguindo diversas convensões para PHP      | *Estilo de código*        | [https://github.com/FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)|
| PhpLoc | Ferramenta para medir o tamanho e analisar a estrutura de projetos php      | Metricas de tamanho        | [https://github.com/sebastianbergmann/phploc](https://github.com/sebastianbergmann/phploc)|
| PHP Insight | Ferramenta para coletar metricas de qualidade como complexidade ciclomatica e arquitetura      | Metricas de qualidade        | [https://github.com/nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)|
| Churn PHP | Ferramenta focada em coletar metricas de complexidade ciclomatica      | Metricas de qualidade        | [https://github.com/nunomaduro/phpinsights](https://github.com/bmitch/churn-php)|
| phpcpd | Ferramenta focada em coletar ocorrências de duplicação de código      | Design de código         | [https://github.com/sebastianbergmann/phpcpd](https://github.com/sebastianbergmann/phpcpd)|
