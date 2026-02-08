import paramiko
import sys

def build_with_logs():
    ip = '76.13.168.33'
    username = 'root'
    password = 'Mere-887521.'
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        ssh.connect(ip, username=username, password=password)
        command = 'cd /var/www/adminmere && npm run build 2>&1'
        print(f"Executing: {command}")
        stdin, stdout, stderr = ssh.exec_command(command)
        
        output = stdout.read()
        print(output.decode('utf-8', errors='replace'))
        
        ssh.close()
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    build_with_logs()
