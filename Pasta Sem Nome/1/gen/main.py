import os
import sys

def create_directory(path):
    if not os.path.exists(path):
        os.makedirs(path)
        print(f"Diretório criado: {path}")

def create_file(path, content=""):
    with open(path, 'w') as file:
        file.write(content)
    print(f"Ficheiro criado: {path}")

def create_project_structure(base_path):
    # Criar diretórios principais
    create_directory(f"{base_path}/app")
    create_directory(f"{base_path}/app/config")
    create_directory(f"{base_path}/app/controllers")
    create_directory(f"{base_path}/app/models")
    create_directory(f"{base_path}/app/views")
    create_directory(f"{base_path}/app/views/templates")
    create_directory(f"{base_path}/app/public")
    create_directory(f"{base_path}/app/public/js")
    create_directory(f"{base_path}/app/public/uploads")
    create_directory(f"{base_path}/app/public/uploads/profile_images")

    # Criar arquivos básicos vazios
    # Config
    create_file(f"{base_path}/app/config/config.php", "<?php\n// Configurações do projeto\n")
    
    # Arquivo index principal
    create_file(f"{base_path}/app/index.php", "<?php\n// Ponto de entrada da aplicação\n")
    
    # .htaccess
    create_file(f"{base_path}/app/.htaccess", "# Configurações de rewrite para URLs\n")
    
    # Controladores
    controllers = [
        'AuthController',
        'HomeController',
        'ProfileController',
        'BrowseController',
        'SearchController',
        'ChatController',
        'NotificationController'
    ]
    
    for controller in controllers:
        create_file(f"{base_path}/app/controllers/{controller}.php", "<?php\n// Controlador {controller}\n")
    
    # Modelos
    models = [
        'User',
        'Like',
        'Message',
        'Notification',
        'Tag',
        'Image',
        'Block'
    ]
    
    for model in models:
        create_file(f"{base_path}/app/models/{model}.php", "<?php\n// Modelo {model}\n")
    
    # Templates
    create_file(f"{base_path}/app/views/templates/header.php", "<!DOCTYPE html>\n<!-- Header da aplicação -->\n")
    create_file(f"{base_path}/app/views/templates/footer.php", "<!-- Footer da aplicação -->\n</html>")
    
    # Vistas
    views = [
        '404',
        'home',
        'login',
        'register',
        'profile',
        'profile_edit',
        'browse',
        'search',
        'chat',
        'notifications',
        'reset_password'
    ]
    
    for view in views:
        create_file(f"{base_path}/app/views/{view}.php", "<?php\n// Vista {view}\n")
    
    # JavaScript básico
    create_file(f"{base_path}/app/public/js/script.js", "// JavaScript principal da aplicação\n")

    print("\nEstrutura básica do projeto Web Matcha criada com sucesso!")

if __name__ == "__main__":
    if len(sys.argv) > 1:
        base_path = sys.argv[1]
    else:
        base_path = "."  # Diretório atual se nenhum caminho for fornecido
    
    create_project_structure(base_path)
