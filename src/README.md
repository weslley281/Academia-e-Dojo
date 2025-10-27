# Sistema de Gestão para Academia de Artes Marciais

Este é um sistema web leve e prático construído em PHP, destinado à administração de academias e dojos de artes marciais.

---

## Funcionalidades Principais

O sistema cobre as principais necessidades de gestão de uma academia, incluindo:

- **Gestão de Usuários:** Cadastro e diferenciação de usuários por tipo (Admin, Instrutor, Aluno).
- **Controle Financeiro:**
    - **Fluxo de Caixa:** Abertura e fechamento de caixa diário.
    - **Checkout:** Um PDV (Ponto de Venda) para registrar vendas de planos e produtos.
    - **Gestão de Mensalidades:** Um módulo dedicado para controlar mensalidades pendentes, atrasadas e pagas, com um fluxo para registro de pagamentos.
- **Gestão de Aulas:**
    - Cadastro de **Artes Marciais**.
    - Cadastro de **Turmas/Modalidades**, associando-as a uma arte marcial, instrutor, horários e valor.
- **Geração de Relatórios:** Capacidade de gerar documentos em PDF (usando a biblioteca `dompdf`).

---

## Tecnologias Utilizadas

- **Backend:** PHP (puro, utilizando uma arquitetura similar ao MVC).
- **Banco de Dados:** MySQL / MariaDB.
- **Frontend:** HTML, CSS, JavaScript (puro).
- **Bibliotecas Frontend:**
    - **Bootstrap:** Para a estrutura de layout e componentes de UI.
    - **jQuery:** Para manipulação do DOM e eventos.
    - **DataTables:** Para criar tabelas interativas com paginação e busca.
    - **FontAwesome:** Para os ícones.

---

## Estrutura do Projeto

O projeto segue uma organização que separa as responsabilidades, facilitando a manutenção:

- `/config`: Arquivos de configuração, como a conexão com o banco de dados (`db.php`) e a estrutura das tabelas (`CreateTables.php`).
- `/controllers`: Contêm a lógica de negócio. Recebem as requisições do usuário, processam os dados e interagem com os Models.
- `/models`: Classes que representam as tabelas do banco de dados e contêm todos os métodos para interagir com elas (criar, ler, atualizar, deletar - CRUD).
- `/views`: Arquivos de apresentação (HTML misturado com PHP) que exibem as informações para o usuário.
- `/utils`: Scripts com funções auxiliares usadas em várias partes do sistema (autenticação, alertas, etc.).
- `/libs`: Bibliotecas de terceiros (Bootstrap, jQuery, etc.).
- `index.php`: O arquivo principal que atua como **roteador**. Ele recebe as requisições e decide qual página (View) carregar.

---

## Como Rodar o Projeto

1.  **Ambiente:** Certifique-se de ter um ambiente de servidor web com PHP e MySQL (WAMP, LAMP, XAMPP, etc.).
2.  **Arquivos:** Coloque a pasta do projeto no diretório raiz do seu servidor web (ex: `www/` ou `htdocs/`).
3.  **Banco de Dados:** Crie um novo banco de dados no seu MySQL (ex: `academia_dojo`).
4.  **Configuração:**
    - Renomeie ou crie o arquivo `config/db.php`.
    - Edite este arquivo com as suas credenciais de acesso ao banco de dados (host, nome de usuário, senha, nome do banco).
5.  **Execução:**
    - Acesse o projeto pelo seu navegador (ex: `http://localhost/Academia-e-Dojo/`).
    - O script em `index.php` foi programado para chamar as funções de `config/CreateTables.php` e criar a estrutura inicial do banco de dados automaticamente na primeira execução.
    - Um usuário administrador padrão também é criado na primeira execução.

---

## Como Editar a Lógica do Programa

Entender a arquitetura MVC-like é a chave para modificar o sistema:

- **Para alterar algo visual (uma página, uma tabela, um formulário):**
    - Vá para a pasta `/views`.
    - Encontre a subpasta e o arquivo correspondente à tela que você quer mudar. Por exemplo, para mudar a lista de usuários, edite `/views/user/index.php`.

- **Para alterar uma consulta ao banco de dados (buscar um dado diferente, salvar um novo campo):**
    - Vá para a pasta `/models`.
    - Encontre o Model correspondente à informação que você quer manipular. Por exemplo, para mudar como os dados de um pagamento de mensalidade são salvos, edite `models/MonthlyFee.php`.

- **Para alterar uma ação ou regra de negócio (o que acontece quando um formulário é enviado):**
    - Vá para a pasta `/controllers`.
    - Encontre o Controller que gerencia a lógica daquela seção. Por exemplo, para mudar o que acontece ao registrar o pagamento de uma mensalidade, edite `controllers/MonthlyFeeController.php`.

- **Para adicionar uma página nova:**
    1.  Crie o arquivo da view em `/views` (ex: `/views/reports/new_report.php`).
    2.  Se necessário, crie um Model e um Controller para ela.
    3.  Vá ao `index.php` e adicione um novo `case` ao `switch` principal para que o sistema reconheça a sua nova página (ex: `case 'new_report':`).
    4.  Adicione o link para a sua nova página no menu em `views/navbar.php`.
