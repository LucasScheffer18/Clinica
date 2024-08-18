
<div align="center" > 
  <img width="150px" src="https://github.com/user-attachments/assets/9576241b-8933-4507-8e71-d23337fb7d18"/>
  <h1>Clínica Médica</h1>
</div>

<h2>Índice</h2> 

* [Descrição](#descrição)
* [Arquitetura da Aplicação](#globe_with_meridians-arquitetura-da-aplicação---containers)
* [Funcionalidades](#-hammer-funcionalidades)
* [Tecnologias Utilizadas](#-woman_technologist-tecnologias-utilizadas)
* [Acesso ao Projeto](#-acesso-aos-arquivos-do-projeto)


<h2 align="center">Descrição</h2>
Este projeto é um sistema de gerenciamento para clínicas médicas, desenvolvido para otimizar o atendimento e a organização interna. 
O sistema permite o cadastro de pacientes e médicos, agendamento e gerenciamento de consultas, além de manter um histórico detalhado
de atendimentos. Também inclui uma agenda acessível aos médicos, onde podem consultar facilmente suas consultas programadas para o dia,
proporcionando uma visão clara e organizada de suas atividades.

<h2 align="center">:globe_with_meridians: Arquitetura da Aplicação - Containers</h2>

- `usuarios-container`: Armazenar dados dos usuários.
- `mysql-container`: Gerencia o banco de dados.
- `login-contaneir`: Verifica dados do usuário.
- `node-container`: Realiza as requisições, atua como um intermediário entre os containers e é uma api restful.
- `php-container`: Armazena os layouts.

<div align="center">
  <img src="https://github.com/user-attachments/assets/c3daa29b-7b38-4c6c-9c65-cf5efb02949c">
</div>

<h2 align="center"> :hammer: Funcionalidades</h2>

- `Agendar Consulta`: Registrar agendamentos referente às consultas, necessário informar a data, nome do paciente e do médico.
- `Cadastro Médico`: Registrar o nome do médico e sua especialidade.
- `Cadastro Paciente`: Registrar o nome do paciente, endereço, telefone e sua data de nascimento.
- `Diagnóstico`: Registrar o diagnóstico das consultas, informando tratamento, prescrição, nome do paciente, médico e data que foi declarado o diagnóstico.
- `Historico`: Consultar histórico dos diagnósticos dos pacientes que foram atendidos e às respectivas datas.

<h2 align="center"> :woman_technologist: Tecnologias Utilizadas</h2>

- `PHP`
- `HTML, CSS e JS`
- `Docker e Arquituta de Microsserviços `
- `Metologia de MySQL`
- `Frameworks\Bootstrap`

<h2 align="center">📁 Acesso aos Arquivos do Projeto</h2>

Primeiro acesso:
>Login: admin@gmail.com <br>
>Senha: 1234

<h3> 🛠️ Abrir e Rodar o Projeto </h3>

```
Executar Composer:
basta executar o comando “docker-compose up” na mesma pasta do arquivo 
“docker-compose. yml”. 
```

```
Reinicie e Reconstrua:
Às vezes, simplesmente reiniciar o container ou reconstruí-lo pode resolver problemas transitórios.
```

```
docker restart <container_id>
docker-compose up --build
```

```
Email de teste: admin@gmail.com
Senha de teste: 1234
```
