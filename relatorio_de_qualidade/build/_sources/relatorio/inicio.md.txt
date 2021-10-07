# Introdução

Este relatório tem por objetivo analisar, a partir da execução de uma série de ferramentas de análise
estática, a qualidade de código da plataforma [Transforma Minas](https://github.com/seplagmg/transforma_minas). 
A Pencillabs, em parceria com a fundação Lemman e o time da SEPLAG, realizou uma séria de 
consultorias para disponibilizar o código da plataforma como software livre. Com o código disponível
para o público, o próximo passo é construir uma comunidade em torno do projeto, de modo que
desenvolvedores e gestores públicos possam contribuir e se beneficiar dos recursos oferecidos pela
plataforma.

Para que seja possível construir tal comunidade e receber contribuições de outras pessoas
desenvolvedoras, o código da plataforma precisa ter alguns requisitos não funcionais:

1. Ser simples de ler;
2. Ser simples de manter; 
3. Ser simples de evoluir;

Essas três características são essenciais para qualquer projeto software livre. Sem elas, é
praticamente impossível construir uma política de contribuição por meio de _merge requests_. Surge
então a necessidade de avaliar se o código da plataforma atende esses requisitos, e é por isso que
este relatório foi produzido. Para reduzir o viés interpretativo, uma série
de ferramentas de análise estática foram escolhidas para extrair, de forma automatizada, 
métricas e medidas do código fonte. 

Com essas métricas em mãos, iremos verificar no código se há
respaldo para o que foi encontrado pelas ferramentas. Ao final da nossa análise, iremos sugerir um
possível roadmap que resolva parte ou todos os problemas levantados pelas ferramentas.
Para a coleta de métricas de qualidade utilizaremos um conjunto de ferramentas 
disponíveis no universo PHP. Para uma visão da arquitetura de software e boas práticas de
programação, utilizaremos como base o que a literura de engenharia de software e ciência da computação 
aborda sobre estes assuntos.

Todas as analises foram feitas a partir do commit [https://github.com/seplagmg/transforma_minas/commit/42bb6cdac1413e10e29e4fe456810d815415f50c](https://github.com/seplagmg/transforma_minas/commit/42bb6cdac1413e10e29e4fe456810d815415f50c), no repositório público da plataforma.

## Ferramentas utilizadas nas análises

As seguintes ferramentas serão utilizadas para analisar o código da plataforma:

| Ferramenta         | Descrição     | Tipo | Link |
|--------------|-----------|------------|-----------|
| PHP-CS-Fixer | Ferramenta que formata o código seguindo diversas convensões para PHP      | *Estilo de código*        | [https://github.com/FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)|
| PhpLoc | Ferramenta para medir o tamanho e analisar a estrutura de projetos php      | Metricas de tamanho        | [https://github.com/sebastianbergmann/phploc](https://github.com/sebastianbergmann/phploc)|
| PHP Insight | Ferramenta para coletar metricas de qualidade como complexidade ciclomatica e arquitetura      | Metricas de qualidade        | [https://github.com/nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)|
| Churn PHP | Ferramenta focada em coletar metricas de complexidade ciclomatica      | Metricas de qualidade        | [https://github.com/nunomaduro/phpinsights](https://github.com/bmitch/churn-php)|
| phpcpd | Ferramenta focada em coletar ocorrências de duplicação de código      | Design de código         | [https://github.com/sebastianbergmann/phpcpd](https://github.com/sebastianbergmann/phpcpd)|
