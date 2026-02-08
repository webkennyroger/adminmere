import socket
import ssl

def check_https():
    hostname = 'kennyroger.com.br'
    context = ssl.create_default_context()
    try:
        with socket.create_connection((hostname, 443), timeout=5) as sock:
            with context.wrap_socket(sock, server_hostname=hostname) as ssock:
                print(f"HTTPS is available on {hostname}")
                return True
    except Exception as e:
        print(f"HTTPS check failed: {e}")
        return False

if __name__ == "__main__":
    check_https()
