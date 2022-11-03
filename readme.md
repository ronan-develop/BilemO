# BileMo

### <u>Codacy Quality :</u>
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/04711dbfcc264ddd97630204b26d8fc2)](https://www.codacy.com/gl/ron2cuba/bilemo/dashboard?utm_source=gitlab.com&amp;utm_medium=referral&amp;utm_content=ron2cuba/bilemo&amp;utm_campaign=Badge_Grade)

web service exposing a rest api

## <u>Setup</u>
1. Clone repository and installing dependencies with your bash.
```bash
git clone https://gitlab.com/ron2cuba/bilemo.git && composer install
```
2. configure database in `.env` or `.env.local` <i><small>(prefer .env.local)</small></i>

Example for mysql:
```.dotenv
DATABASE_URL="mysql://"LOGIN DATABASE":"PASSWORD DATABASE"@127.0.0.1:3306/"NAME OF YOUR DATABASE"?serverVersion=8&charset=utf8mb4"
```
3. Launch command in your bash
```bash
doctrine:database:create
```
4. Create a `JWT` Folder <u><big>in</big></u> `config` folder
5. Generate private key:
```bash
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
```
6. Generate public key
```bash
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
Your keys will land in config/jwt/private.pem and config/jwt/public.pem
7. install certificate for ssl
```bash
server:ca:install
```
8. Start the Symfony web server with SSL (exemple with symfony binary)
```bash
symfony serve -d
```
9. Read documentation

```txt
https://127.0.0.1:8000/api/doc
```
10. Generate a token with login_check route