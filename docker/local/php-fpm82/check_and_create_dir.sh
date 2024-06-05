#!/bin/bash

DIRECTORY=${DIRECTORY_PATH:-"/var/www/html/storage"}

# Проверяем, существует ли папка
if [ ! -d "$DIRECTORY" ]; then
  # Если папка не существует, создаем её
  mkdir -p "$DIRECTORY"
fi
