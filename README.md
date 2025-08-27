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
    <li><a href="#decisões-técnicas">Decisões técnicas</a></li>
    <li><a href="#como-configurar-a-aplicação-na-instância-ec2">Configuração da instância EC2</a></li>
    <li><a href="#contato">Contato</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## Sobre o projeto

Este projeto consiste em uma **API back-end** que gerencia anúncios de carros, desenvolvida para atender aos requisitos do teste técnico da Alpes One. O objetivo principal é demonstrar habilidades em desenvolvimento back-end, infraestrutura como serviço (AWS EC2) e conhecimentos de DevOps.

A aplicação foi construída utilizando o framework **Laravel** e um banco de dados SQLite. 

As funcionalidades principais incluem: 
- Um comando Artisan que baixa e processa dados de um endpoint JSON. Ele valida e insere os dados no banco, atualizando itens existentes.
- Uma rotina agendada para verificar e aplicar atualizações no banco de dados a cada hora, caso o JSON original tenha sido alterado. 
- Uma **API RESTful** completa que permite operações de **CRUD** sobre a base de dados, com [documentação](https://luis-munhoz.space/api/documentation) Swagger.
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

Para rodar os testes, use o comando:
```
php artisan test
```
<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

<!-- ACKNOWLEDGMENTS -->
## Decisões técnicas

Algumas decisões que tive que tomar durante o decorrer do projeto

- Não utilizei padrões de projeto como Services / Repositories porque nesse caso eu não tinha regras de negócio e nem requisitos mais complexos, então apenas os Controllers com os Form requests já resolveram o problema.
- O jeito que eu entendi o modelo do banco de dados foi o seguinte: 2 tabelas - Anúncios (Listings), e Imagens (Images), com uma relação **Listing -> has many -> Images**
- Optei pelo banco de dados SQLite pois diminui a complexidade do teste técnico em todas as etapas, desde a configuração local até o deploy em produção.
- Alguns campos poderiam ser unique, como a placa e a URL do veículo, e outros poderiam ser um Enum, como o tipo do veículo, e o tipo do combustível.
- Fiquei um pouco confuso se as rotas deveriam ser protegidas por autenticação ou serem totalmente públicas, então deixei elas públicas

<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

## Como Configurar a Aplicação na Instância EC2

Esta seção descreve os passos necessários para configurar a aplicação e o servidor web na sua instância EC2, tornando a API pública.

#### Passo 1: Conecte-se à sua Instância

Use o SSH para se conectar à instância com a chave de acesso privada e o endereço IP público ou domínio.
```
ssh -i /caminho/para/sua/chave.pem ubuntu@seu_ip_ou_dominio
```

#### Passo 2: Prepare o Ambiente do Servidor

Navegue até o diretório do servidor web e clone o seu projeto. Certifique-se de que o Git está instalado na instância.
```
cd /var/www/
git clone https://github.com/luismunhoz55/AlpesOne-teste-tecnico.git
```

Em seguida, defina as permissões corretas para o diretório do projeto:
```
sudo chown -R www-data:www-data /var/www/AlpesOne-teste-tecnico/
sudo chmod -R 775 /var/www/AlpesOne-teste-tecnico/storage
sudo chmod -R 775 /var/www/AlpesOne-teste-tecnico/bootstrap/cache
```

#### Passo 3: Configure a Aplicação Laravel

1. Navegue para a pasta do projeto e crie o arquivo `.env`:
    ```
    cd AlpesOne-teste-tecnico
    cp .env.example .env
    ```
2. Instale as dependências do Composer
    ```
    composer install --no-dev --optimize-autoloader
    ```
3. Gere a chave da aplicação e rode as migrations:
    ```
    php artisan key:generate
    php artisan migrate
    ```

#### Passo 4: Configure o Servidor Web

Para que sua API seja acessível publicamente, você precisa configurar um servidor web (como Nginx ou Apache) para servir a aplicação Laravel. Crie um novo arquivo de configuração no seu servidor web. O arquivo deve apontar para o diretório `public` do seu projeto.

Exemplo de configuração Nginx:

Nginx

```
server {
    listen 80;
    server_name seu_dominio_ou_ip_publico;
    root /var/www/AlpesOne-teste-tecnico/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Após criar o arquivo, ative-o e reinicie o servidor web para que as mudanças tenham efeito.
```
sudo ln -s /etc/nginx/sites-available/nome_do_arquivo /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```

#### Passo 5: Configure o Agendamento de Tarefas

Para fazer a verificação cada hora se o JSON foi alterado e aplique as atualizações na base de dados, você pode adicionar a tarefa ao `crontab` do seu servidor:

1. Abra o crontab com o comando:
    ```
    crontab -e
    ```
    
2. Adicione a seguinte linha ao final do arquivo:
    ```
    * * * * * cd /var/www/AlpesOne-teste-tecnico && php artisan schedule:run >> /dev/null 2>&1
    ```
<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

<!-- CONTACT -->
## Contato

Luis Munhoz - [linkedin](https://linkedin.com/in/luis-munhoz) - munhozluisfernando@gmail.com

Link do projeto: [https://github.com/luismunhoz55/AlpesOne-teste-tecnico](https://github.com/luismunhoz55/AlpesOne-teste-tecnico)
<p align="right">(<a href="#readme-top">Voltar para o topo</a>)</p>

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/luis-munhoz
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
