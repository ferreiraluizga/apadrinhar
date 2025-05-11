<p align="center">
    <img src="https://skillicons.dev/icons?i=php,html,css,js,bootstrap,mysql"/>
</p>

<p align="center">
    <img src="https://img.shields.io/github/repo-size/ferreiraluizga/apadrinhar?" alt="GitHub repo size"/>
    <img src="https://img.shields.io/badge/languages-4-blue" alt="GitHub language count"/>
    <img src="https://img.shields.io/badge/status-completed-green" alt="Project status"/>
</p>

<h1 align="center">Apadrinhar</h1>

### ℹ O que é o Apadrinhar?
O **Apadrinhar** é um sistema web desenvolvido para a Comunidade Revival & Adoração, para organização de eventos internos e controle de membros. O sistema conta com:
- [x] **Painel Responsivo:** Visualização adaptável para diferentes tamanhos de tela, que possibilita uma edição de dados em todos os lugares.
- [x] **Perfis Personalizados para cada Usuário:** Cada usuário cadastrado pode personalizar seu perfil, e realizar uma análise de sua personalidade, e fazer o mesmo com cada membro que cadastrar.
- [x] **Sistema de Mensagens:** Um sistema de envio de mensagens privadas entre os usuários, para falar de membros e eventos específicos.
- [x] **Registros Privados e Públicos:** O usuário pode definir se os eventos marcados por ele são privados para os administradores, ou públicos para os demais usuários, possibilitando um sistema de feedback a cada evento cadastrado.

## 💻 Requisitos Mínimos

Verifique se você atende aos requisitos antes de instalar o projeto:
- Sistema Operacional: `Windows 10 ou 11`
- Conexão à Internet: `Sim`
- Armazenamento: mínimo de `1GB` disponíveis
- Gerenciamento do Banco de Dados e Servidor Local: `XAMPP 8.2`

## 🚀 Instalação

Siga os passos abaixo para instalar de forma correta:

1. Baixe o arquivo ZIP desta branch ou clone o repositório em sua máquina:
```
git clone https://github.com/ferreiraluizga/apadrinhar.git
```

2. Em seu `PHPMyAdmin`, importe o banco de dados contido no arquivo `juventude.sql`

3. Coloque a pasta do repositório no diretório `xampp/htdocs` e mude o nome da pasta para `juventude`

4. Em seu navegador digite a URL `localhost/juventude`
> O sistema apresentará uma tela de login, e para acessá-lo em suas duas camadas use um dos seguintes: <br>
> **Administrador** = usuário: admin, senha: admin <br>
> **Usuário Comum** = usuário: comum, senha: comum

Após esses passos concluídos, a aplicação está pronta para uso
> Para que a aplicação funcione corretamente, é necessário manter os serviços `Apache` e `MySql` do XAMPP ativos
