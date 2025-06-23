# Instruções para Rodar o Projeto

## 1. Acessar o Repositório do Git e Baixar o Projeto

1. Acesse o repositório do projeto no GitHub.
   ```
   https://github.com/EDuDz27/BestPrice-ecommerce
   ```
3. Faça o download do projeto ou clone o repositório na sua máquina local com o comando:
   ```sh
   git clone https://github.com/EDuDz27/BestPrice-ecommerce.git
   ```

---

## 2. Instalar o XAMPP

1. Baixe e instale o XAMPP a partir do site oficial: [Apache Friends](https://www.apachefriends.org/index.html).
2. Após a instalação, abra o painel de controle do XAMPP e ligue os servidores **Apache** e **MySQL**.

---

## 3. Criar o Banco de Dados no MySQL

1. No painel de controle do XAMPP, clique em **"Admin"** ao lado de MySQL para acessar o phpMyAdmin.
2. No phpMyAdmin, clique em **"Novo"** para criar um novo banco de dados.
3. Digite o nome do banco de dados **"ecommerce"** e clique em **"Criar"**.
4. Após criar o banco de dados:
   - Abra o SQL do phpMyAdmin.
   - Execute o script para criar as tabelas.
   - O código de criação das tabelas está disponível google drive, link para o arquivo ".sql"
     ```
     https://drive.google.com/drive/folders/1cL6nlDyivvx65J52VSPi_zo3GcR3vnq9?usp=drive_link
     ```

---

## 4. Configurar a Conexão com o Banco de Dados

1. No repositório do projeto, localize o arquivo:
   ```
   config\database.php
   ```
2. Abra esse arquivo e ajuste as credenciais do banco de dados (usuário, senha, nome do banco) conforme sua configuração do MySQL.
3. **Nota**: Caso tenha seguido os passos corretamente e seu mySQL Xampp esteja na configuração padrão, não será necessário alterar nada.

---

## 5. Rodar o Projeto no Navegador

1. Crie uma nova pasta chamada "BestPrice" na pasta **htdocs** dentro da instalação do XAMPP e mova os arquivos do projeto baixado para a pasta:
   ```
   htdocs/BestPrice
   ```
2. No navegador, digite:
   ```
   localhost/BestPrice/
   ```

---

## 6. Verificar o Funcionamento do Projeto

Após acessar **localhost/BestPrice**, o projeto deverá estar funcionando corretamente no seu navegador.

---

## 📌 Observações Finais

- **Recomendamos utilizar:**
  - **XAMPP v3.3.0**

Caso encontre problemas, verifique se:
- O XAMPP está executando corretamente.
- O banco de dados foi criado corretamente e as tabelas foram importadas.
- A configuração do banco de dados está correta no arquivo **database.php**.

---

🚀 **Agora você está pronto para rodar o projeto!**

