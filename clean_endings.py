import os

def clean_file(filepath):
    with open(filepath, 'rb') as f:
        content = f.read()
    
    # Replace \r\n and lone \r with \n
    new_content = content.replace(b'\r\n', b'\n').replace(b'\r', b'\n')
    
    if content != new_content:
        with open(filepath, 'wb') as f:
            f.write(new_content)
        print(f"Cleaned {filepath}")

for root, dirs, files in os.walk('.'):
    if 'vendor' in dirs:
        dirs.remove('vendor')
    if 'node_modules' in dirs:
        dirs.remove('node_modules')
    if '.git' in dirs:
        dirs.remove('.git')
        
    for file in files:
        if file.endswith('.php') or file == 'artisan':
            clean_file(os.path.join(root, file))
