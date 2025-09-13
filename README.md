# 📦 Sistema de Controle de Estoque

![Status](https://img.shields.io/badge/status-conclu%C3%ADdo-brightgreen?style=for-the-badge)

Um sistema web completo para gestão de estoque, desenvolvido passo a passo com foco em boas práticas, arquitetura MVC e tecnologias modernas, incluindo configuração segura com variáveis de ambiente.

---

### ✨ Funcionalidades

-   **Dashboard Gerencial:**
    -   Visualização rápida de estatísticas chave (total de produtos, itens em estoque).
    -   Histórico das últimas movimentações.
-   **Gestão de Produtos (CRUD Completo):**
    -   Cadastro, listagem, edição e exclusão de produtos.
    -   Associação de produtos a categorias.
-   **Gestão de Categorias (CRUD Completo):**
    -   Cadastro, listagem, edição e exclusão de categorias.
-   **Movimentação de Estoque:**
    -   Registro de entradas e saídas de produtos.
    -   Atualização automática da quantidade em estoque de forma transacional, garantindo a integridade dos dados.
-   **Sistema de Autenticação:**
    -   Registro de novos usuários com armazenamento seguro de senhas (hash).
    -   Login e Logout com gerenciamento de sessão.
    -   Proteção de rotas, permitindo acesso apenas a usuários autenticados.

---

### 🚀 Tecnologias Utilizadas

#### **Backend**
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MVC](https://img.shields.io/badge/Arquitetura-MVC-blue?style=for-the-badge)
-   **`vlucas/phpdotenv`**: Para gerenciamento de variáveis de ambiente.

#### **Frontend**
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)

#### **Banco de Dados**
![Postgres](https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white)

#### **Ferramentas de Desenvolvimento**
![Visual Studio Code](https://img.shields.io/badge/Visual%20Studio%20Code-0078d7.svg?style=for-the-badge&logo=visual-studio-code&logoColor=white)
![DBeaver](https://img.shields.io/badge/DBeaver-382b57.svg?style=for-the-badge&logo=dbeaver&logoColor=white)
![Git](https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&logo=git&logoColor=white)
![GitHub](https://img.shields.io/badge/github-%23121011.svg?style=for-the-badge&logo=github&logoColor=white)

---

### 🏗️ Arquitetura e Estrutura do Projeto

O projeto foi construído seguindo o padrão arquitetural **MVC (Model-View-Controller)** para garantir a separação de responsabilidades, facilitar a manutenção e a escalabilidade do código.

A estrutura de diretórios principal é:

```
/
├── config/             # Arquivos de configuração (lêem as variáveis de ambiente)
├── public/             # Ponto de entrada da aplicação (index.php)
├── src/                # Coração da aplicação (código PHP)
│   ├── Controller/
│   ├── Core/
│   └── Model/
├── views/              # Arquivos de template (HTML com PHP)
├── vendor/             # Dependências gerenciadas pelo Composer
├── .env                # (Local, não versionado) Credenciais e senhas
├── .env.example        # (Versionado) Template para o arquivo .env
├── .gitignore          # Arquivos e pastas a serem ignorados pelo Git
└── composer.json       # Definição do projeto e dependências
```

---

### ⚙️ Como Executar o Projeto

Siga os passos abaixo para configurar e executar o projeto em seu ambiente local.

#### **1. Pré-requisitos**

-   PHP 8.1 ou superior
-   Composer
-   PostgreSQL
-   Git

#### **2. Instalação**

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/seu-usuario/sistema-controle-estoque.git](https://github.com/seu-usuario/sistema-controle-estoque.git)
    cd sistema-controle-estoque
    ```

2.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Configure o Banco de Dados:**
    -   No seu cliente de banco de dados (DBeaver), crie um novo banco de dados chamado `controle_estoque`.
    -   Execute o script SQL abaixo para criar todas as tabelas necessárias:

    ```sql
    -- Tabela de Usuários
    CREATE TABLE usuarios (
        id SERIAL PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        data_criacao TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabela de Categorias
    CREATE TABLE categorias (
        id SERIAL PRIMARY KEY,
        nome VARCHAR(100) NOT NULL UNIQUE,
        descricao TEXT
    );

    -- Tabela de Produtos
    CREATE TABLE produtos (
        id SERIAL PRIMARY KEY,
        categoria_id INTEGER,
        nome VARCHAR(255) NOT NULL,
        sku VARCHAR(50) UNIQUE,
        preco NUMERIC(10, 2) DEFAULT 0.00,
        quantidade INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
    );

    -- Tabela de Movimentações de Estoque
    CREATE TABLE movimentos_estoque (
        id SERIAL PRIMARY KEY,
        produto_id INTEGER NOT NULL,
        tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('entrada', 'saida')),
        quantidade INTEGER NOT NULL,
        data_movimento TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
    );

    -- Inserir uma categoria padrão
    INSERT INTO categorias (nome, descricao) VALUES ('Geral', 'Categoria padrão para produtos não classificados.');
    ```

4.  **Configure o Ambiente (`.env`):**
    -   Este projeto usa um arquivo `.env` para gerenciar as variáveis de ambiente e credenciais.
    -   Na raiz do projeto, copie o arquivo de exemplo:
    ```bash
    cp .env.example .env
    ```
    -   Abra o arquivo `.env` que você acabou de criar e preencha a sua senha do banco de dados na variável `DB_PASSWORD`.

5.  **Inicie o Servidor:**
    -   Abra o terminal na raiz do projeto.
    -   Execute o comando para iniciar o servidor embutido do PHP:
    ```bash
    php -S localhost:8000 -t public/
    ```

6.  **Acesse a Aplicação:**
    -   Abra seu navegador e acesse: `http://localhost:8000`
    -   A primeira página que você verá é a de registro. Crie um usuário para começar a usar o sistema!

---

### ✍️ Autor

**Angel Luz**

-   GitHub: [@angelluzk](https://github.com/angelluzk)
-   LinkedIn: [angelitaluz](https://www.linkedin.com/in/angelitaluz)