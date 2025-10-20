🌾 Vicz Implementos — Site Oficial

Repositório do site institucional da Vicz Implementos, empresa especializada em implementos agrícolas.
O site está em produção e 100% funcional em:
👉 https://viczimplementos.com.br

🧭 Visão Geral

Este projeto foi desenvolvido para apresentar os produtos da Vicz Implementos, oferecer informações institucionais e permitir contato direto com a empresa.
A arquitetura prioriza simplicidade, rapidez e compatibilidade com hospedagens PHP tradicionais (cPanel, Apache, etc.).

✨ Principais Recursos

Página inicial com destaques institucionais e chamadas para ação (WhatsApp e orçamento).

Catálogo completo de implementos agrícolas com páginas individuais.

Sistema de busca em PHP para facilitar a navegação entre produtos.

Páginas institucionais (“Sobre nós”, “Contato”).

Formulário de contato funcional via PHP.

Estrutura otimizada para SEO básico (meta tags, URLs limpas, .htaccess).

Totalmente compatível com mobile (responsivo).

⚙️ Stack Técnica

Backend: PHP 7.4+ (recomendado PHP 8.x)

Servidor: Apache / cPanel

Banco de dados: MySQL / MariaDB (opcional, conforme módulos)

Frontend: HTML5, CSS3 (sem dependências externas pesadas)

🚀 Rodando Localmente
Pré-requisitos

PHP 7.4+ instalado

(Opcional) MySQL configurado

Passos
git clone https://github.com/mordren/vicz_site.git
cd vicz_site
php -S localhost:8000


Depois acesse: http://localhost:8000

Se houver conexão com banco de dados, edite o arquivo de configuração dentro da pasta /db/.

🧩 Configurações

Banco de Dados: ajustar credenciais em db/config.php (se existir).

Uploads: a pasta /uploads/ precisa de permissão de escrita (chmod 755 ou 775).

Formulário: recomenda-se configurar o e-mail de destino em contato.php ou em um arquivo separado de configuração.

🔒 Boas Práticas de Segurança

Sanitizar entradas de formulários (evitar SQL Injection e XSS).

Usar HTTPS em produção.

Proteger áreas administrativas (caso existam) com autenticação.

Não deixar arquivos de configuração expostos publicamente.

🧭 Rotas Principais
Página	Caminho	Descrição
Home	/	Página inicial
Implementos	/implementos.php	Catálogo de produtos
Produto individual	/implemento.php?id=...	Página do produto
Busca	/busca.php?q=...	Resultados da busca
Sobre nós	/sobre.php	História da empresa
Contato	/contato.php	Formulário e informações de contato
🛣️ Melhorias Futuras (Opcional)

Adicionar painel administrativo (CRUD) protegido por login.

Implementar sitemap.xml e robots.txt automáticos.

Otimizar SEO por produto (meta-tags dinâmicas).

Cache simples via PHP para páginas estáticas.

Compressão automática de imagens.

📦 Deploy

Suba todos os arquivos para o diretório public_html/ do domínio.

Garanta que o PHP 8.x esteja ativo no painel de hospedagem.

Verifique o .htaccess e as permissões das pastas (uploads/).

Teste o formulário de contato (PHP mail ou SMTP).
