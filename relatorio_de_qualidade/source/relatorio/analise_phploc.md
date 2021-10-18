# Análise do tamanho da plataforma com a ferramenta phploc

Vamos iniciar nossa análise pela ferrramenta **PhpLoc**. Segundo estudos na área de metricas de
qualidade, medir o tamanho das classes e módulos segue sendo umas das melhores métricas de
qualidade, então iremos começar com esta medição.

Considerando que a ferramenta foi instalada no diretório `tools`, 
podemos realizar a análise do código:

		php tools/phploc.phar application/

A ferramenta coleta diversas medidas do código, mas iremos focar nossa análise nas métricas **Lines
of Code**(LOC), **Comment Lines of Code**(CLOC), **Non-comment Lines of Code** (NCLOC), **Logical
Lines of Code** (LLOC). Além dessas também avaliaremos as métricas relacionadas às classes e
funções da plataforma. O relatório completo gerado pela ferramenta, pode ser encontrado em
`relatorio_de_qualidade/phploc-report.txt`. Uma referência para o entendimento dessas métricas 
pode ser encontrada 
no link [http://www.projectcodemeter.com/cost_estimation/help/GL_sloc.htm](http://www.projectcodemeter.com/cost_estimation/help/GL_sloc.htm).

As seguintes métricas foram coletadas:


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

A plataforma possui no total 111 255 (cento e onze mil duzentas e cinquenta e cinco) linhas de código, 
sendo que destas, **22%** é codigo comentado.
Estes comentários não são documentação para facilitar o entendimento de certas estruturas, é código
comentado que não foi removido pelos desenvolvedores. A motivação para isso é incerta, mas essa prática 
impacta diretamente na leitura do código e na possibilidade de realizar alterações sem
quebrar a aplicação.

Ainda olhando outras métricas como NLOC e LLOC temos um cenário curioso. A ferramenta identificou
que **77%** do código é composto por linhas não comentadas, mas apenas **26%** são linhas logicas
(código PHP). Iremos restringir nossa análise para os principais módulos da aplicação, excluindo
os diretórios `application/config`, `application/libraries` e `application/third_party/`. 
Esses diretórios ou pertencem ao CodeIgniter, ou são bibliotecas utilizadas pela aplicação. 
Avaliaremos esses diretórios com mais calma em outro momento.

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

Excluindo os diretórios citados anteriormente, notamos uma redução drástica no tamanho da aplicação. 
De 111 255 (cento e onze mil duzentas e cinquenta e cinco) para 40 166 (quarenta mil cento e sessenta e seis) linhas, uma redução superior a 50%. O Code Igniter 3 (inteiro) possui 68 577 (sessenta e oito mil quinhentos setenta e sete) linhas. 

Isso pode indicar que boa parte do código do transforma são bibliotecas, modulos e scripts de terceiros, que **podem ou não estar sendo usados**. Isso é um problema grave, já que mais da metade do código é dependência externa. O número de código comentado também segue elevado, o que implica que a maior parte dos comentários estão no código da plataforma e não nas dependências externas. Analisando o espaço em disco, o diretório `application` possui **33 MB**, sendo que a pasta `application/libraries` possui **30 MB**.
Isso indica que das 111 255 (cento e onze mil duzentas e cinquenta e cinco) linhas de código do transforma, apenas a pasta `application/libraries` possui 61 101 (sessenta e um mil cento e um) linhas. Na proposta de [roadmap](./roadmap), uma das tarefas do time será verificar quais bibliotecas são mantidas na pasta `application/libraries` e se elas são realmente uteis para a plataforma.

Ainda falando da porcentagem de código comentado, podemos exemplificar essa prática olhando a
controller `application/controllers/Candidatos.php`, na função `index`. Da linha 37 até 69 temos
código comentado. Da linha 91 até 180 temos código comentado. Entre as linhas 202 até 304 temos código
comentado. Ou seja, um método de 329 linhas possui 223 linhas comentadas.  

Avaliando as métricas das classes, temos classes com 1284 linhas e métodos com 384 linhas.
Classes e métodos muito longos dificultam a escrita de testes, evolução e manutenção do código. 
Iremos comparar as métricas de complexidade da ferramenta PhpLoc com a PHP Insight, 
já que esta é uma métrica que depende de como as ferramentas fazem o processsamento do código.
