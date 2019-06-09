# Considerações Finais:

## Sobre hospedagem

A API está hospedada no seguinte link: https://neoassist-backend.herokuapp.com/

E seus dados podem ser visualizados no layout em React: https://neoassist-frontend.herokuapp.com/ (https://github.com/Gmantiqueira/neoassist-api-filter/)

## Sobre a API

A API foi construída em PHP sem frameworks. Ela possui as seguintes funcionalidades:

Paginação - "/?page=1", no momento está mostrando 4 tickets por página (esse número pode ser alterado através do config.php)

Ordenar por:

- Data de Criação (Crescente ou decrescente) - "/?orderby=datecreate" ou "?orderby=datecreate_reverse".

- Data de Atualização (Crescente ou decrescente) - "/?orderby=dateupdate" ou "?orderby=dateupdate_reverse".

- Data de Prioridade (Crescente ou decrescente) - "/?orderby=score" ou "?orderby=score_reverse".

Filtrar por data:

- Desde determinado dia - "/?since=24-12-2017"

- Até determinado dia - "/?until=31-12-2017".

- Deste determinado dia até determinado dia - "/?since=24-12-2017&until=31-12-2017".

E existe a opção de mostrar somente quem possui prioridade alta ou quem possui prioridade normal - "/?highpriority=true" ou "/?highpriority=false"

Esse filtros são cumulativos, ou seja, podem ser utilizados simultaneamente.

Exemplo: "/?orderby=datecreate&since=07-12-2017&until=13-12-2017&page=1&highpriority=true":

- Será ordenado por data de criação, mostrando os tickets desde o dia 07/12/2017 até o dia 13/12/2017, mostrará somente aqueles com prioridade alta e da página 1.

## Sobre a pontuação de prioridade

Para gerar a pontuação de prioridade, utilizei uma relação de Palavras-Chave X Atraso da resposta do funcionário.

Para decidir o humor do consumidor, busquei 4 tipos de palavras-chave e seus determinados valores nas mensagens dos e-mails dos consumidores:

- Palavras "ótimas", que com certeza significam positividade. (valor: 2)
- Palavras "boas", que talvez significam positividade. (valor: 1)
- Palavras "ruins", que talvez significam negatividade. (valor: -1)
- Palavras "críticas", que com certeza significam negatividade. (valor: -2)

Pra cada palavra encontrada, o valor da mesma é adicionada na soma.
A soma de todas as pontuações obtidas gera a "Pontuação de palavras" de determinado ticket.

Depois, utilizei a seguinte fórmula:

W x (1.5 x A) , onde:

W = Pontuação de palavras,
A = Atraso da primeira resposta do Expert,
E o valor 1.5 é apenas um agravante.

## Sobre manutenção de código

No arquivo config.php, podem ser alteradas as palavras-chave e a quantidade de tickets por página.

---

# Desafio desenvolvedor backend

Precisamos melhorar o atendimento no Brasil, para alcançar esse resultado, precisamos de um algoritmo que classifique
nossos tickets (disponível em tickets.json) por uma ordem de prioridade, um bom parâmetro para essa ordenação é identificar o humor do consumidor.
Pensando nisso, queremos classificar nossos tickets com as seguintes prioridade: Normal e Alta.

### São exemplos:

### Prioridade Alta:

- Consumidor insatisfeito com produto ou serviço
- Prazo de resolução do ticket alta
- Consumidor sugere abrir reclamação como exemplo Procon ou ReclameAqui

### Prioridade Normal

- Primeira iteração do consumidor
- Consumidor não demostra irritação

Considere uma classificação com uma assertividade de no mínimo 70%, e guarde no documento (Nosso json) a prioridade e sua pontuação.

### Com base nisso, você precisará desenvolver:

- Um algoritmo que classifique nossos tickets
- Uma API que exponha nossos tickets com os seguintes recursos
  - Ordenação por: Data Criação, Data Atualização e Prioridade
  - Filtro por: Data Criação (intervalo) e Prioridade
  - Paginação

### Escolha as melhores ferramentas para desenvolver o desafio, as únicas regras são:

- Você deverá fornecer informações para que possamos executar e avaliar o resultado;
- Poderá ser utilizado serviços pagos (Mas gostamos bastante de projetos open source)

### Critérios de avaliação

- Organização de código;
- Lógica para resolver o problema (Criatividade);
- Performance

### Como entregar seu desafio

- Faça um Fork desse projeto, desenvolva seu conteúdo e informe no formulário (https://goo.gl/forms/5wXTDLI6JwzzvOEg2) o link do seu repositório
