
## Yükleme

```bash 
  cd contactapp
```

```bash 
  cp .env.example .env
```
  
```bash 
  docker-compose up -d
```
  
```bash 
  composer install
```
  
```bash 
  ./vendor/bin/sail artisan:migrate --seed
```
  
```bash 
  ./vendor/bin/sail passport:client --personal -n
```
  
```bash 
  yarn build
```

## Test için kullanıcı bilgileri
* http://localhost:8080
* Mail: test@example.com
* Password: password
