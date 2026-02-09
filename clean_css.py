
import os

file_path = r'c:\Users\o_fer\Herd\adminmere\resources\css\app.css'

with open(file_path, 'rb') as f:
    content = f.read()

target_str = b'[x-cloak] { display: none !important; }'
target_index = content.rfind(target_str)

if target_index != -1:
    # Keep up to the end of target_str
    new_content = content[:target_index + len(target_str)]
    with open(file_path, 'wb') as f:
        f.write(new_content)
    print("Cleaned CSS file.")
else:
    print("Target string not found.")
