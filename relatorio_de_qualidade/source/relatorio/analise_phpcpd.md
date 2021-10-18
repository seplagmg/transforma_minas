# Análise da código duplicado com a ferramenta phpcpd

Utilizaremos a ferramenta [phpcpd](https://github.com/sebastianbergmann/phpcpd) para coletar duplicações no código da plataforma.

Os seguintes comandos foram executados:

     php phpcpd.phar --fuzzy application/views/ > relatorio_de_qualidade/phpcpd-report-views.txt
     php phpcpd.phar --fuzzy application/models/ > relatorio_de_qualidade/phpcpd-report-models.txt
     php phpcpd.phar --fuzzy application/controllers/ > relatorio_de_qualidade/phpcpd-report-controllers.txt
     php phpcpd.phar --fuzzy application/helpers/ > relatorio_de_qualidade/phpcpd-report-helpers.txt


## Duplicações nas views

Para a pasta `views/`, a ferramenta apontou as seguintes duplicações de código:

```
phpcpd 6.0.3 by Sebastian Bergmann.

Found 36 clones with 2032 duplicated lines in 7 files:

  - /transforma-minas/application/views/avaliacoes.php:1056-1260 (204 lines)
    /transforma-minas/application/views/avaliacoes.php:1265-1469

  - /transforma-minas/application/views/avaliacoes.php:5889-6079 (190 lines)
    /transforma-minas/application/views/avaliacoes.php:6102-6292

  - /transforma-minas/application/views/avaliacoes.php:385-570 (185 lines)
    /transforma-minas/application/views/avaliacoes.php:1059-1244

  - /transforma-minas/application/views/avaliacoes.php:203-371 (168 lines)
    /transforma-minas/application/views/avaliacoes.php:4936-5104

  - /transforma-minas/application/views/relatorios.php:1081-1213 (132 lines)
    /transforma-minas/application/views/relatorios.php:1351-1483

  - /transforma-minas/application/views/relatorios.php:835-923 (88 lines)
    /transforma-minas/application/views/relatorios.php:2517-2605

  - /transforma-minas/application/views/avaliacoes.php:817-896 (79 lines)
    /transforma-minas/application/views/avaliacoes.php:2455-2534

  - /transforma-minas/application/views/relatorios.php:733-805 (72 lines)
    /transforma-minas/application/views/relatorios.php:2415-2487

  - /transforma-minas/application/views/avaliacoes.php:372-435 (63 lines)
    /transforma-minas/application/views/avaliacoes.php:5104-5167

  - /transforma-minas/application/views/avaliacoes.php:5919-5981 (62 lines)
    /transforma-minas/application/views/vagas.php:1362-1424

  - /transforma-minas/application/views/avaliacoes.php:926-986 (60 lines)
    /transforma-minas/application/views/avaliacoes.php:2589-2649

  - /transforma-minas/application/views/dossie.php:164-223 (59 lines)
    /transforma-minas/application/views/dossie.php:230-289

  - /transforma-minas/application/views/avaliacoes.php:441-500 (59 lines)
    /transforma-minas/application/views/avaliacoes.php:5171-5230

  - /transforma-minas/application/views/avaliacoes.php:580-638 (58 lines)
    /transforma-minas/application/views/avaliacoes.php:1472-1530

  - /transforma-minas/application/views/avaliacoes.php:4935-4988 (53 lines)
    /transforma-minas/application/views/avaliacoes.php:5924-5977

  - /transforma-minas/application/views/avaliacoes.php:691-739 (48 lines)
    /transforma-minas/application/views/avaliacoes.php:1585-1633

  - /transforma-minas/application/views/dossie.php:447-493 (46 lines)
    /transforma-minas/application/views/dossie.php:519-565

  - /transforma-minas/application/views/avaliacoes.php:411-449 (38 lines)
    /transforma-minas/application/views/avaliacoes.php:2811-2849

  - /transforma-minas/application/views/gruposvagas.php:800-831 (31 lines)
    /transforma-minas/application/views/gruposvagas.php:926-957

  - /transforma-minas/application/views/gruposvagas.php:407-437 (30 lines)
    /transforma-minas/application/views/gruposvagas.php:666-696

  - /transforma-minas/application/views/avaliacoes.php:591-619 (28 lines)
    /transforma-minas/application/views/avaliacoes.php:5290-5318

  - /transforma-minas/application/views/relatorios.php:812-839 (27 lines)
    /transforma-minas/application/views/relatorios.php:1620-1647

  - /transforma-minas/application/views/dossie.php:176-201 (25 lines)
    /transforma-minas/application/views/dossie.php:458-483

  - /transforma-minas/application/views/relatorios.php:812-836 (24 lines)
    /transforma-minas/application/views/relatorios.php:2494-2518

  - /transforma-minas/application/views/base.php:599-622 (23 lines)
    /transforma-minas/application/views/candidaturas.php:860-883

  - /transforma-minas/application/views/base.php:783-804 (21 lines)
    /transforma-minas/application/views/candidaturas.php:1060-1081

  - /transforma-minas/application/views/base.php:571-590 (19 lines)
    /transforma-minas/application/views/candidaturas.php:817-836

  - /transforma-minas/application/views/dossie.php:139-157 (18 lines)
    /transforma-minas/application/views/dossie.php:597-615

  - /transforma-minas/application/views/base.php:468-484 (16 lines)
    /transforma-minas/application/views/candidaturas.php:706-722

  - /transforma-minas/application/views/dossie.php:144-159 (15 lines)
    /transforma-minas/application/views/dossie.php:495-510
    /transforma-minas/application/views/dossie.php:571-586

  - /transforma-minas/application/views/base.php:498-512 (14 lines)
    /transforma-minas/application/views/candidaturas.php:736-750

  - /transforma-minas/application/views/base.php:521-535 (14 lines)
    /transforma-minas/application/views/candidaturas.php:759-773

  - /transforma-minas/application/views/dossie.php:41-55 (14 lines)
    /transforma-minas/application/views/dossie.php:92-106

  - /transforma-minas/application/views/base.php:545-558 (13 lines)
    /transforma-minas/application/views/candidaturas.php:782-795

  - /transforma-minas/application/views/base.php:758-769 (11 lines)
    /transforma-minas/application/views/candidaturas.php:1025-1036

  - /transforma-minas/application/views/relatorios.php:877-887 (10 lines)
    /transforma-minas/application/views/relatorios.php:1146-1156

8.32% duplicated lines out of 24424 total lines of code.
Average size of duplication is 56 lines, largest clone has 204 of lines

Time: 00:00.163, Memory: 28.50 MB

```

## Duplicações nas models

Para a pasta `models/`, a ferramenta apontou as seguintes duplicações de código:

```
phpcpd 6.0.3 by Sebastian Bergmann.

Found 3 clones with 64 duplicated lines in 1 files:

  - /transforma-minas/application/models/Candidaturas_model.php:873-895 (22 lines)
    /transforma-minas/application/models/Candidaturas_model.php:899-921

  - /transforma-minas/application/models/Candidaturas_model.php:1030-1051 (21 lines)
    /transforma-minas/application/models/Candidaturas_model.php:1083-1104

  - /transforma-minas/application/models/Candidaturas_model.php:1059-1080 (21 lines)
    /transforma-minas/application/models/Candidaturas_model.php:1097-1118

2.55% duplicated lines out of 2511 total lines of code.
Average size of duplication is 21 lines, largest clone has 22 of lines

Time: 00:00.029, Memory: 10.00 MB
```

## Duplicações nas controllers

Para a pasta `controllers/`, a ferramenta apontou as seguintes duplicações código:


```
phpcpd 6.0.3 by Sebastian Bergmann.

Found 41 clones with 1771 duplicated lines in 6 files:

  - /transforma-minas/application/controllers/Candidaturas.php:1634-1775 (141 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1860-2001

  - /transforma-minas/application/controllers/Candidaturas.php:1676-1790 (114 lines)
    /transforma-minas/application/controllers/Candidaturas.php:2600-2714

  - /transforma-minas/application/controllers/Relatorios.php:481-573 (92 lines)
    /transforma-minas/application/controllers/Relatorios.php:895-987
    /transforma-minas/application/controllers/Relatorios.php:1102-1194

  - /transforma-minas/application/controllers/Candidaturas.php:1676-1764 (88 lines)
    /transforma-minas/application/controllers/Candidaturas.php:2953-3041

  - /transforma-minas/application/controllers/Candidaturas.php:1681-1751 (70 lines)
    /transforma-minas/application/controllers/Candidaturas.php:3458-3528

  - /transforma-minas/application/controllers/Relatorios.php:501-569 (68 lines)
    /transforma-minas/application/controllers/Relatorios.php:2160-2228

  - /transforma-minas/application/controllers/Candidaturas.php:523-585 (62 lines)
    /transforma-minas/application/controllers/Candidaturas.php:932-994

  - /transforma-minas/application/controllers/Candidaturas.php:213-264 (51 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1263-1314

  - /transforma-minas/application/controllers/Relatorios.php:501-546 (45 lines)
    /transforma-minas/application/controllers/Relatorios.php:709-754

  - /transforma-minas/application/controllers/Candidatos.php:570-614 (44 lines)
    /transforma-minas/application/controllers/Candidaturas.php:845-889

  - /transforma-minas/application/controllers/Candidaturas.php:164-207 (43 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1164-1207

  - /transforma-minas/application/controllers/Relatorios.php:125-168 (43 lines)
    /transforma-minas/application/controllers/Relatorios.php:278-321

  - /transforma-minas/application/controllers/Candidaturas.php:163-205 (42 lines)
    /transforma-minas/application/controllers/Candidaturas.php:216-258

  - /transforma-minas/application/controllers/Candidaturas.php:314-353 (39 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1729-1768

  - /transforma-minas/application/controllers/Candidaturas.php:472-511 (39 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1068-1107

  - /transforma-minas/application/controllers/Candidatos.php:1046-1083 (37 lines)
    /transforma-minas/application/controllers/Usuarios.php:204-241

  - /transforma-minas/application/controllers/Relatorios.php:388-423 (35 lines)
    /transforma-minas/application/controllers/Relatorios.php:608-643
    /transforma-minas/application/controllers/Relatorios.php:814-849
    /transforma-minas/application/controllers/Relatorios.php:1021-1056

  - /transforma-minas/application/controllers/Candidaturas.php:1647-1679 (32 lines)
    /transforma-minas/application/controllers/Candidaturas.php:2569-2601

  - /transforma-minas/application/controllers/Candidaturas.php:376-408 (32 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1503-1535

  - /transforma-minas/application/controllers/Candidaturas.php:1604-1634 (30 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1830-1860

  - /transforma-minas/application/controllers/Candidaturas.php:1776-1805 (29 lines)
    /transforma-minas/application/controllers/Candidaturas.php:2818-2847

  - /transforma-minas/application/controllers/Candidaturas.php:2567-2595 (28 lines)
    /transforma-minas/application/controllers/Candidaturas.php:2923-2951

  - /transforma-minas/application/controllers/Candidaturas.php:1775-1801 (26 lines)
    /transforma-minas/application/controllers/Candidaturas.php:2001-2027

  - /transforma-minas/application/controllers/Candidaturas.php:102-128 (26 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1035-1061

  - /transforma-minas/application/controllers/Relatorios.php:445-470 (25 lines)
    /transforma-minas/application/controllers/Relatorios.php:858-883
    /transforma-minas/application/controllers/Relatorios.php:1065-1090

  - /transforma-minas/application/controllers/Relatorios.php:652-677 (25 lines)
    /transforma-minas/application/controllers/Relatorios.php:2096-2121

  - /transforma-minas/application/controllers/Relatorios.php:39-62 (23 lines)
    /transforma-minas/application/controllers/Relatorios.php:194-217

  - /transforma-minas/application/controllers/Relatorios.php:100-123 (23 lines)
    /transforma-minas/application/controllers/Relatorios.php:255-278

  - /transforma-minas/application/controllers/Candidaturas.php:303-324 (21 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1408-1429

  - /transforma-minas/application/controllers/Relatorios.php:481-501 (20 lines)
    /transforma-minas/application/controllers/Relatorios.php:689-709

  - /transforma-minas/application/controllers/Candidaturas.php:379-398 (19 lines)
    /transforma-minas/application/controllers/Candidaturas.php:1541-1560

  - /transforma-minas/application/controllers/Relatorios.php:584-603 (19 lines)
    /transforma-minas/application/controllers/Relatorios.php:2017-2036

  - /transforma-minas/application/controllers/Candidaturas.php:1776-1795 (19 lines)
    /transforma-minas/application/controllers/Candidaturas.php:3063-3082

  - /transforma-minas/application/controllers/Candidatos.php:538-556 (18 lines)
    /transforma-minas/application/controllers/Candidaturas.php:812-830

  - /transforma-minas/application/controllers/Relatorios.php:584-602 (18 lines)
    /transforma-minas/application/controllers/Relatorios.php:791-809
    /transforma-minas/application/controllers/Relatorios.php:998-1016

  - /transforma-minas/application/controllers/Questoes.php:67-83 (16 lines)
    /transforma-minas/application/controllers/Questoes.php:150-166

  - /transforma-minas/application/controllers/Candidatos.php:1178-1193 (15 lines)
    /transforma-minas/application/controllers/Usuarios.php:335-350

  - /transforma-minas/application/controllers/Vagas.php:1094-1108 (14 lines)
    /transforma-minas/application/controllers/Vagas.php:1261-1275

  - /transforma-minas/application/controllers/Relatorios.php:447-460 (13 lines)
    /transforma-minas/application/controllers/Relatorios.php:654-667

  - /transforma-minas/application/controllers/Candidatos.php:418-429 (11 lines)
    /transforma-minas/application/controllers/Candidaturas.php:616-627

  - /transforma-minas/application/controllers/Candidatos.php:73-84 (11 lines)
    /transforma-minas/application/controllers/Candidatos.php:718-729

15.57% duplicated lines out of 11372 total lines of code.
Average size of duplication is 43 lines, largest clone has 141 of lines

Time: 00:00.125, Memory: 26.50 MB
```

## Duplicações nas helpers

Para a pasta `helpers/`, a ferramenta apontou as seguintes duplicações de código:

```
phpcpd 6.0.3 by Sebastian Bergmann.

No clones found.

Time: 00:00.011, Memory: 6.00 MB
```

O código apresenta muitas duplicações (ctrl-c, ctrl-v), principalmente nas views e controllers. Toda
aplicação vai apresentar algum nível de duplicação, mas o volume de ocorrencias apresentadas pela
ferramenta indica uma provável falha de design e mau cheiro de código.
