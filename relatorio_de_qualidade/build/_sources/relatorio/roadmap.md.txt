# Roadmap de melhorias

O objetivo desse relatório não é julgar os desenvolvedores e responsáveis pela plataforma Transforma
Minas. Entendemos que existem centenas de fatores envolvidos no processo de desenvolvimento de
sofware que impactam na sua qualidade, principalmente quando falamos de software governamental,
mas como um dos objetivos do projeto no médio prazo é
construir uma comunidade de software livre, composta por pessoas da área técnica e da área da gestão
pública, precisamos entender que o status atual do código ainda não permite essa construção. 

O projeto não possui testes automatizados de nenhum nível, a complexidade ciclomática das controllers,
views e models é alto, o estilo de código adotado está fora das convenções utilizadas pela
comunidade PHP e muitas decisões de implementação ferem conceitos e princípios do Code Igniter. O
uso de ferramentas consolidadas na comunidade PHP para coletarmos métricas que nos mostrassem tais problemas, 
possibilita que outros desenvolvedores repliquem nossas nossas analises (utilizando a mesma versão
do código) e tirem suas próprias conclusões.

A partir dos resultados coletados, propomos um possível roadmap de melhorias de produto. Este
roadmap não irá atuar em problemas de UX/UI, já que esta não foi o foco da nossa análise.
Reescrever a aplicação inteira também não é estratégico, já que ela possui muitos usuários e foi 
desenvolvida com recurso público. 
Este roadmap irá ser guiado por métricas de qualidade, testes automatizados e
melhorias na arquitetura da aplicação. Nosso principais objetivos serão:

1. desenvolver uma suite de testes de aceitação, que permitam que o time refatore partes da
   aplicação sem que a interface quebre para o usuário final;
2. aplicar uma série de conceitos como _single responsability_, _open closed_, reuso de código e
   outras técnicas de refatoração nos arquivos mais problemáticos apontados pelas ferramentas de
   análise estática;
3. construção de um pipeline de deploy contínuo e integração contínua para o repositório público do
   projeto;

Dado esses objetivos, trazemos então a seguinte proposta de roadmap:

## Fase 1

A primeira fase do roadmap será focada na construção de testes de aceitação utilizando a ferramenta
[Cypress](https://www.cypress.io/). Na versão atual do código, é praticamente impossível fazer
testes a nível de controller, então iniciaremos este processo com testes "caixa-preta", em que
testamos os fluxos do usuário ao longo da aplicação. A ideia é construir uma suite de testes
quebre cubram a maior parte das telas e fluxos. Junto aos testes também iremos montar um ambiente
para integração contínua, em que a cada novo commit executaremos a suite de testes construida pelo
time.

- **estimativa de prazo da fase 1**: dois meses;
- **time alocado**: dois desenvolvedores jr e um gestor de projeto;

## Fase 2

A segunda fase irá focar na refatoração das views, controllers e models. Com os testes feitos o time poderá
começar a limpar os códigos comentados, reeimplementar as views usando melhores práticas de frontend
e passando para as controllers regras de negócio e validações que estão sendo implementadas nas
views. Todo esse processo poderá ser feito de forma controlada, já que teremos os testes de
aceitação verificando se o que está sendo entregue não irá quebrar a interface para o usuário.
Nessa fase, incluiremos no pipeline de integração contínua a coleta das métricas utilizando a
as mesmas ferramentas do relatório. Isso irá demonstrar se o nosso trabalho está melhorando a
qualidade do código ou não.

- **estimativa de prazo da fase 2**: três meses;
- **time alocado**: dois desenvolvedores jr e um gestor de projeto;

## Fase 3

A terceira fase irá focar na escrita de testes para as controllers e models, além da correção de
bugs encontrados nas fase 1 e fase 2. Além disso, nessa
fase também iremos disponibilizar o pipeline de deploy contínuo em um ambiente beta.

- **estimativa de prazo da fase 3**: um mês;
- **time alocado**: dois desenvolvedores jr e um gestor de projeto;

No total, o projeto de melhoria e refatoração da plataforma irá durar 6 meses no total. Se bem
sucedido, entregaremos uma nova versão da plataforma com testes, código simples de manter e evoluir
e um guia de desenvolvimento para novos colaboradores.
