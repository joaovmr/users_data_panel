# Random Users Data Admin Panel

## Descrição

Esse é um projeto feito em PHP com Vue para exercitar as boas práticas em PHP e treinar as habilidades em Vue. O projeto consome os dados da API pública https://random-data-api.com/. A aplicação conta com uma tabela de dados em Vue feita manualmente sem uso de bibliotecas a fim de melhorar as habilidades na tecnologia.

## Requisitos

- Node.js >= v20
- PHP >= 8.1

## Instalação

Clone o repositório:
git clone https://github.com/joaovmr/users_data_panel.git

Acesse o diretório do projeto:

cd users_data_panel

Instale as dependências do Node.js para o Vue:
npm install

Em um terminal execute o servidor Laravel:
php artisan serve

Em um terminal separado, compile os assets:
npm run dev

Acesse o aplicativo no navegador:
http://localhost:8000

## Decisões de projeto
O projeto não foi dockerizado devido ao servidor de Vue estar diretamente interno aos resources do PHP, o que gera uma construção complexa sem necessidade no arquivo docker. Essa decisao foi tomada devido ao fato de a chamada da API ja ser feita direto no PHP, o que tornaria sem sentido fazer um front end que consumisse o conteudo do retorno via outra chamada de API. Futuramente o ideal se torna adicionar um servidor de Vue externo, criando assim dois serviços no container Docker para facilitar a construção do Dockerfile.