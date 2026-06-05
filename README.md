# 🏨 Sistema de Gestão Hoteleira

Sistema web desenvolvido em **Laravel** para gerir as operações de um hotel — reservas, quartos, hóspedes e muito mais.

---

## 📋 Requisitos

Antes de começar, certifica-te de que tens instalado:

- [PHP](https://www.php.net/) >= 8.1
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) >= 5.7
- Extensões PHP necessárias: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`

---

## 🚀 Instalação e configuração

### 1. Clonar o repositório

```bash
git clone https://github.com/teu-usuario/nome-do-repo.git
cd nome-do-repo
```

### 2. Instalar as dependências PHP

```bash
composer install
```

### 3. Configurar o ficheiro de ambiente

Copia o ficheiro de exemplo e cria o teu `.env`:

```bash
cp .env.example .env
```

Abre o `.env` e preenche as configurações da base de dados:

```env
APP_NAME="Sistema de Gestão Hoteleira"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_da_base_de_dados
DB_USERNAME=root
DB_PASSWORD=a_tua_password
```

### 4. Gerar a chave da aplicação

```bash
php artisan key:generate
```

### 5. Criar a base de dados

No MySQL, cria uma base de dados com o mesmo nome que definiste no `.env`:

```sql
CREATE DATABASE nome_da_base_de_dados CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Executar as migrações

```bash
php artisan migrate
```

Se o projecto tiver dados iniciais (seeders):

```bash
php artisan db:seed
```

Ou em conjunto:

```bash
php artisan migrate --seed
```

### 7. Iniciar o servidor de desenvolvimento

```bash
php artisan serve
```

A aplicação estará disponível em: [http://localhost:8000](http://localhost:8000)

---

## 🔐 Autenticação

O sistema possui módulo de autenticação com login e registo de utilizadores.

Após executar os seeders, podes entrar com as credenciais padrão (se configuradas):

```
Email:    admin@hotel.com
Password: password
```

> ⚠️ Altera as credenciais padrão após o primeiro acesso.

---

## 🛠️ Tecnologias utilizadas

| Tecnologia | Versão | Função |
|---|---|---|
| [Laravel](https://laravel.com) | 10.x / 11.x | Framework principal (PHP) |
| [Composer](https://getcomposer.org) | 2.x | Gestão de dependências PHP |
| [MySQL](https://www.mysql.com) | 5.7+ | Base de dados relacional |
| [Blade](https://laravel.com/docs/blade) | — | Motor de templates |

---

## 📁 Estrutura do projecto

```
├── app/
│   ├── Http/Controllers/   # Controladores da aplicação
│   ├── Models/             # Modelos Eloquent
│   └── ...
├── database/
│   ├── migrations/         # Migrações da base de dados
│   └── seeders/            # Dados iniciais
├── resources/
│   ├── views/              # Templates Blade
│   └── ...
├── routes/
│   └── web.php             # Rotas da aplicação
└── .env.example            # Exemplo de configuração
```

---

## ⚙️ Comandos úteis

```bash
# Limpar cache da aplicação
php artisan cache:clear

# Limpar cache de configuração
php artisan config:clear

# Listar todas as rotas
php artisan route:list

# Reverter e recriar todas as migrações
php artisan migrate:fresh --seed
```

---

## 🤝 Contribuição

Contribuições são bem-vindas! Para contribuir:

1. Faz um fork do repositório
2. Cria um branch para a tua funcionalidade (`git checkout -b feature/nova-funcionalidade`)
3. Faz commit das alterações (`git commit -m 'Adiciona nova funcionalidade'`)
4. Faz push para o branch (`git push origin feature/nova-funcionalidade`)
5. Abre um Pull Request

---

## 📄 Licença

Este projecto está licenciado sob a licença [MIT](https://opensource.org/licenses/MIT).
