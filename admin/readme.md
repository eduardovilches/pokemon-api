create instance mysql 
docker-compose up 

enabled extension php.ini
extension=sodium

/admin
# Symfony Project Configuration Steps

1. **Install Symfony and dependencies via Composer:**
   ```bash
   cd admin
   composer install
   ```

2. **Database configuration:**
   - Edit your `.env` or `.env.local` file:
     ```
     DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0"
     ```
   - Replace `db_user`, `db_password`, and `db_name` with your actual MySQL credentials.

3. **JWT configuration:**
   - Generate the SSL keys for JWT:
     ```bash
     mkdir -p config/jwt
     openssl genrsa -out config/jwt/private.pem -aes256 4096
     openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
     ```
   - Set the passphrase in your `.env`:
     ```
     JWT_PASSPHRASE=your_passphrase
     ```

4. **Set up user entity and authentication:**

   - Create migration and migrate:
     ```bash
     php bin/console doctrine:migrations:migrate
     ```

5. **Clear cache and check configuration:**
   ```bash
   php bin/console cache:clear
   ```

6. **Run Symfony server:**
   ```bash
   php -S 127.0.0.1:8000 -t public

   ```

> **Note:**  
> - Make sure the PHP extensions in your `php.ini` are enabled: `pdo_mysql`, `openssl`, `mbstring`, `sodium`, `curl`, `fileinfo`, `gd`, and `zip`.
> - Adjust firewall and access control in `config/packages/security.yaml` as needed for your API endpoints.

### Example: Logging in via the API

Send a POST request to the login endpoint:
127.0.0.1:8000/api/login_check

json body
{
    "username": "professor_user",
    "password": "1234"
}

response 
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NTkzOTkzMjgsImV4cCI6MTc1OTQwMjkyOCwicm9sZXMiOlsiUk9MRV9QUk9GRVNTT1IiLCJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJwcm9mZXNzb3JfdXNlciJ9.CP4sU-LTl-GMJZ3bx96qjzP2VCVaPdt1n8XKoeOpRgNOt6nMHoDH0f62viCSyGvH1LRwGJt93_tScXQixeZDSR_PaWB_dbk3nSlQgT8oIBnydt2SBuqyH5AfVE_d7cDCAdTIU4Yu611nq4mc7nkk9QpjjfgCONpqsvJRDC0PJZddPQnZqYS6mIqnVyWpiKRkosfGsyqPao-DmoiKTzScqPqw9fAJ-slslODQDZmzd3aWqxIrAef1-bljrBxJoXSTn23l05xRs5eniM98RYQc-lVcQ4KBvB-VQCMlbAoM29au621zlEcw3PEbY88BTmFc2jxJHDpgb5sYWR0fdkX9wDj4eqOjSqCKo3ZiAJHRTspyBJ4-uZHA1BLEc2WLTvN-_xCjvu5Rj9m1tCv1EPvyPiXmD613g2ucfLT0VnGHqfPCJnCbZK60SDjFY5Yrz1gNCEF-OnRcZSX9q5ZDRCp2Evgpp5TS4BHGA9l4Q1enFbGxNjxaNi5CN5_vH4PObRlslO-37t4k1HXQG96ZsLJc3Xu0kQvUKmTgN13fYaCb8eXUu_DvTFA00xcCI99Id_IGCac6pRoz1aKiX2EJRV2HIKSb5mORln9ghx3vEHN9StZbmcS2GColib232jlvE7sd8hUfNMD-n0k7GTXet5FoS3WCe1w14xRRmrCTYPqsz_A"
}