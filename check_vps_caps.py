import paramiko

def check_caps():
    ip = '76.13.168.33'
    username = 'root'
    password = 'Mere-887521.'
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        ssh.connect(ip, username=username, password=password)
        commands = [
            'ls -d /var/www/adminmere/app/*',
            'ls -d /var/www/adminmere/app/Http/*'
        ]
        for cmd in commands:
            print(f"--- {cmd} ---")
            stdin, stdout, stderr = ssh.exec_command(cmd)
            print(stdout.read().decode())
        ssh.close()
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    check_caps()
