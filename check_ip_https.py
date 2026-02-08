import socket
import ssl

def check_ip_https():
    hostname = '76.13.168.33'
    try:
        with socket.create_connection((hostname, 443), timeout=5) as sock:
            print(f"IP {hostname} is listening on 443")
            return True
    except Exception as e:
        print(f"IP {hostname} check failed: {e}")
        return False

if __name__ == "__main__":
    check_ip_https()
