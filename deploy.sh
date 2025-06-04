#!/bin/bash

# --- Script de Deploy para XAMPP htdocs ---

# Define o diretório htdocs do seu XAMPP
# ATENÇÃO: Se o seu XAMPP estiver em outro local, ajuste este caminho.
XAMPP_HTDOCS_DIR="/c/xampp/htdocs"

# Define o diretório de origem onde seus arquivos de aplicação estão.
# Isso assume que o script será executado a partir da raiz da sua pasta de aplicação.
SOURCE_DIR="./" 

# --- IMPORTANTE: Configure a pasta de destino da sua aplicação no htdocs ---
# Esta será a subpasta dentro do htdocs onde sua aplicação ficará.
# Por exemplo, se você quer que sua aplicação seja acessada por http://localhost/minha_app,
# defina esta variável como "minha_app".
APP_SUBFOLDER="pi_web"

# Combina os caminhos para formar o diretório de destino completo
DESTINATION_DIR="$XAMPP_HTDOCS_DIR/$APP_SUBFOLDER"

echo "Iniciando o deploy..."
echo "Diretório de origem: $SOURCE_DIR"
echo "Diretório de destino: $DESTINATION_DIR"

# Cria o diretório de destino se ele não existir
if [ ! -d "$DESTINATION_DIR" ]; then
    echo "Criando diretório de destino: $DESTINATION_DIR"
    mkdir -p "$DESTINATION_DIR"
else
    echo "Diretório de destino já existe."
fi

# Limpa o deploy anterior (opcional, mas recomendado para deploys limpos)
echo "Limpando arquivos anteriores em $DESTINATION_DIR..."
# ATENÇÃO: Este comando apaga TUDO dentro da pasta de destino. Use com cuidado!
rm -rf "$DESTINATION_DIR"/*

# Copia os arquivos para o diretório htdocs do XAMPP
echo "Copiando arquivos da aplicação para $DESTINATION_DIR..."
cp -r "$SOURCE_DIR"* "$DESTINATION_DIR"/

echo "Deploy concluído!"
echo "Sua aplicação deve estar acessível em http://localhost/$APP_SUBFOLDER/"