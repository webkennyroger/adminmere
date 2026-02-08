import paramiko

def check_manifest():
    ip = '76.13.168.33'
    username = 'root'
    password = 'Mere-887521.'
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        ssh.connect(ip, username=username, password=password)
        command = 'cat /var/www/adminmere/public/build/manifest.json'
        stdin, stdout, stderr = ssh.exec_command(command)
        print(stdout.read().decode())
        ssh.close()
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    check_manifest()
