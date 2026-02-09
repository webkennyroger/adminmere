import paramiko
import time
import sys

def deploy():
    ip = '76.13.168.33'
    username = 'root'
    password = 'Mere-887521.'
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    
    try:
        print(f"Connecting to {ip}...")
        ssh.connect(ip, username=username, password=password, timeout=30)
        print("Connected!")
        
        commands = [
            'cd /var/www/adminmere && git fetch origin && git reset --hard origin/main', # Force sync
            'cd /var/www/adminmere && composer install --no-interaction --optimize-autoloader',
            # 'cd /var/www/adminmere && rm -rf node_modules package-lock.json', # Commented out to save time if not needed immediately
            'cd /var/www/adminmere && npm install',
            'cd /var/www/adminmere && npm run build 2>&1', # Capture error output
            'cd /var/www/adminmere && php artisan view:clear',
            'cd /var/www/adminmere && php artisan optimize:clear'
        ]
        
        for cmd in commands:
            print(f"\nExecuting: {cmd}")
            stdin, stdout, stderr = ssh.exec_command(f"bash -l -c '{cmd}'")
            
            # Stream output
            while True:
                line_bytes = stdout.channel.recv(1024)
                if not line_bytes:
                    break
                sys.stdout.buffer.write(line_bytes)
                sys.stdout.buffer.flush()
                
            status = stdout.channel.recv_exit_status()
            print(f"\nExit status: {status}")
            
    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        ssh.close()
        print("\nConnection closed.")

if __name__ == "__main__":
    deploy()
