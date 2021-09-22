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


## Ferramentas

As seguintes ferramentas serão utilizadas para analisar o código da plataforma:

| Ferramenta         | Descrição     | Tipo | Link |
|--------------|-----------|------------|-----------|
| PHP-CS-Fixer | Ferramenta que formata o código seguindo diversas convensões para PHP      | *Estilo de código*        | [https://github.com/FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)|
| PhpLoc | Ferramenta para medir o tamanho e analisar a estrutura de projetos php      | Metricas de tamanho        | [https://github.com/sebastianbergmann/phploc](https://github.com/sebastianbergmann/phploc)|
| PHP Insight | Ferramenta para coletar metricas de qualidade como complexidade ciclomatica e arquitetura      | Metricas de qualidade        | [https://github.com/nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)|


## Metricas

### PhpLoc

Vamos iniciar nossa análise pela ferrramenta **PhpLoc**. Segundo estudos na área de metricas de
qualidade, medir o tamanho das classes e módulos segue sendo umas das melhores métricas de
qualidade e por isso iremos começar com esta medição.

Considerando que a ferramenta foi instalada dentro de uma pasta `tools`, 
podemos realizar a analise do código:

		php tools/phploc.phar application/

A ferramenta coleta diversas medidas do código, mas iremos focar nossa análise nas métricas **Lines
of Code**(LOC), **Comment Lines of Code**(CLOC), **Non-comment Lines of Code** (NCLOC), **Logical
Lines of Code** (LLOC). Além dessas também avaliaremos as métricas relacionadas às classes e
funções da plataforma. O relatório completo gerado pela ferramenta, pode ser encontrado em
`relatorio_de_qualidade/phploc-report.txt`

De acordo com a ferramenta, as seguintes métricas foram coletadas:


```
Size
  Lines of Code (LOC)                           111255
  Comment Lines of Code (CLOC)                   24547 (22.06%)
  Non-Comment Lines of Code (NCLOC)              86708 (77.94%)
  Logical Lines of Code (LLOC)                   29454 (26.47%)
    Classes                                      21165 (71.86%)
      Average Class Length                         289
        Minimum Class Length                         1
        Maximum Class Length                      9039
      Average Method Length                         18
        Minimum Method Length                        1
        Maximum Method Length                      722
      Average Methods Per Class                     15
        Minimum Methods Per Class                    0
        Maximum Methods Per Class                  415
    Functions                                      444 (1.51%)
      Average Function Length                        8
    Not in classes or functions                   7845 (26.63%)

Cyclomatic Complexity
  Average Complexity per LLOC                     0.42
  Average Complexity per Class                  126.18
    Minimum Class Complexity                      1.00
    Maximum Class Complexity                   4368.00
  Average Complexity per Method                   8.99
    Minimum Method Complexity                     1.00
    Maximum Method Complexity                   502.00

```

A plataforma possui no total 111255 linhas de código, sendo que destas **22%** é codigo comentado.
Estes comentários não são documentação para facilitar o entendimento de certas estruturas, é código
comentado que não foi removido pelos desenvolvedores. A motivação para isso é incerta, mas esse tipo
de prática impacta diretamente na leitura do código e na possibilidade de realizar alterações sem
quebrar a aplicação.

Ainda olhando outras métricas como NLOC e LLOC temos um cenário curioso. A ferramenta identificou
que **77%** do código é composto por linhas não comentadas, mas apenas **26%** são linhas logicas
(código PHP). Iremos refinar nossa analise para os principais módulos da aplicação, excluindo
os diretórios application/config, application/libraries, application/third_party/, dentro de `application`. Esses diretórios ou pertencem ao CodeIgniter, ou são bibliotecas utilizadas pela aplicação. Olharemos essas diretórios com mais calma em outro momento.

    php tools/phploc.phar application/ --exclude application/config --exclude application/libraries/ --exclude application/third_party/


De acordo com a ferramenta, as seguintes métricas foram coletadas:

```
Size
  Lines of Code (LOC)                            40166
  Comment Lines of Code (CLOC)                    6997 (17.42%)
  Non-Comment Lines of Code (NCLOC)              33169 (82.58%)
  Logical Lines of Code (LLOC)                   12031 (29.95%)
    Classes                                       5062 (42.07%)
      Average Class Length                         281
        Minimum Class Length                        12
        Maximum Class Length                      1284
      Average Method Length                         24
        Minimum Method Length                        1
        Maximum Method Length                      384
      Average Methods Per Class                     11
        Minimum Methods Per Class                    2
        Maximum Methods Per Class                   28
    Functions                                      424 (3.52%)
      Average Function Length                        9
    Not in classes or functions                   6545 (54.40%)

Cyclomatic Complexity
  Average Complexity per LLOC                     0.43
  Average Complexity per Class                  118.06
    Minimum Class Complexity                      4.00
    Maximum Class Complexity                    564.00
  Average Complexity per Method                  11.18
    Minimum Method Complexity                     1.00
    Maximum Method Complexity                   297.00

```

Excluindo os diretórios citados anteriormente, notamos uma redução drastica no tamanho da aplicação. De 111255 para 40166 linhas, uma redução de mais de 50%. Isso pode indicar que boa parte do código do transforma são bibliotecas, modulos e scripts de terceiros, que **podem ou não estar sendo usados**. Isso é um problema grave, já que mais que metade do código é dependência externa. O número de código comentado também segue bem alto, o que implica que a maior parte dos comentários estão no código escrito para o sistema e não código de terceiros.

Ainda falando da porcentagem de código comentado, podemos exemplificar essa pratica olhando a
controller `application/controllers/Candidatos.php`, na função `index`. Da linha 37 até 69 temos
código comentado. Da linha 91 até 180 temos código comentado. Da linha 202 até 304 temos código
comentado. Ou seja, um método de 329 linhas possui 223 linhas comentadas.  

Avaliando as métricas das classes, temos classes com 1284 linhas e métodos com 384 linhas.
Independente do que eles fazem, são implementações muito longas para a natureza da aplicação, que atrapalham escrita de testes, evolução e manutenção. Iremos comparar as métricas de complexidade da ferramenta PhpLoc com a PHP Insight, já que esta é uma métrica que depende de como as ferramentas fazem o processsamento do código.


## PHP Insight
