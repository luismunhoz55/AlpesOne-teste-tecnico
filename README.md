<a id="readme-top"></a>
[![LinkedIn][linkedin-shield]][linkedin-url]
<center

<!-- PROJECT LOGO -->
<div align="center">
  <h3 align="center">Teste técnico Alpes One</h3>

  <p align="center">
    Essa é a documentação de como configurar o projeto, rodar localmente, configurar uma instância EC2, e também minhas decisões ao longo do processo
    <br />
    <a href="https://luis-munhoz.space/api/listings">Link da API</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Índice</summary>
  <ol>
    <li>
      <a href="#sobre-o-projeto">Sobre o projeto</a>
    </li>
    <li>
      <a href="#primeiros-passos">Primeiros passos</a>
      <ul>
        <li><a href="#pré-requisitos">Pré-requisitos</a></li>
        <li><a href="#instalação">Instalação</a></li>
      </ul>
    </li>
    <li><a href="#uso">Uso</a></li>
    <li><a href="#contato">Contato</a></li>
    <li><a href="#decisões-técnicas">Decisões técnicas</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## Sobre o projeto

Este projeto consiste em uma **API back-end** desenvolvida para atender aos requisitos do teste técnico da Alpes One. O objetivo principal é demonstrar habilidades em desenvolvimento back-end, infraestrutura como serviço (AWS EC2) e conhecimentos de DevOps. 

A aplicação foi construída utilizando o framework **Laravel** e um banco de dados SQLite. 

As funcionalidades principais incluem: 
- Um comando Artisan que baixa e processa dados de um endpoint JSON. Ele valida e insere os dados no banco, atualizando itens existentes.
- Uma rotina agendada para verificar e aplicar atualizações no banco de dados a cada hora, caso o JSON original tenha sido alterado. 
- Uma **API RESTful** completa que permite operações de **CRUD** sobre a base de dados.
- Testes automatizados foram implementados para garantir a qualidade e o funcionamento correto da aplicação.
- A infraestrutura foi configurada na AWS, utilizando uma instância **EC2** para hospedar a aplicação.
- Um script de deploy foi criado para automatizar a cópia dos arquivos de código e a reinicialização do servidor. Adicionalmente, foi configurado um pipeline de **CI/CD** para automatizar o deploy a cada *push* para a *branch* `main`.

<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

<!-- GETTING STARTED -->
## Primeiros passos

Siga essas instruções pra configurar e rodar o projeto localmente.
### Pré-requisitos

Para rodar o projeto Laravel localmente, você vai precisar instalar o PHP, Composer e o instalador do Laravel. Você pode baixar todos eles com o seguinte comando:
* Windows PowerShell
```sh
# Rode como administrador
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

- Linux
```
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
```

- MacOS
```
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.4)"
```

Se você já tem o PHP e o Composer instalados, pode instalar o Laravel com o seguinte comando: 
```
composer global require laravel/installer
```

### Instalação

1. Clone o repositório
   ```sh
   git clone https://github.com/luismunhoz55/AlpesOne-teste-tecnico.git
   ```
2. Entre na pasta do projeto e instale as dependências do composer
   ```sh
   cd AlpesOne-teste-tecnico
   composer install
   ```
3. Crie o arquivo .env e configure a chave da aplicação
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. Rode as migrations
   ```sh
   php artisan migrate 
   ```
5. Para buscar os dados da API pela primeira vez, rode o seguinte comando
   ```sh
   php artisan app:fetch-from-api 
   ```
6. Rode a aplicação
   ```sh
   php artisan serve 
   ```

A aplicação vai rodar em http://127.0.0.1:8000

Para rodar o serviço de buscar os dados na API, você pode testar com:
```sh
php artisan schedule:work
```

Mas esse não é o método recomendado em produção. Para rodar corretamente em produção, você precisa adicionar o serviço ao cron:
```sh
crontab -e
```
E adicionar essa linha no final do arquivo:
```sh
* * * * * cd /path-para-o-projeto/AlpesOne-teste-tecnico && php artisan schedule:run >> /dev/null 2>&1
```


<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

<!-- USAGE EXAMPLES -->
## Uso

Para começar, execute o comando Artisan para popular o banco de dados com os dados do JSON original:
```sh
php artisan app:fetch-from-api 
```
Para interagir com os endpoints da API, utilize a documentação interativa completa, que demonstra todas as requisições, parâmetros, exemplos de requisição e resposta.

Para mais informações, acesse a [Documentação](https://luis-munhoz.space/api/documentation)

<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

<!-- CONTACT -->
## Contato

Luis Munhoz - [linkedin](https://linkedin.com/in/luis-munhoz) - munhozluisfernando@gmail.com

Link do projeto: [https://github.com/luismunhoz55/AlpesOne-teste-tecnico](https://github.com/luismunhoz55/AlpesOne-teste-tecnico)

Link da API: [https://luis-munhoz.space/api/listings](https://luis-munhoz.space/api/listings)
<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Decisões técnicas

Algumas decisões que tive que tomar durante o decorrer do projeto

- Não utilizei padrões de projeto como Services / Repositories porque nesse caso eu não tinha regras de negócio e nem requisitos mais complexos, então apenas os Controllers com os Form requests já resolveram o problema.
- Optei pelo banco de dados SQLite pois diminui a complexidade do teste técnico em todas as etapas, desde a configuração local até o deploy em produção
<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>



[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/luis-munhoz
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
